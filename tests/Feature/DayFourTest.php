<?php

namespace Tests\Feature;

use App\Http\Controllers\DayFourController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DayFourTest extends TestCase
{
    public string $filename = 'test/dayfour.txt';

    /**
     * Test day three, first task.
     *
     * @return void
     */
    public function test_fully_contained_pairs(): void
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayFourController;

        $number_of_fully_contained_pairs = $controller->numberOfFullyContainedPairs($array);

        $this->assertEquals(2, $number_of_fully_contained_pairs);
    }

    /**
     * Test day three, second task.
     *
     * @return void
     */
    public function test_contained_pairs(): void
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayFourController;

        $number_of_contained_pairs = $controller->numberOfContainedPairs($array);

        $this->assertEquals(4, $number_of_contained_pairs);
    }

    /**
     * Test fully contained pairs.
     *
     * @return void
     */
    public function test_fully_contained(): void
    {
        $controller = new DayFourController;

        $this->assertEquals(false, $controller->fullyContained('2-4', '6-8'));
        $this->assertEquals(false, $controller->fullyContained('2-3', '4-5'));
        $this->assertEquals(false, $controller->fullyContained('5-7', '7-9'));
        $this->assertEquals(true, $controller->fullyContained('2-8', '3-7'));
        $this->assertEquals(true, $controller->fullyContained('6-6', '4-6'));
        $this->assertEquals(false, $controller->fullyContained('2-6', '4-8'));
    }

    /**
     * Test contained pairs.
     *
     * @return void
     */
    public function test_contained(): void
    {
        $controller = new DayFourController;

        $this->assertEquals(false, $controller->contained('2-4', '6-8'));
        $this->assertEquals(false, $controller->contained('2-3', '4-5'));
        $this->assertEquals(true, $controller->contained('5-7', '7-9'));
        $this->assertEquals(true, $controller->contained('2-8', '3-7'));
        $this->assertEquals(true, $controller->contained('6-6', '4-6'));
        $this->assertEquals(true, $controller->contained('2-6', '4-8'));
    }
}
