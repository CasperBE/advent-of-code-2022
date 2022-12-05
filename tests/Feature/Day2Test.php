<?php

namespace Tests\Feature;

use App\Days\Day2;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Day2Test extends TestCase
{
    public string $filename = 'test/day2.txt';

    public Day2 $day_class;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $array = Arr::fromFile(Storage::get($this->filename));

        $this->day_class = new Day2($array);
    }

    public function test_part1(): void
    {
        $this->assertEquals(15, $this->day_class->part1());
    }

    public function test_part2(): void
    {
        $this->assertEquals(12, $this->day_class->part2());
    }

    /**
     * Test the scores.
     *
     * @return void
     */
    public function test_score_name(): void
    {
        $this->assertEquals('LOSE', $this->day_class->scoreName('ROCK', 'PAPER'));
        $this->assertEquals('WIN', $this->day_class->scoreName('SCISSORS', 'PAPER'));

        $this->assertEquals('LOSE', $this->day_class->scoreName('PAPER', 'SCISSORS'));
        $this->assertEquals('WIN', $this->day_class->scoreName('ROCK', 'SCISSORS'));

        $this->assertEquals('LOSE', $this->day_class->scoreName('SCISSORS', 'ROCK'));
        $this->assertEquals('WIN', $this->day_class->scoreName('PAPER', 'ROCK'));

        $this->assertEquals('DRAW', $this->day_class->scoreName('PAPER', 'PAPER'));
        $this->assertEquals('DRAW', $this->day_class->scoreName('ROCK', 'ROCK'));
        $this->assertEquals('DRAW', $this->day_class->scoreName('SCISSORS', 'SCISSORS'));
    }

    /**
     * Test selecting a shape.
     *
     * @return void
     */
    public function test_select_shape(): void
    {
        $this->assertEquals('ROCK', $this->day_class->selectShapeForUs('SCISSORS', 'WIN'));
        $this->assertEquals('PAPER', $this->day_class->selectShapeForUs('ROCK', 'WIN'));
        $this->assertEquals('SCISSORS', $this->day_class->selectShapeForUs('PAPER', 'WIN'));

        $this->assertEquals('ROCK', $this->day_class->selectShapeForUs('PAPER', 'LOSE'));
        $this->assertEquals('PAPER', $this->day_class->selectShapeForUs('SCISSORS', 'LOSE'));
        $this->assertEquals('SCISSORS', $this->day_class->selectShapeForUs('ROCK', 'LOSE'));

        $this->assertEquals('ROCK', $this->day_class->selectShapeForUs('ROCK', 'DRAW'));
        $this->assertEquals('PAPER', $this->day_class->selectShapeForUs('PAPER', 'DRAW'));
        $this->assertEquals('SCISSORS', $this->day_class->selectShapeForUs('SCISSORS', 'DRAW'));
    }
}
