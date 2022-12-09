<?php

namespace Tests\Feature;

use App\Days\Day9;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Day9Test extends TestCase
{
    public string $filename = 'test/day9.txt';

    public Day9 $day_class;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $array = Arr::fromFile(Storage::get($this->filename));

        $this->day_class = new Day9($array);
    }

    public function test_part1(): void
    {
        $this->assertEquals(13, $this->day_class->part1());
    }

    public function test_part2(): void
    {
        $this->assertEquals(1, $this->day_class->part2());
    }

    public function test_part2_extra(): void
    {
        $array = Arr::fromFile(Storage::get('test/day9_extra.txt'));

        $this->day_class = new Day9($array);

        $this->assertEquals(36, $this->day_class->part2());
    }
}
