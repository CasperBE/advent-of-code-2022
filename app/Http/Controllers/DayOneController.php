<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DayOneController extends Controller
{
    public string $filename = "input/dayone.txt";

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        echo "1) Highest total: " . $this->getHighestTotal($array) . "<br>\n";

        echo "2) Top three totals: " . $this->getTopThreeTotal($array);
    }

    public function getHighestTotal($array): int
    {
        $current_total = 0;
        $highest_total = 0;

        foreach ($array as $line) {
            if ($line === '') {
                if ($current_total > $highest_total) {
                    $highest_total = $current_total;
                }

                $current_total = 0;
            } else {
                $current_total += (int)$line;
            }
        }

        return $highest_total;
    }

    public function getTopThreeTotal($array): int
    {
        $current_total = 0;
        $totals = [];

        foreach ($array as $line) {
            if ($line === '') {
                $totals[] = $current_total;

                $current_total = 0;
            } else {
                $current_total += (int)$line;
            }
        }

        rsort($totals);

        return $totals[0] + $totals[1] + $totals[2];
    }
}
