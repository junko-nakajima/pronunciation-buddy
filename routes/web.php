<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\StudyhistoryController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AttemptController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AudioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth']], function(){
    Route::get('/deck', [DeckController::class, 'index'])->name('index');
    Route::get('/decks/create', [DeckController::class, 'create']);
    Route::get('/decks/{deck}', [DeckController::class, 'show']);
    Route::post('/decks', [DeckController::class, 'store']);
    Route::delete('/decks/{deck}', [DeckController::class,'delete']);

    Route::get('/studyhistory', [StudyhistoryController::class, 'index']);

    Route::get('/word', [WordController::class, 'index']);

    Route::get('/category', [CategoryController::class, 'index']);

    Route::get('/attempt', [AttemptController::class, 'index']);

    Route::get('/feedback', [FeedbackController::class, 'index']);

    Route::get('/audio', [AudioController::class, 'index']); 
    Route::post('/saveEvaluation', [AudioController::class, 'store'])->name('evaluation.store');
});
require __DIR__.'/auth.php';
