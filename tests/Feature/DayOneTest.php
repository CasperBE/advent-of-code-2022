<?php

namespace Tests\Feature;

use App\Http\Controllers\DayOneController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DayOneTest extends TestCase
{
    public string $filename = "test/dayone.txt";

    /**
     * Test day one, first task.
     *
     * @return void
     */
    public function test_the_highest_total()
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayOneController;

        $highestTotal = $controller->getHighestTotal($array);

        $this->assertEquals(24000, $highestTotal);
    }

    /**
     * Test day one, second task.
     *
     * @return void
     */
    public function test_top_three_totals()
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayOneController;

        $topThreeTotal = $controller->getTopThreeTotal($array);

        $this->assertEquals(45000, $topThreeTotal);
    }
}
