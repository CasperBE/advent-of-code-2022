<?php

namespace Tests\Feature;

use App\Http\Controllers\DayThreeController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DayThreeTest extends TestCase
{
    public string $filename = 'test/daythree.txt';

    /**
     * Test day three, first task.
     *
     * @return void
     */
    public function test_sum_priorities(): void
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayThreeController;

        $sum_of_priorities = $controller->sumOfPriorities($array);

        $this->assertEquals(157, $sum_of_priorities);
    }

    /**
     * Test day three, second task.
     *
     * @return void
     */
    public function test_new_sum_priorities(): void
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayThreeController;

        $sum_of_priorities = $controller->newSumOfPriorities($array);

        $this->assertEquals(70, $sum_of_priorities);
    }

    /**
     * Test converting a letter to a number.
     *
     * @return void
     */
    public function test_letter_to_number(): void
    {
        $controller = new DayThreeController;

        $this->assertEquals(1, $controller->letterToNumber('a'));
        $this->assertEquals(26, $controller->letterToNumber('z'));
        $this->assertEquals(27, $controller->letterToNumber('A'));
        $this->assertEquals(52, $controller->letterToNumber('Z'));
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

        $controller = new DayThreeController;

        $common_letter = $controller->findCommonLetter($one, $two);

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

        $controller = new DayThreeController;

        $common_letter = $controller->findCommonLetter($one, $two, $three);

        $this->assertEquals('r', $common_letter);
    }
}
