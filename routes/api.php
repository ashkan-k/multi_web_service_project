<?php

use App\Http\Controllers\Api\TicketAnswerController;
use App\Http\Controllers\Api\TicketCategoryController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketFrequentlyAskedQuestionController;
use App\Http\Controllers\Api\TicketSubjectController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

// Tickets
Route::group(['prefix' => 'tickets', 'middleware' => 'auth'], function () {
    // Change Status (By Admin)
    Route::post('status/change/{ticket}', [TicketController::class, 'change_status']);
    // Categories
    Route::apiResource('categories', TicketCategoryController::class);
    // TicketFrequentlyAskedQuestions
    Route::apiResource('frequently_asked_questions', TicketFrequentlyAskedQuestionController::class);
    // TicketSubjects
    Route::apiResource('subjects', TicketSubjectController::class);
    // Ticket Answers
    Route::post('answers/store/{ticket}', [TicketAnswerController::class , 'store']);
    // Tickets
    Route::apiResource('', TicketController::class)->parameter('', 'ticket');
});


