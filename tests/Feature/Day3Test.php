<?php

namespace Tests\Feature;

use App\Days\Day3;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Day3Test extends TestCase
{
    public string $filename = 'test/day3.txt';

    public Day3 $day_class;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $array = Arr::fromFile(Storage::get($this->filename));

        $this->day_class = new Day3($array);
    }

    public function test_part1(): void
    {
        $this->assertEquals(157, $this->day_class->part1());
    }

    public function test_part2(): void
    {
        $this->assertEquals(70, $this->day_class->part2());
    }

    /**
     * Test converting a letter to a number.
     *
     * @return void
     */
    public function test_letter_to_number(): void
    {
        $this->assertEquals(1, $this->day_class->letterToNumber('a'));
        $this->assertEquals(26, $this->day_class->letterToNumber('z'));
        $this->assertEquals(27, $this->day_class->letterToNumber('A'));
        $this->assertEquals(52, $this->day_class->letterToNumber('Z'));
    }

    /**
     * Test getting the common letter in two strings.
     *
     * @return void
     */
    public function test_common_letter_in_two_string(): void
    {
        $one = 'vJrwpWtwJgWr';
        $two = 'hcsFMMfFFhFp';

        $common_letter = $this->day_class->findCommonLetter($one, $two);

        $this->assertEquals('p', $common_letter);
    }

    /**
     * Test getting the common letter of three strings.
     *
     * @return void
     */
    public function test_common_letter_in_three_strings(): void
    {
        $one = 'vJrwpWtwJgWrhcsFMMfFFhFp';
        $two = 'jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL';
        $three = 'PmmdzqPrVvPwwTWBwg';

        $common_letter = $this->day_class->findCommonLetter($one, $two, $three);

        $this->assertEquals('r', $common_letter);
    }
}
