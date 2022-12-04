<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DayFourController extends Controller
{
    public string $filename = 'input/dayfour.txt';

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        echo '1) Number of fully contained pairs: '.$this->numberOfFullyContainedPairs($array)."<br>\n";
        echo '2) Number of contained pairs: '.$this->numberOfContainedPairs($array);
    }

    /**
     * Get the number of pairs of which one is fully contained by the other.
     *
     * @param array $array
     * @return int
     */
    public function numberOfFullyContainedPairs(array $array): int
    {
        $count = 0;

        foreach ($array as $line) {
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

    /**
     * Get the number of pairs of which one is at least partially contained by the other.
     *
     * @param array $array
     * @return int
     */
    public function numberOfContainedPairs(array $array): int
    {
        $count = 0;

        foreach ($array as $line) {
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
