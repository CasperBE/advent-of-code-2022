<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day5
{
    public int $day = 5;

    public int $stack_height = 0;

    public int $stack_length = 0;

    public array $instructions;

    public array $array;

    public function __construct(array $array = null)
    {
        if (! is_null($array)) {
            $this->array = $array;
        } else {
            $this->array = Arr::fromFile(Storage::get('/input/day'.$this->day.'.txt'));
        }
    }

    public function part1(): string
    {
        $stack = $this->parseInput($this->array);

        $stack = $this->applyInstructionsOnStack($stack);

        return $this->getFirstElementOfEachColumn($stack);
    }

    public function part2(): string
    {
        // Reset part1
        $this->stack_height = 0;
        $this->stack_length = 0;
        $this->instructions = [];

        $stack = $this->parseInput($this->array);

        $stack = $this->applyInstructionsOnStack($stack, true);

        return $this->getFirstElementOfEachColumn($stack);
    }

    public function getFirstElementOfEachColumn($stack): string
    {
        $return = '';

        for ($i = 1; $i <= $this->stack_length; $i++) {
            for ($j = $this->stack_height; $j > 0; $j--) {
                if ($stack[$j][$i] === null) {
                    continue;
                }
                $return .= $stack[$j][$i];
                break;
            }
        }

        return $return;
    }

    public function applyInstructionsOnStack($stack, $new = false): array
    {
        foreach ($this->instructions as $instruction) {
            $instruction = str_replace('move ', '', $instruction);
            $instruction = str_replace([' from ', ' to '], ',', $instruction);
            list($count, $from, $to) = explode(',', $instruction);
            $temp = [];
            $j = 0;
            for ($i = 0; $i < $this->stack_height; $i++) {
                $current_row = $this->stack_height - $i;
                if (is_null($stack[$current_row][$from])) {
                    continue;
                }
                $j++;
                $current_count = $count - $j;
                if ($new) {
                    $temp[$current_count] = $stack[$current_row][$from];
                } else {
                    $temp[] = $stack[$current_row][$from];
                }
                $stack[$current_row][$from] = null;
                if (count($temp) == $count) {
                    break;
                }
            }

            $first_free_row = $this->firstFreeRow($stack, $to);

            while (($first_free_row + $count - 1) > $this->stack_height) {
                $new_row = $this->stack_height + 1;
                for ($i = 1; $i <= $this->stack_length; $i++) {
                    $stack[$new_row][$i] = null;
                }
                $this->stack_height++;
            }

            for ($j = 0; $j < $count; $j++) {
                $row = $first_free_row + $j;
                $stack[$row][$to] = $temp[$j];
            }
        }

        return $stack;
    }

    public function firstFreeRow($array, $column): int
    {
        krsort($array);

        $i = $this->stack_height;
        foreach ($array as $row) {
            if ($row[$column] !== null) {
                return $i + 1;
            }
            $i--;
        }

        // Column is empty
        return 1;
    }

    public function parseInput($array): array
    {
        $temp_stack = [];
        $stack = [];
        $stack_loop = true;

        foreach ($array as $line) {
            if (empty($line)) {
                $stack_loop = false;
                continue;
            }

            if ($stack_loop) {
                // We are in the stack part
                $line_trimmed = trim($line);

                if ($line_trimmed[0] === '1') {
                    // We have the last line of the stack part, which has the column numbers
                    $line = str_replace('  ', ' ', $line);
                    $line_parts = explode(' ', $line);
                    foreach ($line_parts as $line_part) {
                        if (empty($line_part)) {
                            continue;
                        }

                        $this->stack_length++;
                    }
                    continue;
                } else {
                    // Add line to temp stack
                    $temp_stack[] = $line;
                }

                $this->stack_height++;
            }

            if (! $stack_loop) {
                // Set instructions
                $this->instructions[] = $line;
            }
        }

        $k = 0;
        foreach ($temp_stack as $stack_line) {
            $line_number = $this->stack_height - $k;
            $stack_line = str_replace(['[', ']'], '', $stack_line);
            $stack_line = str_replace('  ', ' ', $stack_line);

            $chars = str_split($stack_line);
            $i = 0;
            $j = 0;
            foreach ($chars as $char) {
                $i++;
                if ($i % 2 == 0) {
                    continue;
                }
                $j++;
                if ($char === ' ') {
                    $char = null;
                }
                $stack[$line_number][$j] = $char;
            }
            $j++;
            while ($j <= $this->stack_length) {
                $stack[$line_number][$j] = null;
                $j++;
            }
            $k++;
        }

        ksort($stack);

        return $stack;
    }
}
