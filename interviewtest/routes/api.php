<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// 取資料
Route::get('todolist', [TodoController::class, 'getTodoList']);

// 新增資料
Route::post('todolist', [TodoController::class, 'addTodoList']);

// 更新資料
Route::put('todolist', [TodoController::class, 'modifyTodoList']);

// 刪除資料
Route::delete('todolist', [TodoController::class, 'delTodoList']);

// 清除已完成資料
Route::delete('todolist/completed', [TodoController::class, 'delCompleted']);
