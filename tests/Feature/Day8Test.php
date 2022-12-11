<?php

use App\Days\Day8;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day8.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day8($array);
});

it('runs part 1', function () {
    $this->assertEquals(21, $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals(8, $this->day_class->part2());
});
