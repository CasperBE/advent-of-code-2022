<?php

namespace Tests\Feature;

use App\Days\Day5;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Day5Test extends TestCase
{
    public string $filename = 'test/day5.txt';

    public Day5 $day_class;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $array = Arr::fromFile(Storage::get($this->filename));

        $this->day_class = new Day5($array);
    }

    public function test_part1(): void
    {
        $this->assertEquals('CMZ', $this->day_class->part1());
    }

    public function test_part2(): void
    {
        $this->assertEquals('MCD', $this->day_class->part2());
    }
}
