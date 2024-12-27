<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainerController;


// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);

$router->get('/trainers', [TrainerController::class, 'showTrainers'])->name('trainers.list');
$router->get('/trainers/{employeeId}', [TrainerController::class, 'showTrainer'])->name('trainers.show');
// Route::statamic('trainers', 'trainers', [
//     'title' => 'Список тренеров',
//     'description' => 'Здесь вы можете найти всех наших тренеров.'
// ]);
// $router->statamic('trainers', 'trainers', [
//     'title' => 'Тренеры',
//     'controller' => TrainerController::class,
//     'method' => 'showTrainers'
// ]);
