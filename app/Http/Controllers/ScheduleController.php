<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Statamic\View\View;

class ScheduleController extends Controller
{
    private ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index(Request $request)
    {
        // Устанавливаем значения по умолчанию для start_date и end_date
        if (!$request->has('start_date') || empty($request->input('start_date'))) {
            $request->merge(['start_date' => \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d H:i')]);
        }

        if (!$request->has('end_date') || empty($request->input('end_date'))) {
            $request->merge(['end_date' => \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d H:i')]);
        }

        $clubId = '49964502-5659-11eb-e291-ac162d836873';
        $params = $request->only(['start_date', 'end_date', 'service_id', 'employee_id']);
        $params['club_id'] = $clubId;

        // Получаем расписание
        $scheduleData = $this->scheduleService->getSchedule($params);

        // Проверяем, есть ли данные
        if (empty($scheduleData)) {
            return response()->json(['message' => 'Нет данных для отображения.'], 404);
        }

        // Применяем фильтры
        $filteredData = $this->applyFilters($scheduleData, $request);
// dd(count($filteredData), $request->all());
        // Подготовка данных для отображения
        $timeSlots = ['07:00', '08:00', '09:00']; // Пример временных слотов
        $daysOfWeek = $this->prepareDaysOfWeek($filteredData);
// dd(count($daysOfWeek));
        // Передаем данные в шаблон
        return (new View)
            ->template('schedule')
            ->layout('layout')
            ->with([
                'timeSlots' => $timeSlots,
                'daysOfWeek' => $daysOfWeek,
            ]);
    }

    private function applyFilters(array $scheduleData, Request $request): array
    {
        $filteredData = $scheduleData;

        // Фильтр по типу услуги
        if ($request->has('service_id') && !empty($request->input('service_id'))) {
            $filteredData = array_filter($filteredData, function ($item) use ($request) {
                return $item['service']['id'] === $request->input('service_id');
            });
        }

        // Фильтр по тренеру
        if ($request->has('employee_id') && !empty($request->input('employee_id'))) {
            $filteredData = array_filter($filteredData, function ($item) use ($request) {
                return $item['employee']['id'] === $request->input('employee_id');
            });
        }

        // Фильтр по помещению (room)
        if ($request->has('room_id') && !empty($request->input('room_id'))) {
            $filteredData = array_filter($filteredData, function ($item) use ($request) {
                return $item['room']['id'] === $request->input('room_id');
            });
        }

        // Фильтр по возрастной категории
        if ($request->has('age_category') && !empty($request->input('age_category'))) {
            $filteredData = array_filter($filteredData, function ($item) use ($request) {
                $isKids = str_contains(strtoupper($item['service']['title']), 'KIDS') ||
                        str_contains(strtoupper($item['room']['title']), 'KIDS');

                switch($request->input('age_category')) {
                    case 'kids':
                        return $isKids;
                    case 'adults':
                        return !$isKids;
                    default: // 'all'
                        return true;
                }
            });
        }

        // Фильтр по стоимости
        if ($request->has('cost_type') && !empty($request->input('cost_type'))) {
            $filteredData = array_filter($filteredData, function ($item) use ($request) {
                switch($request->input('cost_type')) {
                    case 'paid':
                        return $item['commercial'] === true;
                    case 'free':
                        return $item['commercial'] === false;
                    default: // 'any'
                        return true;
                }
            });
        }


        // Фильтр по диапазону дат
        if ($request->has('start_date') && !empty($request->input('start_date'))) {
            $requestStartDate = \Carbon\Carbon::parse($request->input('start_date'))->startOfDay();

            $filteredData = array_filter($filteredData, function ($item) use ($requestStartDate) {
                $itemStartDate = \Carbon\Carbon::parse($item['start_date']);
                return $itemStartDate->greaterThanOrEqualTo($requestStartDate);
            });
        }

        if ($request->has('end_date') && !empty($request->input('end_date'))) {
            $requestEndDate = \Carbon\Carbon::parse($request->input('end_date'))->endOfDay();

            $filteredData = array_filter($filteredData, function ($item) use ($requestEndDate) {
                $itemEndDate = \Carbon\Carbon::parse($item['end_date']);
                return $itemEndDate->lessThanOrEqualTo($requestEndDate);
            });
        }

        // Добавим отладочную информацию
        \Log::info('Filtered Data Count: ' . count($filteredData));
        \Log::info('Request Params: ', $request->all());
        \Log::info('First Item in Filtered Data: ', !empty($filteredData) ? [array_values($filteredData)[0]] : ['No data']);

        return array_values($filteredData); // Переиндексируем массив
    }

    private function prepareDaysOfWeek(array $scheduleData): array
    {
        $daysOfWeek = [];

        // Группируем занятия по дням
        foreach ($scheduleData as $item) {
            $date = \Carbon\Carbon::parse($item['start_date'])->format('Y-m-d');
            $dayName = \Carbon\Carbon::parse($item['start_date'])->translatedFormat('l');

            // Если день еще не добавлен, создаем новый элемент
            if (!isset($daysOfWeek[$date])) {
                $daysOfWeek[$date] = [
                    'date' => \Carbon\Carbon::parse($item['start_date'])->format('d'),
                    'name' => $dayName,
                    'schedule' => []
                ];
            }

            // Добавляем занятие в соответствующий день
            $daysOfWeek[$date]['schedule'][] = $item;
        }

        // Преобразуем массив дней в индексированный массив
        return array_values($daysOfWeek);
    }
}
