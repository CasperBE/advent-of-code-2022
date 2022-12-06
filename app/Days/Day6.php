<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day6
{
    public int $day = 6;

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
        return $this->findFirstSubroutine($this->array[0]);
    }

    public function part2(): int
    {
        return $this->findFirstSubroutine($this->array[0], 14);
    }

    public function findFirstSubroutine($string, $unique_chars = 4): int
    {
        $chars = str_split($string);

        $i = 0;
        $last_chars = [];
        foreach ($chars as $char) {
            $i++;

            $last_chars[] = $char;

            if ($i <= $unique_chars) {
                continue;
            }

            array_shift($last_chars);

            if ($last_chars === array_unique($last_chars)) {
                return $i;
            }
        }

        return 0;
    }
}
