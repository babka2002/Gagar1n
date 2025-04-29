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

    public function index(Request $request)
    {
        $currentSite = strtolower(Site::current()->handle());

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
            ->layout($currentSite . '/layout')
            ->template($currentSite . '/schedule')
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

        // 1. Фильтр по залу (если выбран)
        if (!empty($selectedFilters)) {
            $selectedFiltersLower = array_map('mb_strtolower', $selectedFilters);
            $locationFilteredData = [];
            foreach ($filteredData as $item) {
                if (isset($item['room']['title'])) {
                    $roomTitleLower = mb_strtolower($item['room']['title']);
                    if (in_array($roomTitleLower, $selectedFiltersLower)) {
                        $locationFilteredData[] = $item;
                    }
                }
            }
            $filteredData = $locationFilteredData; // Обновляем данные после фильтрации по залу
        }

        // 2. Фильтр по возрасту (если выбран и не 'любые')
        if ($selectedAge && $selectedAge !== 'любые') {
            $ageFilteredData = [];
            $isKidsFilter = ($selectedAge === 'детские');

            foreach ($filteredData as $item) {
                $isKidsEvent = false;
                // Проверяем наличие 'kids' или '(дети)' в релевантных полях
                $checkTitles = [
                    $item['service']['title'] ?? '',
                    $item['group']['title'] ?? '',
                    $item['course']['title'] ?? '',
                ];
                foreach ($checkTitles as $title) {
                    if (mb_stripos($title, 'kids') !== false || mb_stripos($title, '(дети)') !== false) {
                        $isKidsEvent = true;
                        break;
                    }
                }

                if ($isKidsFilter && $isKidsEvent) { // Нужны детские, и это детское
                    $ageFilteredData[] = $item;
                } elseif (!$isKidsFilter && !$isKidsEvent) { // Нужны взрослые, и это не детское
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
                // Проверяем платность: по полю commercial ИЛИ по наличию ₽ в названии
                $isActuallyPaid = (isset($item['commercial']) && $item['commercial'] === true)
                    || (isset($item['service']['title']) && mb_strpos($item['service']['title'], '₽') !== false);

                if ($isPaidFilter && $isActuallyPaid) { // Нужны платные, и это платное
                    $costFilteredData[] = $item;
                } elseif (!$isPaidFilter && !$isActuallyPaid) { // Нужны бесплатные, и это бесплатное
                    $costFilteredData[] = $item;
                }
            }
            $filteredData = $costFilteredData; // Обновляем данные после фильтрации по стоимости
        }

        // dd($filteredData);
        return array_values(array_unique($filteredData, SORT_REGULAR)); // Удаляем дубликаты, если они возникли
    }
}
