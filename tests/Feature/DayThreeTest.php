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
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sum_priorities()
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayThreeController;

        $sum_of_priorities = $controller->sumOfPriorities($array);

        $this->assertEquals(157, $sum_of_priorities);
    }

    public function test_new_sum_priorities()
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayThreeController;

        $sum_of_priorities = $controller->newSumOfPriorities($array);

        $this->assertEquals(70, $sum_of_priorities);
    }

    public function test_letter_to_number()
    {
        $controller = new DayThreeController;

        $this->assertEquals(1, $controller->letterToNumber('a'));
        $this->assertEquals(26, $controller->letterToNumber('z'));
        $this->assertEquals(27, $controller->letterToNumber('A'));
        $this->assertEquals(52, $controller->letterToNumber('Z'));
    }

    public function test_common_letter()
    {
        $one = 'vJrwpWtwJgWr';
        $two = 'hcsFMMfFFhFp';

        $controller = new DayThreeController;

        $common_letter = $controller->findCommonLetter($one, $two);

        $this->assertEquals('p', $common_letter);
    }

    public function test_common_letter_of_three()
    {
        $one = 'vJrwpWtwJgWrhcsFMMfFFhFp';
        $two = 'jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL';
        $three = 'PmmdzqPrVvPwwTWBwg';

        $controller = new DayThreeController;

        $common_letter = $controller->findCommonLetter($one, $two, $three);

        $this->assertEquals('r', $common_letter);
    }
}
