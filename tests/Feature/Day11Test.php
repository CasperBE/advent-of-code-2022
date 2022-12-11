<?php

use App\Days\Day11;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day11.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day11($array);
});

it('runs part 1', function () {
    $this->assertEquals(10605, $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals(2713310158, $this->day_class->part2());
});
