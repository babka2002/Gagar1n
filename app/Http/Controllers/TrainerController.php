<?php

namespace App\Http\Controllers;

// use App\Models\Trainer;
use App\Services\TrainerService;
use Statamic\View\View;

class TrainerController extends Controller
{
    public function __construct(
        private readonly TrainerService $trainerService
    ) {}

    public function showTrainers()
    {
        // dd('im here');
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

    // dd($trainersByDepartment);
        return (new View)
            ->template('trainers') // Укажите имя вашего шаблона
            ->layout('layout') // Укажите имя вашего макета, если необходимо
            // ->cascadeContent($trainersByDepartment);
            ->with([
                'trainersByDepartment' => $trainersByDepartment,
            ]);
    }
}
