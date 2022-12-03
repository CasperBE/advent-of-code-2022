<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DayThreeController extends Controller
{
    public string $filename = "input/daythree.txt";

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        echo "1) Sum of priorities: " . $this->sumOfPriorities($array) . "<br>\n";
        echo "2) New sum of priorities: " . $this->newSumOfPriorities($array);
    }

    /**
     * Get the sum of all priorities, as defined in the first part of the puzzle.
     *
     * @param array $array
     * @return int
     */
    public function sumOfPriorities(array $array): int
    {
        $sum = 0;

        foreach ($array as $line) {
            if (empty($line)) {
                continue;
            }

            $line_length = strlen($line);
            $compartment_length = $line_length / 2;

            list($compartment_one, $compartment_two) = str_split($line, $compartment_length);

            $priority_item = $this->findCommonLetter($compartment_one, $compartment_two);

            $priority_value = $this->letterToNumber($priority_item);

            $sum += $priority_value;
        }

        return $sum;
    }

    /**
     * Get the sum of all priorities, as defined in the second part of the puzzle.
     *
     * @param array $array
     * @return int
     */
    public function newSumOfPriorities(array $array): int
    {
        $sum = 0;

        $lines = [];

        foreach ($array as $line) {
            if (empty($line)) {
                continue;
            }

            $lines[] = $line;

            if (count($lines) !== 3) {
                continue;
            }

            $priority_item = $this->findCommonLetter($lines[0], $lines[1], $lines[2]);

            $priority_value = $this->letterToNumber($priority_item);

            $sum += $priority_value;

            $lines = [];
        }

        return $sum;
    }

    /**
     * Convert a given letter (case-sensitive) to a number.
     * Eg:
     * a => 1
     * z => 26
     * A => 27
     * Z => 52
     *
     * @param string $letter
     * @return int
     */
    public function letterToNumber(string $letter): int
    {
        if (empty($letter) || strlen($letter) !== 1) {
            return 0;
        }

        $number = ord(strtolower($letter)) - 96;

        if ($letter !== strtolower($letter)) {
            $number += 26;
        }

        return $number;
    }

    /**
     * Find the common letter in given strings.
     *
     * @param string ...$strings
     * @return string
     */
    public function findCommonLetter(string...$strings): string
    {
        $arrays = [];

        foreach ($strings as $string) {
            $arrays[] = str_split($string);
        }

        $common = call_user_func_array('array_intersect', $arrays);

        // re-order keys
        $common = array_values($common);

        return $common[0];
    }
}
