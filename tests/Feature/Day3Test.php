<?php

use App\Days\Day3;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day3.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day3($array);
});

it('runs part 1', function () {
    $this->assertEquals(157, $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals(70, $this->day_class->part2());
});

it('converts a letter to the correct number', function () {
    $this->assertEquals(1, $this->day_class->letterToNumber('a'));
    $this->assertEquals(26, $this->day_class->letterToNumber('z'));
    $this->assertEquals(27, $this->day_class->letterToNumber('A'));
    $this->assertEquals(52, $this->day_class->letterToNumber('Z'));
});

it('gets the common letter from two strings', function () {
    $one = 'vJrwpWtwJgWr';
    $two = 'hcsFMMfFFhFp';

    $common_letter = $this->day_class->findCommonLetter($one, $two);

    $this->assertEquals('p', $common_letter);
});

it('gets the correct letter from three strings', function () {
    $one = 'vJrwpWtwJgWrhcsFMMfFFhFp';
    $two = 'jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL';
    $three = 'PmmdzqPrVvPwwTWBwg';

    $common_letter = $this->day_class->findCommonLetter($one, $two, $three);

    $this->assertEquals('r', $common_letter);
});
