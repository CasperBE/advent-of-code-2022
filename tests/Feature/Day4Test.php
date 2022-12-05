<?php

namespace Tests\Feature;

use App\Days\Day4;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Day4Test extends TestCase
{
    public string $filename = 'test/day4.txt';

    public Day4 $day_class;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $array = Arr::fromFile(Storage::get($this->filename));

        $this->day_class = new Day4($array);
    }

    public function test_part1(): void
    {
        $this->assertEquals(2, $this->day_class->part1());
    }

    public function test_part2(): void
    {
        $this->assertEquals(4, $this->day_class->part2());
    }

    /**
     * Test fully contained pairs.
     *
     * @return void
     */
    public function test_fully_contained(): void
    {
        $this->assertEquals(false, $this->day_class->fullyContained('2-4', '6-8'));
        $this->assertEquals(false, $this->day_class->fullyContained('2-3', '4-5'));
        $this->assertEquals(false, $this->day_class->fullyContained('5-7', '7-9'));
        $this->assertEquals(true, $this->day_class->fullyContained('2-8', '3-7'));
        $this->assertEquals(true, $this->day_class->fullyContained('6-6', '4-6'));
        $this->assertEquals(false, $this->day_class->fullyContained('2-6', '4-8'));
    }

    /**
     * Test contained pairs.
     *
     * @return void
     */
    public function test_contained(): void
    {
        $this->assertEquals(false, $this->day_class->contained('2-4', '6-8'));
        $this->assertEquals(false, $this->day_class->contained('2-3', '4-5'));
        $this->assertEquals(true, $this->day_class->contained('5-7', '7-9'));
        $this->assertEquals(true, $this->day_class->contained('2-8', '3-7'));
        $this->assertEquals(true, $this->day_class->contained('6-6', '4-6'));
        $this->assertEquals(true, $this->day_class->contained('2-6', '4-8'));
    }
}
