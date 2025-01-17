<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TrainerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;




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

Route::post('/webhook-proxy', function (Request $request) {
    try {
        $response = Http::post('http://147.45.187.4:3000/webhook', $request->all());

        return $response->json();
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
