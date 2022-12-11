<?php

namespace Tests\Feature;

use App\Days\Day10;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Day10Test extends TestCase
{
    public string $filename = 'test/day10.txt';

    public Day10 $day_class;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $array = Arr::fromFile(Storage::get($this->filename));

        $this->day_class = new Day10($array);
    }

    public function test_part1(): void
    {
        $this->assertEquals(13140, $this->day_class->part1());
    }

    public function test_part2(): void
    {
        $expected_output = '##..##..##..##..##..##..##..##..##..##..
###...###...###...###...###...###...###.
####....####....####....####....####....
#####.....#####.....#####.....#####.....
######......######......######......####
#######.......#######.......#######.....
';

        $this->assertEquals($expected_output, $this->day_class->part2());
    }
}