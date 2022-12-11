<?php

use App\Days\Day2;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $filename = 'test/day2.txt';

    $array = Arr::fromFile(Storage::get($filename));

    $this->day_class = new Day2($array);
});

it('runs part 1', function () {
    $this->assertEquals(15, $this->day_class->part1());
});

it('runs part 2', function () {
    $this->assertEquals(12, $this->day_class->part2());
});

it('returns the correct score name', function () {
    $this->assertEquals('LOSE', $this->day_class->scoreName('ROCK', 'PAPER'));
    $this->assertEquals('WIN', $this->day_class->scoreName('SCISSORS', 'PAPER'));

    $this->assertEquals('LOSE', $this->day_class->scoreName('PAPER', 'SCISSORS'));
    $this->assertEquals('WIN', $this->day_class->scoreName('ROCK', 'SCISSORS'));

    $this->assertEquals('LOSE', $this->day_class->scoreName('SCISSORS', 'ROCK'));
    $this->assertEquals('WIN', $this->day_class->scoreName('PAPER', 'ROCK'));

    $this->assertEquals('DRAW', $this->day_class->scoreName('PAPER', 'PAPER'));
    $this->assertEquals('DRAW', $this->day_class->scoreName('ROCK', 'ROCK'));
    $this->assertEquals('DRAW', $this->day_class->scoreName('SCISSORS', 'SCISSORS'));
});

it('returns the correct shape name', function () {
    $this->assertEquals('ROCK', $this->day_class->selectShapeForUs('SCISSORS', 'WIN'));
    $this->assertEquals('PAPER', $this->day_class->selectShapeForUs('ROCK', 'WIN'));
    $this->assertEquals('SCISSORS', $this->day_class->selectShapeForUs('PAPER', 'WIN'));

    $this->assertEquals('ROCK', $this->day_class->selectShapeForUs('PAPER', 'LOSE'));
    $this->assertEquals('PAPER', $this->day_class->selectShapeForUs('SCISSORS', 'LOSE'));
    $this->assertEquals('SCISSORS', $this->day_class->selectShapeForUs('ROCK', 'LOSE'));

    $this->assertEquals('ROCK', $this->day_class->selectShapeForUs('ROCK', 'DRAW'));
    $this->assertEquals('PAPER', $this->day_class->selectShapeForUs('PAPER', 'DRAW'));
    $this->assertEquals('SCISSORS', $this->day_class->selectShapeForUs('SCISSORS', 'DRAW'));
});
