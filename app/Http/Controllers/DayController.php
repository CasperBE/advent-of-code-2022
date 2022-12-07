<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

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
            'previous_day_link' => $this->getOtherDayLink($day, false),
            'next_day_link' => $this->getOtherDayLink($day),
        ])->render();
    }

    private function getOtherDayLink(int $day, bool $next = true): ?string
    {
        $the_day = ($next) ? $day + 1 : $day - 1;

        $path = base_path('app/Days').'/Day'.$the_day.'.php';

        return File::exists($path) ? '/day/'.$the_day : null;
    }
}
