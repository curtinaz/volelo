<?php

namespace App\Http\Controllers;

use App\Models\DailyWords;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class DailyWordsController extends Controller
{
    public function getDailyWord() {
        $today = date('Y-m-d');

        $word = DailyWords::where("game_date", $today)->first();
        return $word;
    }
}
