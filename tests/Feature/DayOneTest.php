<?php

namespace Tests\Feature;

use App\Http\Controllers\DayOneController;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DayOneTest extends TestCase
{
    /**
     * Test day one, first task.
     *
     * @return void
     */
    public function test_the_highest_total()
    {
        $filename = "test/dayone.txt";

        $contents = Storage::get($filename);

        $array = preg_split("/\r\n|\n|\r/", $contents);

        $controller = new DayOneController;

        $highestTotal = $controller->getHighestTotal($array);

        $this->assertEquals($highestTotal, 24000);
    }

    /**
     * Test day one, second task.
     *
     * @return void
     */
    public function test_top_three_totals()
    {
        $filename = "test/dayone.txt";

        $contents = Storage::get($filename);

        $array = preg_split("/\r\n|\n|\r/", $contents);

        $controller = new DayOneController;

        $topThreeTotal = $controller->getTopThreeTotal($array);

        $this->assertEquals($topThreeTotal, 45000);
    }
}
