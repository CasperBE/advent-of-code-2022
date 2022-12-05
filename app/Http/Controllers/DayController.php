<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DayController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param int $day
     * @return Response|string
     */
    public function __invoke(Request $request, int $day)
    {
        $class = 'App\Days\Day'.$day;
        $day_class = new $class();

        return view('day', [
            'day' => $day,
            'part1' => $day_class->part1(),
            'part2' => $day_class->part2(),
        ])->render();
    }
}
