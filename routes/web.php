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
        SendWebhookJob::dispatch([
            'phone' => $request->input('phone'),
            'full_name' => $request->input('full_name'),
        ]);

        return response()->json(['message' => 'Webhook queued successfully']);
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


// Route::post('/webhook-proxy', function (Request $request) {
//     try {
//         // Логируем входящие данные
//         Log::info('Webhook request data:', $request->all());

//         $response = Http::post('http://147.45.187.4:3000/webhook', [
//             'callerphone' => $request->input('callerphone'),
//             'fio' => $request->input('fio'),
//             'subject' => $request->input('subject'),
//             'source' => $request->input('source', 'gagar1n.ru'),
//             'medium' => $request->input('medium', 'gagar1n.ru'),
//             'leadtype' => $request->input('leadtype', 'request')
//         ]);

//         // Логируем ответ
//         Log::info('Webhook response:', ['status' => $response->status(), 'body' => $response->json()]);

//         return $response->json();
//     } catch (\Exception $e) {
//         // Детальное логирование ошибки
//         Log::error('Webhook error:', [
//             'message' => $e->getMessage(),
//             'trace' => $e->getTraceAsString(),
//             'request_data' => $request->all()
//         ]);

//         return response()->json([
//             'error' => $e->getMessage(),
//             'details' => 'Check server logs for more information'
//         ], 500);
//     }
// });
// Route::post('/webhook-proxy', function (Request $request) {
//     try {
//         $response = Http::post('http://147.45.187.4:3000/webhook', $request->all());

//         return $response->json();
//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// });
