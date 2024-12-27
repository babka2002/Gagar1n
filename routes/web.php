<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\ScheduleController;


// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);
// Route::statamic('trainers', 'trainers', [
//     'title' => 'Список тренеров',
//     'description' => 'Здесь вы можете найти всех наших тренеров.'
// ]);
// $router->statamic('trainers', 'trainers', [
//     'title' => 'Тренеры',
//     'controller' => TrainerController::class,
//     'method' => 'showTrainers'
// ]);

$router->get('/trainers', [TrainerController::class, 'showTrainers'])->name('trainers.list');
$router->get('/trainers/{employeeId}', [TrainerController::class, 'showTrainer'])->name('trainers.show');
$router->get('/schedule', [ScheduleController::class, 'index'])->name('schedule.show');
