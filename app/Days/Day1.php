<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day1
{
    public int $day = 1;

    public array $array;

    public function __construct(array $array = null)
    {
        if (! is_null($array)) {
            $this->array = $array;
        } else {
            $this->array = Arr::fromFile(Storage::get('/input/day'.$this->day.'.txt'));
        }
    }

    public function part1(): int
    {
        $current_total = 0;
        $highest_total = 0;

        foreach ($this->array as $line) {
            if ($line === '') {
                if ($current_total > $highest_total) {
                    $highest_total = $current_total;
                }

                $current_total = 0;
            } else {
                $current_total += (int) $line;
            }
        }

        return $highest_total;
    }

    public function part2(): int
    {
        $current_total = 0;
        $totals = [];

        foreach ($this->array as $line) {
            if ($line === '') {
                $totals[] = $current_total;

                $current_total = 0;
            } else {
                $current_total += (int) $line;
            }
        }

        rsort($totals);

        return $totals[0] + $totals[1] + $totals[2];
    }
}
