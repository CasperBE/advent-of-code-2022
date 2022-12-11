<?php

use App\Days\Day1;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day1.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day1($array);
});

it('runs part 1', function () {
    $this->assertEquals(24000, $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals(45000, $this->day_class->part2());
});
