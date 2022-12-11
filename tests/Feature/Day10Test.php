<?php

use App\Days\Day10;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day10.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day10($array);
});

it('runs part 1', function () {
    $this->assertEquals(13140, $this->day_class->part1());
});

it('runs part 2', function () {
    $expected_output = '##..##..##..##..##..##..##..##..##..##..
###...###...###...###...###...###...###.
####....####....####....####....####....
#####.....#####.....#####.....#####.....
######......######......######......####
#######.......#######.......#######.....
';

    $this->assertEquals($expected_output, $this->day_class->part2());
});
