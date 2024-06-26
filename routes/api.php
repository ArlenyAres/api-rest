<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLoginRegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;



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
Route::post('/register', [AuthLoginRegisterController::class, 'register']);
Route::post('/login', [AuthLoginRegisterController::class, 'login']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/category/{id}', [EventController::class, 'indexByCategory']);
// Route::get('{id}', [EventController::class, 'show']);
Route::get('/events/{id}', [EventController::class, 'show']);

// Route::middleware('auth:sanctum')->get('/sanctum/csrf-cookie', function (Request $request) {
//     return response()->json(['message' => 'CSRF cookie has been set']);
// });

Route::middleware(['cors', 'auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthLoginRegisterController::class, 'logout']);
    //->middleware('auth:sanctum');
});

// User routes
Route::middleware(['cors', 'auth:sanctum'])->group(function () {
    Route::get('{id}/events', [UserController::class, 'getEventsCreatedByUser']);
    Route::get('/{id}/subscribed-events', [UserController::class, 'getSubscribedEvents']);
    Route::post('/events/{eventId}/register', [RegistrationController::class, 'register']);
    Route::delete('/events/{eventId}/unregister', [RegistrationController::class, 'unregister']);
    Route::get('/user/{id}', [UserController::class, 'getUserProfile']); //ver perfil
    Route::post('/user/{id}/profile', [UserController::class, 'updateProfile']); //editar perfil
});

// Rutas de eventos
Route::get('/events/{id}/registered-users', [EventController::class, 'getRegisteredUsers']);
Route::middleware(['cors', 'auth:sanctum'])->group(function () {
    Route::post('/events/create', [EventController::class, 'store']);
    Route::post('/events/{id}/edit', [EventController::class, 'update']);
    Route::delete('/events/{id}/delete', [EventController::class, 'destroy']);
    Route::get('/{id}/events-by-user', [EventController::class, 'getUserEvents']);
});

// Ruta de Sanctum
Route::middleware(['auth:sanctum', 'cors'])->get('/user', function (Request $request) {
    return $request->user();
});
