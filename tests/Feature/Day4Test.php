<?php

use App\Days\Day4;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day4.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day4($array);
});

it('runs part 1', function () {
    $this->assertEquals(2, $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals(4, $this->day_class->part2());
});

it('checks fully contained', function () {
    $this->assertEquals(false, $this->day_class->fullyContained('2-4', '6-8'));
    $this->assertEquals(false, $this->day_class->fullyContained('2-3', '4-5'));
    $this->assertEquals(false, $this->day_class->fullyContained('5-7', '7-9'));
    $this->assertEquals(true, $this->day_class->fullyContained('2-8', '3-7'));
    $this->assertEquals(true, $this->day_class->fullyContained('6-6', '4-6'));
    $this->assertEquals(false, $this->day_class->fullyContained('2-6', '4-8'));
});

it('checks contained', function () {
    $this->assertEquals(false, $this->day_class->contained('2-4', '6-8'));
    $this->assertEquals(false, $this->day_class->contained('2-3', '4-5'));
    $this->assertEquals(true, $this->day_class->contained('5-7', '7-9'));
    $this->assertEquals(true, $this->day_class->contained('2-8', '3-7'));
    $this->assertEquals(true, $this->day_class->contained('6-6', '4-6'));
    $this->assertEquals(true, $this->day_class->contained('2-6', '4-8'));
});
