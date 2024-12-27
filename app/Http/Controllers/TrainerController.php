<?php

namespace App\Http\Controllers;

use App\Services\TrainerService;
use Statamic\View\View;

class TrainerController extends Controller
{
    public function __construct(
        private readonly TrainerService $trainerService
    ) {}

    public function showTrainer(string $employeeId)
    {
        $trainer = $this->trainerService->getTrainerById($employeeId);

        return (new View)
            ->template('trainer_single')
            ->layout('layout')
            ->with([
                'trainer' => $trainer,
            ]);
    }

    public function showTrainers()
    {
        $clubId = '49964502-5659-11eb-e291-ac162d836873';
        $trainers = $this->trainerService->getTrainers($clubId);
// dd($trainers);

        // Группируем тренеров по отделам
        $trainersByDepartment = [];
        foreach ($trainers as $trainer) {
            $departmentTitle = $trainer->department->title ?? null; // Используем null coalescing оператор

            // Если departmentTitle пустое, берем title из position
            if (empty($departmentTitle)) {
                $departmentTitle = $trainer->position->title ?? 'Не определена';
            }

            // Проверяем, что departmentTitle не пустое
            if (!empty($departmentTitle)) {
                if (!isset($trainersByDepartment[$departmentTitle])) {
                    $trainersByDepartment[$departmentTitle] = [];
                }
                $trainersByDepartment[$departmentTitle][] = $trainer;
            }
        }

        return (new View)
            ->template('trainers')
            ->layout('layout')
            // ->cascadeContent($trainersByDepartment);
            ->with([
                'trainersByDepartment' => $trainersByDepartment,
        ]);
    }
}
