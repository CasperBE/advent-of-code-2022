<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeDayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:day {number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a day scaffolding';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->createDayFile();

        $this->createDayTestFile();

        return Command::SUCCESS;
    }

    public function createDayFile()
    {
        $path = base_path('app/Days').'/Day'.$this->argument('number').'.php';
        $contents = $this->getStubContents($this->getDayStubPath(), $this->getStubVariables());
        if (! $this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File $path created");
        } else {
            $this->info("File $path already exits");
        }
    }

    public function createDayTestFile()
    {
        $path = base_path('tests/Feature').'/Day'.$this->argument('number').'Test.php';
        $contents = $this->getStubContents($this->getDayTestStubPath(), $this->getStubVariables());
        if (! $this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File $path created");
        } else {
            $this->info("File $path already exits");
        }
    }

    public function getStubContents($stub, $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    public function getDayStubPath(): string
    {
        return __DIR__.'/../../../stubs/day.stub';
    }

    public function getDayTestStubPath(): string
    {
        return __DIR__.'/../../../stubs/daytest.stub';
    }

    public function getStubVariables(): array
    {
        return [
            'NUMBER' => $this->argument('number'),
        ];
    }
}
