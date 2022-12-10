<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day10
{
    public int $day = 10;

    public array $array;

    public int $cpu_cycle;

    public int $cpu_register_x;

    public int $current_command_cycles;

    public int $current_command_cpu_register_x_add_value;

    public array $signal_strengths_checks;

    public int $signal_strengths_sum;

    public int $crt_cycle;

    public int $sprite_position;

    public int $current_command_sprite_position_add_value;

    public string $crt;

    public int $crt_line_position;

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
        $this->reset();

        for ($i = 20; $i <= 220; $i += 40) {
            $this->signal_strengths_checks[] = $i;
        }

        foreach ($this->array as $line) {
            if (empty($line)) {
                continue;
            }

            $this->executeProgramInstruction($line);
        }

        return $this->signal_strengths_sum;
    }

    public function part2(): string
    {
        $this->resetCrt();

        foreach ($this->array as $line) {
            if (empty($line)) {
                continue;
            }

            $this->executeCrtInstruction($line);
        }

        return $this->crt;
    }

    public function reset(): void
    {
        $this->cpu_cycle = 1;

        $this->cpu_register_x = 1;

        $this->signal_strengths_sum = 0;
    }

    public function executeProgramInstruction($instruction): void
    {
        $this->parseInstruction($instruction);

        $this->cycleCpu();
    }

    public function parseInstruction($instruction): void
    {
        [$command, $value] = array_pad(explode(' ', $instruction), 2, null);

        switch ($command) {
            case 'addx':
                $this->current_command_cpu_register_x_add_value = $value;
                $this->current_command_cycles = 2;
                break;
            case 'noop':
                $this->current_command_cpu_register_x_add_value = 0;
                $this->current_command_cycles = 1;
                break;
        }
    }

    public function cycleCpu(): void
    {
        for ($i = 0; $i < $this->current_command_cycles; $i++) {
            $this->handleSignalStrenth();

            $this->cpu_cycle++;
        }

        $this->cpu_register_x += $this->current_command_cpu_register_x_add_value;
    }

    public function getSignalStrength(): int
    {
        return $this->cpu_cycle * $this->cpu_register_x;
    }

    public function handleSignalStrenth(): void
    {
        if (in_array($this->cpu_cycle, $this->signal_strengths_checks)) {
            $this->signal_strengths_sum += $this->getSignalStrength();
        }
    }

    public function resetCrt(): void
    {
        $this->crt_cycle = 1;

        $this->sprite_position = 1;

        $this->crt_line_position = 0;

        $this->crt = '';
    }

    public function executeCrtInstruction($instruction): void
    {
        $this->parseCrtInstruction($instruction);

        $this->cycleCrt();
    }

    public function parseCrtInstruction($instruction): void
    {
        [$command, $value] = array_pad(explode(' ', $instruction), 2, null);

        switch ($command) {
            case 'addx':
                $this->current_command_sprite_position_add_value = $value;
                $this->current_command_cycles = 2;
                break;
            case 'noop':
                $this->current_command_sprite_position_add_value = 0;
                $this->current_command_cycles = 1;
                break;
        }
    }

    public function cycleCrt(): void
    {
        for ($i = 0; $i < $this->current_command_cycles; $i++) {
            $this->drawOnCrt();

            $this->increaseCrtLinePosition();

            $this->crt_cycle++;
        }

        $this->sprite_position += $this->current_command_sprite_position_add_value;
    }

    public function drawOnCrt(): void
    {
        //echo "sprite pos: $this->sprite_position\n";
        //echo "crt pos: $this->crt_line_position\n";
        if (abs($this->crt_line_position - $this->sprite_position) <= 1) {
            $this->crt .= '#';
        } else {
            $this->crt .= '.';
        }
    }

    public function increaseCrtLinePosition(): void
    {
        $this->crt_line_position++;

        if ($this->crt_line_position > 39) {
            $this->crt .= "\n";

            $this->crt_line_position = 0;
        }
    }
}
