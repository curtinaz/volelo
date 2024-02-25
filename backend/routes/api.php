<?php

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/users", [UsersController::class, 'index']);
Route::post("/users/balancer", [UsersController::class, 'balancer']);
Route::post("/users/eloUpdate", [UsersController::class, 'atualizarElo']);
