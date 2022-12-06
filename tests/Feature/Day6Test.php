<?php

namespace Tests\Feature;

use App\Days\Day6;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Day6Test extends TestCase
{
    public string $filename = 'test/day6.txt';

    public Day6 $day_class;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $array = Arr::fromFile(Storage::get($this->filename));

        $this->day_class = new Day6($array);
    }

    public function test_part1(): void
    {
        $this->assertEquals(7, $this->day_class->part1());
    }

    public function test_part2(): void
    {
        $this->assertEquals(19, $this->day_class->part2());
    }
}
