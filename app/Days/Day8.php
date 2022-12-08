<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\String\s;

class Day8
{
    public int $day = 8;

    public array $array;

    public int $map_length = 0;

    public int $map_height = 0;

    public array $map;

    public function __construct(array $array = null)
    {
        if (! is_null($array)) {
            $this->array = $array;
        } else {
            $this->array = Arr::fromFile(Storage::get('/input/day'.$this->day.'.txt'));
        }

        $this->setMap();

        $this->setMapSize();
    }

    public function part1(): int
    {
        $total_trees_visible = 0;

        for ($x = 1; $x < ($this->map_length - 1); $x++) {
            for ($y = 1; $y < ($this->map_height - 1); $y++) {
                if ($this->isVisible($x, $y)) {
                    $total_trees_visible++;
                }
            }
        }

        $edge_length = $this->map_length + ($this->map_height - 1) + ($this->map_length - 1) + ($this->map_height - 2);

        return $total_trees_visible + $edge_length;
    }

    public function part2(): int
    {
        $highest_scenic_score = 0;

        for ($x = 1; $x < ($this->map_length - 1); $x++) {
            for ($y = 1; $y < ($this->map_height - 1); $y++) {
                $scenic_score = $this->scenicScore($x, $y);
                if ($scenic_score > $highest_scenic_score) {
                    $highest_scenic_score = $scenic_score;
                }
            }
        }

        return $highest_scenic_score;
    }

    public function setMapSize(): void
    {
        $this->map_height = count($this->map);

        $this->map_length = count($this->map[0]);
    }

    public function setMap(): void
    {
        $map = [];
        foreach ($this->array as $line) {
            if (empty($line)) {
                continue;
            }

            $map[] = str_split($line);
        }

        $this->map = $map;
    }

    public function isVisible($x, $y): bool
    {
        $height = $this->map[$x][$y];

        // Look for visibility on the right
        $blocked = false;
        for ($i = ($y + 1); $i < $this->map_length; $i++) {
            if ($height <= $this->map[$x][$i]) {
                $blocked = true;
            }
        }

        if (! $blocked) {
            return true;
        }

        // Look for visibility on the left
        $blocked = false;
        for ($i = ($y - 1); $i >= 0; $i--) {
            if ($height <= $this->map[$x][$i]) {
                $blocked = true;
            }
        }

        if (! $blocked) {
            return true;
        }

        // Look for visibility on the top
        $blocked = false;
        for ($i = ($x - 1); $i >= 0; $i--) {
            if ($height <= $this->map[$i][$y]) {
                $blocked = true;
            }
        }

        if (! $blocked) {
            return true;
        }

        // Look for visibility on the bottom
        $blocked = false;
        for ($i = ($x + 1); $i < $this->map_height; $i++) {
            if ($height <= $this->map[$i][$y]) {
                $blocked = true;
            }
        }

        if (! $blocked) {
            return true;
        }

        return false;
    }

    public function scenicScore($x, $y): int
    {
        $height = $this->map[$x][$y];

        // Get score to the right
        $score_right = 0;
        for ($i = ($y + 1); $i < $this->map_length; $i++) {
            $score_right++;
            if ($height <= $this->map[$x][$i]) {
                break;
            }
        }

        // Get score to the left
        $score_left = 0;
        for ($i = ($y - 1); $i >= 0; $i--) {
            $score_left++;
            if ($height <= $this->map[$x][$i]) {
                break;
            }
        }

        // Get score to the top
        $score_top = 0;
        for ($i = ($x - 1); $i >= 0; $i--) {
            $score_top++;
            if ($height <= $this->map[$i][$y]) {
                break;
            }
        }

        // Get score to the bottom
        $score_bottom = 0;
        for ($i = ($x + 1); $i < $this->map_height; $i++) {
            $score_bottom++;
            if ($height <= $this->map[$i][$y]) {
                break;
            }
        }

        return $score_right * $score_left * $score_top * $score_bottom;
    }
}
