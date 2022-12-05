<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day3
{
    public int $day = 3;

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
        $sum = 0;

        foreach ($this->array as $line) {
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

    public function part2(): int
    {
        $sum = 0;

        $lines = [];

        foreach ($this->array as $line) {
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
    public function findCommonLetter(string ...$strings): string
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
