<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DayTwoController extends Controller
{
    public string $filename = "input/daytwo.txt";

    public array $encrypted_guide_for_opponent = [
        'A' => 'ROCK',
        'B' => 'PAPER',
        'C' => 'SCISSORS',
    ];

    public array $encrypted_guide_for_us = [
        'X' => 'ROCK',
        'Y' => 'PAPER',
        'Z' => 'SCISSORS',
    ];

    public array $outcomes = [
        'X' => 'LOSE',
        'Y' => 'DRAW',
        'Z' => 'WIN',
    ];

    public array $shape_values = [
        'ROCK' => 1,
        'PAPER' => 2,
        'SCISSORS' => 3,
    ];

    public array $score_values = [
        'LOSE' => 0,
        'DRAW' => 3,
        'WIN' => 6,
    ];

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $array = $this->fileToArray(Storage::get($this->filename));

        echo "1) Total: " . $this->total($array) . "<br>\n";
        echo "2) New Total: " . $this->newTotal($array) . "<br>\n";
    }

    /**
     * Get the total score.
     *
     * @param array $array
     * @return int
     */
    public function total(array $array): int
    {
        $total = 0;

        foreach ($array as $line) {
            if (empty($line)) {
                continue;
            }

            [$key_shape_opponent, $key_shape_us] = explode(' ', $line);

            $shape_us = $this->encrypted_guide_for_us[$key_shape_us];
            $shape_opponent = $this->encrypted_guide_for_opponent[$key_shape_opponent];

            $shape_value_us = $this->shape_values[$shape_us];

            $score_name = $this->scoreName($shape_us, $shape_opponent);

            $total += ($shape_value_us + $this->score_values[$score_name]);
        }

        return $total;
    }

    /**
     * Get the new total score.
     *
     * @param array $array
     * @return int
     */
    public function newTotal(array $array): int
    {
        $total = 0;

        foreach ($array as $line) {
            if (empty($line)) {
                continue;
            }

            list($key_shape_opponent, $key_outcome_us) = explode(' ', $line);

            $shape_opponent = $this->encrypted_guide_for_opponent[$key_shape_opponent];
            $outcome_us = $this->outcomes[$key_outcome_us];

            $shape_us = $this->selectShapeForUs($shape_opponent, $outcome_us);
            $shape_value_us = $this->shape_values[$shape_us];

            $score_name = $this->scoreName($shape_us, $shape_opponent);

            $total += ($shape_value_us + $this->score_values[$score_name]);
        }

        return $total;
    }

    /**
     * Get the score name.
     *
     * @param string $shape_us
     * @param string $shape_opponent
     * @return string
     */
    public function scoreName(string $shape_us, string $shape_opponent): string
    {
        if ($shape_us === $shape_opponent) {
            return 'DRAW';
        }

        if (
            ($shape_us === 'ROCK' && $shape_opponent === 'SCISSORS')
            || ($shape_us === 'SCISSORS' && $shape_opponent === 'PAPER')
            || ($shape_us === 'PAPER' && $shape_opponent === 'ROCK')
        ) {
            return 'WIN';
        }

        return 'LOSE';
    }

    /**
     * Get the shape to use for a particular outcome with a given opponent's shape.
     *
     * @param string $shape_opponent
     * @param string $outcome
     * @return string
     */
    public function selectShapeForUs(string $shape_opponent, string $outcome): string
    {
        if ($outcome === 'DRAW') {
            return $shape_opponent;
        }

        if ($outcome === 'WIN') {
            if ($shape_opponent === 'SCISSORS') {
                return 'ROCK';
            }

            if ($shape_opponent === 'PAPER') {
                return 'SCISSORS';
            }

            return 'PAPER';
        }

        if ($shape_opponent === 'SCISSORS') {
            return 'PAPER';
        }

        if ($shape_opponent === 'PAPER') {
            return 'ROCK';
        }

        return 'SCISSORS';
    }
}
