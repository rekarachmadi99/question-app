<?php

//Models
use App\Models\QuestionModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Validator
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('/question', App\Http\Controllers\Api\QuestionController::class);


Route::get('/correct-question', function(Request $request){
    $soal = new QuestionModel;
    return $soal->correctQuestion($request);
});

Route::get('/list-question', function(Request $request){
    $soal = new QuestionModel;
    return $soal->listQuestion($request->title);
});

Route::get('/sort-question', function(Request $request){
    $soal = new QuestionModel;
    return $soal->sortQuestion($request);
});
