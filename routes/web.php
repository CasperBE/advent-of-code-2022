<?php

use App\Http\Controllers\DayController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $files = File::files(base_path().'/app/Days');

    $total_files = count($files);

    $i = 0;

    foreach ($files as $file) {
        $i++;

        if ($i !== $total_files) {
            continue;
        }

        $filename = substr($file->getFilename(), 0, -4);

        $day = substr($filename, 3);

        return redirect('/day/'.$day);
    }

    return view('welcome');
});

Route::get('/day/{day}', DayController::class)->name('day');
