<?php

namespace Tests\Feature;

use App\Http\Controllers\DayTwoController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DayTwoTest extends TestCase
{
    public string $filename = "test/daytwo.txt";

    /**
     * Test day two, first task.
     *
     * @return void
     */
    public function test_total_score()
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayTwoController;

        $total = $controller->total($array);

        $this->assertEquals(15, $total);
    }

    /**
     * Test day two, second task.
     *
     * @return void
     */
    public function test_new_total_score()
    {
        $array = Arr::fromFile(Storage::get($this->filename));

        $controller = new DayTwoController;

        $new_total = $controller->newTotal($array);

        $this->assertEquals(12, $new_total);
    }
}
