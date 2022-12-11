<?php

use App\Days\Day9;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day9.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day9($array);
});

it('runs part 1', function () {
    $this->assertEquals(13, $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals(1, $this->day_class->part2());
});

it('runs part 2 extra', function () {
    $array = Arr::fromFile(Storage::get('test/day9_extra.txt'));

    $this->day_class = new Day9($array);

    $this->assertEquals(36, $this->day_class->part2());
});
