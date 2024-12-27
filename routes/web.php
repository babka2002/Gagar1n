<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainerController;


// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);

$router->get('/trainers', [TrainerController::class, 'showTrainers']);
// Route::statamic('trainers', 'trainers', [
//     'title' => 'Список тренеров',
//     'description' => 'Здесь вы можете найти всех наших тренеров.'
// ]);
// $router->statamic('trainers', 'trainers', [
//     'title' => 'Тренеры',
//     'controller' => TrainerController::class,
//     'method' => 'showTrainers'
// ]);
