<?php

namespace App\Http\Controllers;

use App\Services\GroupClassesService;
use App\Services\PersonalClassesService;
use Illuminate\Http\Request;
use Statamic\View\View;
use Carbon\Carbon;

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

        $filters = [
            'тренажерный зал' => [
                'САЙКЛ START',
                'САЙКЛ PRO ₽',
                'HIIT',
                'TOTAL BODY ₽',
                'SUPER SCULPT',
                'FUNCTIONAL TRAINING',
                'TRX ₽',
                'BODY SCULPT',
                'PUMP PRO ₽',
                'ABS+CORE',
                'DYNAMIC STRETCHING',
                'STRETCHING',
                'STRETCHING MOBILITY',
                'KICKBOXING KIDS',
                'CROSSFIT',
                'CROSSFIT ₽',
                'CROSSFIT KIDS',
                'CROSSFIT WORK',
                'ZUMBA',
                'DANCE MIX KIDS',
                'AEROBIC DANCE',
                'ART FUNCTIONAL',
                'FITBOX',
                'ORIENTAL FIT',
                'TAE-BO',
                'LATINA',
                'WINTER CYCLING FESTIVAL MK',
            ],
            'аква зона' => [
                'AQUA NOODLES / DUMBBELLS',
                'AQUA MIX',
                'AQUA SWIMMING',
                'AQUA ПЛАВАНИЕ KIDS',
                'AQUA МАМА И МАЛЫШ KIDS',
                'AQUA ГИМНАСТИКА',
                'AQUA ШЕЙПИНГ ₽',
                'AQUA СПОРТ ПОДГОТОВКА KIDS',
                'AQUA НЕ БОЙСЯ ВОДЫ KIDS',
                'Аква ПЛАВАНИЕ KIDS',
            ],
            'йога' => [
                'HATHA YOGA',
                'NIRVANA YOGA',
                'STRETCHING',
            ],
            'детские занятия' => [
                'Аква ПЛАВАНИЕ KIDS',
                'КАРАТЭ KIDS',
                'BOXING KIDS',
                'CROSSFIT KIDS',
                'Аква НЕ БОЙСЯ ВОДЫ KIDS',
                'ГРЭППЛИНГ KIDS',
                'АКРОБАТИКА KIDS',
                'РИТМИКА KIDS',
                'DANCE MIX KIDS',
                'MINI ГРУППА ЛФК ₽',
            ],
            // Добавьте другие категории по мере необходимости
        ];

        $filteredData = $this->applyFilters($scheduleData, $request, $filters);
        $timeSlots = $this->generateTimeSlots($filteredData);
        $daysOfWeek = $this->prepareDaysOfWeek($filteredData, $timeSlots);
        $currentDay = Carbon::now()->locale('ru')->isoFormat('dddd');

        return (new View)
            ->template('schedule')
            ->layout('layout')
            ->with([
                'timeSlots' => $timeSlots,
                'daysOfWeek' => $daysOfWeek,
                'filteredData' => $filteredData,
                'currentDay' => $currentDay,
                'scheduleType' => $scheduleType
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

    private function applyFilters(array $scheduleData, Request $request, array $filters): array
    {
        $filteredData = [];
        $selectedFilters = $request->input('filters', []);

        // Если фильтры не выбраны, возвращаем все данные
        if (empty($selectedFilters)) {
            return $scheduleData;
        }

        // Фильтруем данные на основе выбранных фильтров
        foreach ($selectedFilters as $filter) {
            if (isset($filters[$filter])) {
                foreach ($filters[$filter] as $serviceTitle) {
                    foreach ($scheduleData as $item) {
                        if ($item['service']['title'] === $serviceTitle) {
                            $filteredData[] = $item;
                        }
                    }
                }
            }
        }
        // dd($filteredData);
        return array_values($filteredData);
    }
}
