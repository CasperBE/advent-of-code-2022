<?php

use App\Days\Day7;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day7.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day7($array);
});

it('runs part 1', function () {
    $this->assertEquals(95437, $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals(24933642, $this->day_class->part2());
});
