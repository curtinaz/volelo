<?php

use App\Http\Controllers\DailyWordsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/word", [DailyWordsController::class, 'getDailyWord']);
