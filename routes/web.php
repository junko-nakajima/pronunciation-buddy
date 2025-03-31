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
    Route::get('/decks/create', [DeckController::class, 'create'])->name('create');
    Route::get('/decks/{deck}', [DeckController::class, 'show'])->name('show');
    Route::post('/decks', [DeckController::class, 'store']);
    Route::put('/decks/{deck}', [DeckController::class, 'update'])->name('update');
    Route::delete('/deck/{id}', [DeckController::class,'delete'])->name('deck.delete');
    Route::get('/decks/{deck}/edit', [DeckController::class,'edit'])->name('edit');
    Route::put('/decks/{deck}', [DeckController::class, 'update']);

    Route::get('/studyhistory', [StudyhistoryController::class, 'index'])->name('index');

    Route::get('/word', [WordController::class, 'index'])->name('index');
    Route::get('/words/{deck}/create', [WordController::class, 'create'])->name('create');
    Route::get('/words/{word}', [WordController::class ,'show'])->name('show');
    Route::post('/words', [WordController::class, 'store']);
    Route::put('/words/{word}', [WordController::class, 'update'])->name('update');
    Route::delete('/words/{word}', [WordController::class,'delete'])->name('delete');
    Route::get('/words/{word}/edit', [WordController::class,'edit'])->name('edit');

    Route::get('/category', [CategoryController::class, 'index'])->name('cotegoryIndex');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('show');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class,'delete'])->name('delete');
    Route::get('/categories/{category}/edit', [CategoryController::class,'edit'])->name('edit');   
    Route::put('/categories/{category}', [CategoryController::class, 'update']);

    Route::get('/attempt', [AttemptController::class, 'index'])->name('index');

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('index');

    Route::get('/audio', [AudioController::class, 'index']); 
    Route::post('/saveEvaluation', [AudioController::class, 'store'])->name('evaluation.store');
});
require __DIR__.'/auth.php';
