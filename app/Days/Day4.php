<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day4
{
    public int $day = 4;

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
        $count = 0;

        foreach ($this->array as $line) {
            if (empty($line)) {
                continue;
            }

            [$first_pair, $second_pair] = explode(',', $line);

            if ($this->fullyContained($first_pair, $second_pair)) {
                $count++;
            }
        }

        return $count;
    }

    public function part2(): int
    {
        $count = 0;

        foreach ($this->array as $line) {
            if (empty($line)) {
                continue;
            }

            [$first_pair, $second_pair] = explode(',', $line);

            if ($this->contained($first_pair, $second_pair)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Check if one of two pairs is fully contained by the other pair.
     *
     * @param string $first_pair
     * @param string $second_pair
     * @return bool
     */
    public function fullyContained(string $first_pair, string $second_pair): bool
    {
        [$first_pair_start, $first_pair_end] = explode('-', $first_pair);
        [$second_pair_start, $second_pair_end] = explode('-', $second_pair);

        if ($first_pair_start >= $second_pair_start && $first_pair_end <= $second_pair_end) {
            return true;
        }

        if ($second_pair_start >= $first_pair_start && $second_pair_end <= $first_pair_end) {
            return true;
        }

        return false;
    }

    /**
     * Check if one of two pairs is at least partially contained by the other pair.
     *
     * @param string $first_pair
     * @param string $second_pair
     * @return bool
     */
    public function contained(string $first_pair, string $second_pair): bool
    {
        [$first_pair_start, $first_pair_end] = explode('-', $first_pair);
        [$second_pair_start, $second_pair_end] = explode('-', $second_pair);

        if ($first_pair_start <= $second_pair_end && $first_pair_end >= $second_pair_start) {
            return true;
        }

        if ($second_pair_start <= $first_pair_end && $second_pair_end >= $first_pair_start) {
            return true;
        }

        return false;
    }
}
