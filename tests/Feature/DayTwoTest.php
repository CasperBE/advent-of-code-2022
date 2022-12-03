<?php

namespace Tests\Feature;

use App\Http\Controllers\DayTwoController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DayTwoTest extends TestCase
{
    public string $filename = 'test/daytwo.txt';

    /**
     * Test day two, first task.
     *
     * @return void
     */
    public function test_total_score(): void
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayTwoController;

        $total = $controller->total($array);

        $this->assertEquals(15, $total);
    }

    /**
     * Test day two, second task.
     *
     * @return void
     */
    public function test_new_total_score(): void
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayTwoController;

        $new_total = $controller->newTotal($array);

        $this->assertEquals(12, $new_total);
    }

    /**
     * Test the scores.
     *
     * @return void
     */
    public function test_score_name(): void
    {
        $controller = new DayTwoController;

        $this->assertEquals('LOSE', $controller->scoreName('ROCK', 'PAPER'));
        $this->assertEquals('WIN', $controller->scoreName('SCISSORS', 'PAPER'));

        $this->assertEquals('LOSE', $controller->scoreName('PAPER', 'SCISSORS'));
        $this->assertEquals('WIN', $controller->scoreName('ROCK', 'SCISSORS'));

        $this->assertEquals('LOSE', $controller->scoreName('SCISSORS', 'ROCK'));
        $this->assertEquals('WIN', $controller->scoreName('PAPER', 'ROCK'));

        $this->assertEquals('DRAW', $controller->scoreName('PAPER', 'PAPER'));
        $this->assertEquals('DRAW', $controller->scoreName('ROCK', 'ROCK'));
        $this->assertEquals('DRAW', $controller->scoreName('SCISSORS', 'SCISSORS'));
    }

    /**
     * Test selecting a shape.
     *
     * @return void
     */
    public function test_select_shape(): void
    {
        $controller = new DayTwoController;

        $this->assertEquals('ROCK', $controller->selectShapeForUs('SCISSORS', 'WIN'));
        $this->assertEquals('PAPER', $controller->selectShapeForUs('ROCK', 'WIN'));
        $this->assertEquals('SCISSORS', $controller->selectShapeForUs('PAPER', 'WIN'));

        $this->assertEquals('ROCK', $controller->selectShapeForUs('PAPER', 'LOSE'));
        $this->assertEquals('PAPER', $controller->selectShapeForUs('SCISSORS', 'LOSE'));
        $this->assertEquals('SCISSORS', $controller->selectShapeForUs('ROCK', 'LOSE'));

        $this->assertEquals('ROCK', $controller->selectShapeForUs('ROCK', 'DRAW'));
        $this->assertEquals('PAPER', $controller->selectShapeForUs('PAPER', 'DRAW'));
        $this->assertEquals('SCISSORS', $controller->selectShapeForUs('SCISSORS', 'DRAW'));
    }
}
