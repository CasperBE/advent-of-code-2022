<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day7
{
    public int $day = 7;

    public array $array;

    public function __construct(array $array = null)
    {
        if (! is_null($array)) {
            $this->array = $array;
        } else {
            $this->array = Arr::fromFile(Storage::get('/input/day'.$this->day.'.txt'));
        }
    }

    public function part1(): int
    {
        $file_tree = $this->parseLinesToFiletree();

        $directory_sizes = $this->calculateDirectorySizes($file_tree);

        return $this->getSumOfSizes($directory_sizes);
    }

    public function part2(): int
    {
        $file_tree = $this->parseLinesToFiletree();

        $directory_sizes = $this->calculateDirectorySizes($file_tree);

        $free_space = 70000000 - $directory_sizes['/'];

        $space_needed = 30000000 - $free_space;

        asort($directory_sizes);

        foreach ($directory_sizes as $size) {
            if ($size < $space_needed) {
                continue;
            }

            return $size;
        }

        return 0;
    }

    public function parseLinesToFileTree(): array
    {
        $current_directory = '';

        $tree = [];

        $ls = false;

        foreach ($this->array as $line) {
            if (empty($line)) {
                continue;
            }

            $start = substr($line, 0, 2);

            if ($start === '$ ') {
                // New command, not in ls mode anymore
                $ls = false;

                $command = substr($line, 2);

                if ($command === 'cd /') {
                    $current_directory = '/';
                } elseif ($command === 'cd ..') {
                    $pos = strrpos($current_directory, '/');
                    if ($pos === 0) {
                        $pos = 1;
                    }
                    $current_directory = substr($current_directory, 0, $pos);
                } elseif (str_starts_with($command, 'cd ')) {
                    if (! str_ends_with($current_directory, '/')) {
                        $current_directory .= '/';
                    }
                    $current_directory .= substr($command, 3);
                } else {
                    $ls = true;
                    continue;
                }
            }

            if ($ls) {
                // We are listing a directory
                if (str_starts_with($line, 'dir ')) {
                    continue;
                }

                [$size, $filename] = explode(' ', $line);
                $tree[$current_directory][$filename] = $size;
            }
        }

        return $tree;
    }

    public function calculateDirectorySizes($file_tree): array
    {
        $directories = [];

        foreach ($file_tree as $directory => $branch) {
            $directories[$directory] = $this->calculateBranchSize($branch);

            if ($directory !== '/') {
                $this->addSizeToParentDirectories($directory, $directories);
            }
        }

        return $directories;
    }

    public function calculateBranchSize(array $branch): int
    {
        $size = 0;

        foreach ($branch as $item_size) {
            $size += $item_size;
        }

        return $size;
    }

    public function addSizeToParentDirectories($directory, &$directories): void
    {
        $directory_size = $directories[$directory];

        do {
            $pos = strrpos($directory, '/');
            if ($pos === 0) {
                $pos = 1;
            }
            $parent_directory = substr($directory, 0, $pos);

            // add size to parent
            if (! isset($directories[$parent_directory])) {
                $directories[$parent_directory] = $directory_size;
            } else {
                $directories[$parent_directory] += $directory_size;
            }

            $directory = $parent_directory;
        } while ($parent_directory !== '/');
    }

    public function getSumOfSizes($directories, $max_size = 100000): int
    {
        $sum = 0;

        foreach ($directories as $size) {
            if ($size > $max_size) {
                continue;
            }

            $sum += $size;
        }

        return $sum;
    }
}
