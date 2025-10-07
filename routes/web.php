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
        $requestData = $request->all();
        
        // Отправляем только на ваш сервер
        $response = Http::timeout(60)
            ->retry(3, 100)
            ->post('http://147.45.143.215:777/api/leads', $requestData);
        
        Log::info('Proxy-leads sent to custom server', [
            'status' => $response->status(),
            'response' => $response->json(),
            'data' => $requestData
        ]);
        
        // Возвращаем ответ от вашего сервера
        return response()->json($response->json(), $response->status());
        
    } catch (\Exception $e) {
        Log::error('Proxy-leads error', [
            'error' => $e->getMessage(),
            'data' => $requestData ?? null
        ]);
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
$router->get('/trainers/{slug}', [TrainerController::class, 'showTrainerBySlug'])->where('slug', '[a-z0-9-]+')->name('trainers.show');
// $router->get('/trainers/{employeeId}', [TrainerController::class, 'showTrainer'])->name('trainers.show');
$router->get('/schedule', [ScheduleController::class, 'index'])->name('schedule.show');

// Роуты для Gun1or (сабдиректория)
$router->get('/gun1or/trainers', [TrainerController::class, 'showTrainers'])->name('gun1or.trainers.list');
$router->get('/gun1or/trainers/{slug}', [TrainerController::class, 'showTrainerBySlug'])->where('slug', '[a-z0-9-]+')->name('gun1or.trainers.show');
$router->get('/gun1or/schedule', [ScheduleController::class, 'index'])->name('gun1or.schedule.show');

// Роуты для GFoodcafe (сабдиректория)
$router->get('/gfoodcafe/trainers', [TrainerController::class, 'showTrainers'])->name('gfoodcafe.trainers.list');
$router->get('/gfoodcafe/trainers/{slug}', [TrainerController::class, 'showTrainerBySlug'])->where('slug', '[a-z0-9-]+')->name('gfoodcafe.trainers.show');
$router->get('/gfoodcafe/schedule', [ScheduleController::class, 'index'])->name('gfoodcafe.schedule.show');
