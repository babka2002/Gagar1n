<?php

namespace App\Http\Controllers;

use App\Services\GroupClassesService;
use App\Services\PersonalClassesService;
use Illuminate\Http\Request;
use Statamic\View\View;
use Statamic\Facades\Site;
use Statamic\Facades\Entry;
use Carbon\Carbon;
use Statamic\Entries\Entry as EntryModel;

class ScheduleController extends Controller
{
    private GroupClassesService $groupService;
    private PersonalClassesService $personalService;

    public function __construct(
        GroupClassesService $groupService,
        PersonalClassesService $personalService
    ) {
        $this->groupService = $groupService;
        $this->personalService = $personalService;
    }

    /**
     * Определяет сайт на основе URL
     */
    private function getSiteFromUrl(): string
    {
        $url = request()->getPathInfo();

        if (str_starts_with($url, '/gun1or')) {
            return 'Gun1or';
        } elseif (str_starts_with($url, '/gfoodcafe')) {
            return 'GFoodcafe';
        } else {
            return 'Grelka';
        }
    }

    public function index(Request $request)
    {
        // Определяем сайт на основе URL (как в TrainerController)
        $currentSite = $this->getSiteFromUrl();

        if (!$request->has('start_date') || empty($request->input('start_date'))) {
            $request->merge(['start_date' => Carbon::now()->startOfWeek()->format('Y-m-d H:i')]);
        }

        if (!$request->has('end_date') || empty($request->input('end_date'))) {
            $request->merge(['end_date' => Carbon::now()->endOfWeek()->format('Y-m-d H:i')]);
        }

        $clubId = '49964502-5659-11eb-e291-ac162d836873';
        $params = $request->only(['start_date', 'end_date', 'service_id', 'employee_id']);
        $params['club_id'] = $clubId;

        // Получаем тип расписания
        $scheduleType = $request->input('schedule_type', 'classes');

        // Выбираем нужный сервис
        $service = $scheduleType === 'personal'
            ? $this->personalService
            : $this->groupService;

        $scheduleData = $service->getSchedule($params);
        if (empty($scheduleData)) {
            return response()->json(['message' => 'Нет данных для отображения.'], 404);
        }

        // Фильтруем данные по типу
        $scheduleData = array_filter($scheduleData, function ($item) use ($scheduleType) {
            return isset($item['type']) && $item['type'] === $scheduleType;
        });

        // Дополнительная фильтрация для Gun1or (детские занятия)
        if ($currentSite === 'Gun1or') {
            $scheduleData = array_filter($scheduleData, function ($item) {
                // Фильтруем только детские занятия
                $checkTitles = [
                    $item['service']['title'] ?? '',
                    $item['group']['title'] ?? '',
                    $item['course']['title'] ?? '',
                ];
                foreach ($checkTitles as $title) {
                    if (
                        mb_stripos($title, 'kids') !== false ||
                        mb_stripos($title, '(дети)') !== false ||
                        mb_stripos($title, 'детск') !== false ||
                        mb_stripos($title, 'junior') !== false
                    ) {
                        return true;
                    }
                }
                return false;
            });
        }

        $filteredData = $this->applyFilters($scheduleData, $request);
        $timeSlots = $this->generateTimeSlots($filteredData);
        $daysOfWeek = $this->prepareDaysOfWeek($filteredData, $timeSlots);
        $currentDay = Carbon::now()->locale('ru')->isoFormat('dddd');

        // Get data from the current Entry based on URI
        $uri = '/' . trim($request->path(), '/');
        $entry = Entry::findByUri($uri, Site::current()->handle());

        $metaDescription = null;
        $metaKeywords = null;
        $pageTitle = 'Расписание'; // Default title

        if ($entry) {
            /** @var EntryModel $entry */
            $metaDescription = $entry->get('field_meta_description');
            $metaKeywords = $entry->get('field_meta_keywords');
            $pageTitle = $entry->get('title', 'Расписание'); // Get title from entry or default
        }

        return (new View)
            ->layout(strtolower($currentSite) . '/layout')
            ->template(strtolower($currentSite) . '/schedule')
            ->with([
                'timeSlots' => $timeSlots,
                'daysOfWeek' => $daysOfWeek,
                'filteredData' => $filteredData,
                'currentDay' => $currentDay,
                'scheduleType' => $scheduleType,
                'field_meta_description' => $metaDescription, // Pass meta description
                'field_meta_keywords' => $metaKeywords,      // Pass meta keywords
                'title' => $pageTitle                       // Pass title
            ]);
    }

    private function generateTimeSlots(array $scheduleData): array
    {
        // Get all unique hours that have events
        $hours = [];
        foreach ($scheduleData as $item) {
            $startHour = Carbon::parse($item['start_date'])->startOfHour()->format('H:00');
            $hours[$startHour] = true;
        }

        // Only include hours that have events
        $timeSlots = [];
        for ($hour = 7; $hour <= 20; $hour++) {
            $timeStr = sprintf('%02d:00', $hour);
            if (isset($hours[$timeStr])) {
                $timeSlots[] = $timeStr;
            }
        }

        return $timeSlots;
    }

    private function prepareDaysOfWeek(array $scheduleData, array $timeSlots): array
    {
        $daysOfWeek = [];

        // First, organize events by day
        foreach ($scheduleData as $item) {
            $dayName = Carbon::parse($item['start_date'])->translatedFormat('l');
            $hourSlot = Carbon::parse($item['start_date'])->format('H:00');

            if (!isset($daysOfWeek[$dayName])) {
                $daysOfWeek[$dayName] = [
                    'date' => Carbon::parse($item['start_date'])->format('d'),
                    'name' => $dayName,
                    'schedule' => [],
                ];
            }

            // Add all events to their corresponding hour slot
            foreach ($timeSlots as $timeSlot) {
                $slotHour = Carbon::parse($timeSlot)->format('H:00');
                $itemHour = Carbon::parse($item['start_date'])->format('H:00');

                if ($slotHour === $itemHour) {
                    $item['start_time'] = Carbon::parse($item['start_date'])->format('H:i');
                    $item['end_time'] = Carbon::parse($item['end_date'])->format('H:i');
                    $daysOfWeek[$dayName]['schedule'][] = $item;
                }
            }
        }

        // Add empty slots only for hours that have events
        foreach ($daysOfWeek as $day => $data) {
            $existingSlots = array_map(function ($event) {
                return Carbon::parse($event['start_time'])->format('H:00');
            }, $data['schedule']);

            foreach ($timeSlots as $timeSlot) {
                $slotHour = Carbon::parse($timeSlot)->format('H:00');
                if (!in_array($slotHour, $existingSlots)) {
                    $daysOfWeek[$day]['schedule'][] = [
                        'start_time' => $timeSlot,
                        'end_time' => Carbon::parse($timeSlot)->addHour()->format('H:i'),
                        'event' => null
                    ];
                }
            }
        }

        // Sort schedule by time for each day
        foreach ($daysOfWeek as &$day) {
            usort($day['schedule'], function ($a, $b) {
                return strtotime($a['start_time']) - strtotime($b['start_time']);
            });
        }

        return $daysOfWeek;
    }

    private function applyFilters(array $scheduleData, Request $request): array
    {
        $filteredData = $scheduleData; // Начинаем с полных данных
        $selectedFilters = $request->input('filters', []);
        $selectedAge = $request->input('age'); // 'любые', 'взрослые', 'детские'
        $selectedCost = $request->input('cost'); // 'неважно', 'платно', 'бесплатно'

        // 1. Фильтр по залу и типу занятий (если выбран)
        if (!empty($selectedFilters)) {
            $selectedFiltersLower = array_map('mb_strtolower', $selectedFilters);
            $locationFilteredData = [];
            foreach ($filteredData as $item) {
                $shouldInclude = false;

                // Проверяем фильтр по залу
                if (isset($item['room']['title'])) {
                    $roomTitleLower = mb_strtolower($item['room']['title']);
                    if (in_array($roomTitleLower, $selectedFiltersLower)) {
                        $shouldInclude = true;
                    }
                }

                // Проверяем фильтр по типу занятия (название занятия)
                if (!$shouldInclude && isset($item['service']['title'])) {
                    $serviceTitleLower = mb_strtolower($item['service']['title']);
                    if (in_array($serviceTitleLower, $selectedFiltersLower)) {
                        $shouldInclude = true;
                    }
                }

                // Проверяем фильтр по группе занятия
                if (!$shouldInclude && isset($item['group']['title'])) {
                    $groupTitleLower = mb_strtolower($item['group']['title']);
                    if (in_array($groupTitleLower, $selectedFiltersLower)) {
                        $shouldInclude = true;
                    }
                }

                if ($shouldInclude) {
                    $locationFilteredData[] = $item;
                }
            }
            $filteredData = $locationFilteredData; // Обновляем данные после фильтрации
        }

        // 2. Фильтр по возрасту (если выбран и не 'любые')
        if ($selectedAge && $selectedAge !== 'любые') {
            $ageFilteredData = [];

            foreach ($filteredData as $item) {
                $shouldInclude = false;

                // Проверяем наличие возрастных маркеров в описании занятия
                $description = $item['service']['description'] ?? '';
                $descriptionLower = mb_strtolower($description);

                // Логика фильтрации по возрастным группам на основе описаний
                switch ($selectedAge) {
                    case 'малыш':
                        // Ищем маркеры для малышей в описании
                        $shouldInclude = mb_stripos($descriptionLower, 'малыш') !== false;
                        break;
                    case 'дошкольн':
                        // Ищем маркеры для дошкольников в описании
                        $shouldInclude = mb_stripos($descriptionLower, 'дошкольн') !== false;
                        break;
                    case 'школьн':
                        // Ищем маркеры для школьников в описании
                        $shouldInclude = mb_stripos($descriptionLower, 'школьн') !== false;
                        break;
                    case 'подрост':
                        // Ищем маркеры для подростков в описании
                        $shouldInclude = mb_stripos($descriptionLower, 'подрост') !== false;
                        break;
                    case '5+':
                        // Ищем маркер "5+" в описании
                        $shouldInclude = mb_stripos($descriptionLower, '5+') !== false;
                        break;
                    default:
                        // Для остальных случаев показываем все
                        $shouldInclude = true;
                        break;
                }

                if ($shouldInclude) {
                    $ageFilteredData[] = $item;
                }
            }
            $filteredData = $ageFilteredData; // Обновляем данные после фильтрации по возрасту
        }

        // 3. Фильтр по стоимости (если выбран и не 'неважно')
        if ($selectedCost && $selectedCost !== 'неважно') {
            $costFilteredData = [];
            $isPaidFilter = ($selectedCost === 'платно');

            foreach ($filteredData as $item) {
                // Проверяем платность по символу ₽ в названии занятия или группы
                $isActuallyPaid = false;

                // Проверяем символ ₽ в названии занятия
                if (isset($item['service']['title']) && mb_strpos($item['service']['title'], '₽') !== false) {
                    $isActuallyPaid = true;
                }

                // Проверяем символ ₽ в названии группы
                if (!$isActuallyPaid && isset($item['group']['title']) && mb_strpos($item['group']['title'], '₽') !== false) {
                    $isActuallyPaid = true;
                }

                // Проверяем поле commercial (хотя в данных все false, но на всякий случай)
                if (!$isActuallyPaid && isset($item['commercial']) && $item['commercial'] === true) {
                    $isActuallyPaid = true;
                }

                if ($isPaidFilter && $isActuallyPaid) { // Нужны платные, и это платное
                    $costFilteredData[] = $item;
                } elseif (!$isPaidFilter && !$isActuallyPaid) { // Нужны бесплатные, и это бесплатное
                    $costFilteredData[] = $item;
                }
            }
            $filteredData = $costFilteredData; // Обновляем данные после фильтрации по стоимости
        }

        return array_values(array_unique($filteredData, SORT_REGULAR)); // Удаляем дубликаты, если они возникли
    }

    /**
     * Проверяет, соответствует ли событие определенной возрастной группе
     */
    private function checkAgeGroup(array $titles, array $ageMarkers): bool
    {
        foreach ($titles as $title) {
            foreach ($ageMarkers as $marker) {
                if (mb_stripos($title, $marker) !== false) {
                    return true;
                }
            }
        }

        // Если специфических маркеров возраста НЕТ,
        // НЕ показываем в конкретных возрастных группах (только в общем "детские")
        return false;
    }

    /**
     * Проверяет, является ли событие общим детским (без конкретных возрастных маркеров)
     */
    private function isGeneralKidsEvent(array $titles): bool
    {
        $specificAgeMarkers = [
            'малыш',
            'ясли',
            '3-5',
            '3',
            '4',
            '5',
            'дошкол',
            'подготов',
            '6-8',
            '6',
            '7',
            '8',
            'школьн',
            'младш',
            '9-12',
            '9',
            '10',
            '11',
            '12',
            'подрост',
            'старш',
            '13-16',
            '13',
            '14',
            '15',
            '16'
        ];

        foreach ($titles as $title) {
            foreach ($specificAgeMarkers as $marker) {
                if (mb_stripos($title, $marker) !== false) {
                    return false; // Есть специфический маркер возраста
                }
            }
        }

        return true; // Нет специфических маркеров - общее детское событие
    }
}
