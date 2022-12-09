<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day9
{
    public int $day = 9;

    public array $array;

    public array $head_previous_position;

    public array $head_position;

    public array $tail_position;

    public array $tail_visited_positions;

    public array $knot_positions;

    public int $tail_length;

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
        $this->tail_length = 1;

        $this->setStartPosition();

        $this->saveTailPosition();

        foreach ($this->array as $line) {
            if (empty($line)) {
                continue;
            }

            $this->executeInstruction($line);
        }

        return count($this->tail_visited_positions);
    }

    public function part2(): int
    {
        $this->tail_length = 9;

        $this->setStartPosition();

        $this->saveTailPosition();

        foreach ($this->array as $line) {
            if (empty($line)) {
                continue;
            }

            $this->executeInstruction($line);
        }

        return count($this->tail_visited_positions);
    }

    public function setStartPosition(): void
    {
        $this->head_previous_position = [];

        $this->head_position['X'] = 0;
        $this->head_position['Y'] = 0;

        $this->tail_position['X'] = 0;
        $this->tail_position['Y'] = 0;

        $this->tail_visited_positions = [];

        $this->knot_positions = [];

        for ($i = 1; $i < $this->tail_length; $i++) {
            $this->knot_positions[$i]['X'] = 0;
            $this->knot_positions[$i]['Y'] = 0;
        }
    }

    public function executeInstruction(string $instruction): void
    {
        [$direction, $length] = explode(' ', $instruction);

        for ($i = 0; $i < $length; $i++) {
            $this->moveHead($direction);
        }
    }

    public function moveHead($direction): void
    {
        $this->head_previous_position = $this->head_position;

        if ($direction === 'R') {
            $this->head_position = [
                'X' => $this->head_position['X'] + 1,
                'Y' => $this->head_position['Y'],
            ];
        } elseif ($direction === 'L') {
            $this->head_position = [
                'X' => $this->head_position['X'] - 1,
                'Y' => $this->head_position['Y'],
            ];
        } elseif ($direction === 'U') {
            $this->head_position = [
                'X' => $this->head_position['X'],
                'Y' => $this->head_position['Y'] + 1,
            ];
        } elseif ($direction === 'D') {
            $this->head_position = [
                'X' => $this->head_position['X'],
                'Y' => $this->head_position['Y'] - 1,
            ];
        }

        $this->moveTail();
    }

    public function moveTail(): void
    {
        for ($i = 1; $i < $this->tail_length; $i++) {
            $this->moveKnot($i);
        }

        if ($this->knotTouchesPrevious($this->tail_length)) {
            // No need to move the tail
            return;
        }

        if ($this->tail_length > 1) {
            $this->tail_position = $this->getClosestPosition($this->tail_position, $this->knot_positions[$this->tail_length - 1]);
        } else {
            $this->tail_position = $this->head_previous_position;
        }

        $this->saveTailPosition();
    }

    public function moveKnot($knot_number): void
    {
        if ($this->knotTouchesPrevious($knot_number)) {
            // No need to move the knot
            return;
        }

        if ($knot_number > 1) {
            $this->knot_positions[$knot_number] = $this->getClosestPosition($this->knot_positions[$knot_number], $this->knot_positions[$knot_number - 1]);
        } else {
            $this->knot_positions[$knot_number] = $this->head_previous_position;
        }
    }

    public function getClosestPosition(array $current, array $goal): array
    {
        if ($goal['X'] > $current['X']) {
            $current['X']++;
        }
        if ($goal['X'] < $current['X']) {
            $current['X']--;
        }

        if ($goal['Y'] > $current['Y']) {
            $current['Y']++;
        }
        if ($goal['Y'] < $current['Y']) {
            $current['Y']--;
        }

        return $current;
    }

    public function saveTailPosition(): void
    {
        $position = 'X'.$this->tail_position['X'].'Y'.$this->tail_position['Y'];

        if (isset($this->tail_visited_positions[$position])) {
            $this->tail_visited_positions[$position]++;
        } else {
            $this->tail_visited_positions[$position] = 1;
        }
    }

    public function knotTouchesPrevious($knot_number): bool
    {
        if ($knot_number === 1) {
            $previous = $this->head_position;
        } else {
            $previous = $this->knot_positions[$knot_number - 1];
        }

        if ($knot_number === $this->tail_length) {
            $current = $this->tail_position;
        } else {
            $current = $this->knot_positions[$knot_number];
        }

        if ($previous === $current) {
            return true;
        }

        if (abs($previous['X'] - $current['X']) <= 1 && abs($previous['Y'] - $current['Y']) <= 1) {
            return true;
        }

        return false;
    }
}
