<?php

namespace App\Http\Controllers;

use App\Services\TrainerService;
use Statamic\Facades\Entry;
use Statamic\View\View;

class TrainerController extends Controller
{
    public function __construct(
        private readonly TrainerService $trainerService
    ) {}

    private function formatTrainerData($trainer, $source = 'api')
    {
        if ($source === 'api') {
            return $trainer;
        } else {
            $position = $trainer->get('position');
            $department = $trainer->get('department');

            // Получаем term для позиции
            $positionTerm = null;
            if (!empty($position) && is_array($position) && !empty($position[0])) {
                $positionTerm = \Statamic\Facades\Term::query()
                    ->where('taxonomy', 'positions')
                    ->where('slug', $position[0])
                    ->first();
            }
            $positionTitle = $positionTerm ? $positionTerm->get('title') : 'Не определена';

            // Аналогично для department
            $departmentTerm = null;
            if (!empty($department) && is_array($department) && !empty($department[0])) {
                $departmentTerm = \Statamic\Facades\Term::query()
                    ->where('taxonomy', 'departments')
                    ->where('slug', $department[0])
                    ->first();
            }
            $departmentTitle = $departmentTerm ? $departmentTerm->get('title') : $positionTitle;

            return (object)[
                'id' => $trainer->id(),
                'name' => $trainer->get('name'),
                'second_name' => $trainer->get('second_name'),
                'last_name' => $trainer->get('last_name'),
                'description' => $trainer->get('content'),
                'localPhotoPath' => $trainer->get('localPhotoPath') ?'/assets/' . $trainer->get('localPhotoPath') : null,
                'position' => (object)[
                    'id' => null,
                    'title' => $positionTitle
                ],
                'department' => (object)[
                    'title' => $departmentTitle
                ],
                'specializations' => $trainer->get('specializations') ?? [],
                'experience' => $trainer->get('experience')
            ];
        }
    }

    public function showTrainer(string $employeeId)
    {
        // $trainer = $this->trainerService->getTrainerById($employeeId);

        // try {
        //     // Пытаемся получить тренера из API
        //     $apiTrainer = $this->trainerService->getTrainerById($employeeId);
        //     if ($apiTrainer) {
        //         $trainer = $this->formatTrainerData($apiTrainer, 'api');
        //     }
        // } catch (\Exception $e) {
        //     $apiTrainer = null;
        // }

        // Пытаемся найти тренера в Statamic
        $statamicTrainer = Entry::query()
            ->where('collection', 'trainers')
            ->where('is_active', true)
            ->where(function ($query) use ($employeeId) {
                $query->where('external_id', $employeeId)
                    ->orWhere('id', $employeeId);
            })
            ->first();

        if ($statamicTrainer) {
            $trainer = $this->formatTrainerData($statamicTrainer, 'statamic');
        }

        // Если тренер не найден нигде
        if (!isset($trainer)) {
            abort(404, 'Тренер не найден');
        }

        return (new View)
            ->template('trainer_single')
            ->layout('layout')
            ->with([
                'trainer' => $trainer,
            ]);
    }
    public function showTrainers()
{
    // Временно отключаем получение тренеров из API
    // $clubId = '49964502-5659-11eb-e291-ac162d836873';
    // $trainers = $this->trainerService->getTrainers($clubId);

    // Получаем только тренеров из Statamic
    $statamicTrainers = Entry::query()
        ->where('collection', 'trainers')
        ->where('is_active', true)
        ->get();

    $trainersByDepartment = [];

    // Обрабатываем только Statamic тренеров
    foreach ($statamicTrainers as $trainer) {
        $formattedTrainer = $this->formatTrainerData($trainer, 'statamic');
        $departmentTitle = $formattedTrainer->department->title ?? $formattedTrainer->position->title ?? 'Не определена';

        if (!isset($trainersByDepartment[$departmentTitle])) {
            $trainersByDepartment[$departmentTitle] = [];
        }

        $trainersByDepartment[$departmentTitle][] = $formattedTrainer;
    }

    return (new View)
        ->template('trainers')
        ->layout('layout')
        ->with([
            'trainersByDepartment' => $trainersByDepartment,
        ]);
}

    // public function showTrainers()
    // {
    //     $clubId = '49964502-5659-11eb-e291-ac162d836873';
    //     $trainers = $this->trainerService->getTrainers($clubId);

    //     // Получаем тренеров из Statamic
    //     $statamicTrainers = Entry::query()
    //         ->where('collection', 'trainers')
    //         ->where('is_active', true)
    //         ->get();

    //     // Группируем тренеров по отделам
    //     $trainersByDepartment = [];

    //     // Обрабатываем тренеров из API
    //     foreach ($trainers as $trainer) {
    //         $formattedTrainer = $this->formatTrainerData($trainer, 'api');
    //         $departmentTitle = $formattedTrainer->department->title ?? null;

    //         if (empty($departmentTitle)) {
    //             $departmentTitle = $formattedTrainer->position->title ?? 'Не определена';
    //         }

    //         if (!empty($departmentTitle)) {
    //             if (!isset($trainersByDepartment[$departmentTitle])) {
    //                 $trainersByDepartment[$departmentTitle] = [];
    //             }
    //             $trainersByDepartment[$departmentTitle][] = $formattedTrainer;
    //         }
    //     }

    //     // Добавляем тренеров из Statamic
    //     foreach ($statamicTrainers as $trainer) {
    //         if (!$trainer->get('external_id')) {
    //             $formattedTrainer = $this->formatTrainerData($trainer, 'statamic');
    //             $departmentTitle = $formattedTrainer->department->title ?? $formattedTrainer->position->title ?? 'Не определена';

    //             if (!isset($trainersByDepartment[$departmentTitle])) {
    //                 $trainersByDepartment[$departmentTitle] = [];
    //             }

    //             $trainersByDepartment[$departmentTitle][] = $formattedTrainer;
    //         }
    //     }

    //     return (new View)
    //         ->template('trainers')
    //         ->layout('layout')
    //         ->with([
    //             'trainersByDepartment' => $trainersByDepartment,
    //         ]);
    // }
}
