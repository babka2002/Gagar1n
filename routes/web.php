<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TrainerController;
use App\Jobs\SendWebhookJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


Route::post('/webhook-proxy', function (Request $request) {
    try {
        SendWebhookJob::dispatch($request->all());
        return response()->json(['message' => 'OK']);  // точно такой же ответ как в curl
    } catch (\Exception $e) {
        Log::error('Webhook dispatch error:', [
            'message' => $e->getMessage(),
            'request_data' => $request->all()
        ]);
        return response()->json([
            'error' => 'Webhook error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::post('/proxy-leads', function (Request $request) {
    try {
        $response = Http::post('http://147.45.187.4:5557/api/leads', $request->all());
        return response()->json($response->json(), $response->status());
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

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
