<?php

namespace Tests\Feature;

use App\Days\Day1;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Day1Test extends TestCase
{
    public string $filename = 'test/day1.txt';

    public Day1 $day_class;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $array = Arr::fromFile(Storage::get($this->filename));

        $this->day_class = new Day1($array);
    }

    public function test_part1(): void
    {
        $this->assertEquals(24000, $this->day_class->part1());
    }

    public function test_part2(): void
    {
        $this->assertEquals(45000, $this->day_class->part2());
    }
}
