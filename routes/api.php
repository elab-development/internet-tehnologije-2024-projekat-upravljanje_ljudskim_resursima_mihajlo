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
    Route::get('employees/{id}/projects', [EmployeeController::class, 'projects']);
    Route::post('employees/search', [EmployeeController::class, 'search']);
    Route::post('employees/{id}/assign-project', [EmployeeController::class, 'assignProject']);
  
    Route::resource('departments', DepartmentController::class);
    Route::get('departments/{id}/employees/count', [DepartmentController::class, 'employeeCount']);

    Route::resource('projects', ProjectController::class);

});