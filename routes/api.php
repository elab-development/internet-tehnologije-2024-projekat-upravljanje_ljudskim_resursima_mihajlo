<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectController;


Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    
    Route::resource('employees', EmployeeController::class);
    Route::get('employees/{id}', [EmployeeController::class, 'show']);
    Route::post('employees/search', [EmployeeController::class, 'search']);
  
    Route::resource('departments', DepartmentController::class);

    Route::resource('projects', ProjectController::class);

});