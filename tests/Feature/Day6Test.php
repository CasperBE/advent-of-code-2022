<?php

use App\Days\Day6;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day6.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day6($array);
});

it('runs part 1', function () {
    $this->assertEquals(7, $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals(19, $this->day_class->part2());
});
