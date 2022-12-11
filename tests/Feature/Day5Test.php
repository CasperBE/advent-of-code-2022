<?php

use App\Days\Day5;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day5.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day5($array);
});

it('runs part 1', function () {
    $this->assertEquals('CMZ', $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals('MCD', $this->day_class->part2());
});
