<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Ticket\Http\Controllers\TicketAnswerController;
use Modules\Ticket\Http\Controllers\TicketCategoryController;
use Modules\Ticket\Http\Controllers\TicketController;
use Modules\Ticket\Http\Controllers\TicketFrequentlyAskedQuestionController;
use Modules\Ticket\Http\Controllers\TicketSubjectController;

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

// Tickets
Route::group(['prefix' => 'tickets', 'middleware' => 'auth:api'], function () {
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
