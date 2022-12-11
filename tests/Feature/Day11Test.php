<?php

namespace Tests\Feature;

use App\Days\Day11;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Day11Test extends TestCase
{
    public string $filename = 'test/day11.txt';

    public Day11 $day_class;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $array = Arr::fromFile(Storage::get($this->filename));

        $this->day_class = new Day11($array);
    }

    public function test_part1(): void
    {
        $this->assertEquals(10605, $this->day_class->part1());
    }

    public function test_part2(): void
    {
        $this->assertEquals(2713310158, $this->day_class->part2());
    }
}
