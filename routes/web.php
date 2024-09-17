<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoContoller;

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

Route::get('/todo', function() {
    $data = new TodoContoller();
    $todos = $data->index(false);
    return view('todo',['todos' => $todos]);
});


Route::get('/todos-all', [TodoContoller::class, 'showAll'])->name('todo.showAll');

Route::resource('/todos', 'App\Http\Controllers\TodoContoller');