<?php

namespace App\Days;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day11
{
    public int $day = 11;

    public array $array;

    public array $monkeys;

    public int $lcm;

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
        $this->getMonkeys($this->array);

        for ($i = 0; $i < 20; $i++) {
            $this->round();
        }

        return $this->monkeyBusiness();
    }

    public function part2(): int
    {
        $this->getMonkeys($this->array);

        $this->setLcm();

        for ($i = 0; $i < 10000; $i++) {
            $this->round(false);
        }

        return $this->monkeyBusiness();
    }

    public function getMonkeys(array $input): void
    {
        // Reset monkeys
        $this->monkeys = [];

        $monkey_data = [];

        $monkey = [];

        foreach ($input as $line) {
            if (empty($line)) {
                $monkey_data[] = $monkey;
                $monkey = [];
                continue;
            }

            $monkey[] = $line;
        }

        foreach ($monkey_data as $monkey) {
            $this->monkeys[] = $this->parseMonkeyData($monkey);
        }
    }

    public function parseMonkeyData(array $data): array
    {
        $monkey = [
            'inspection_count' => 0,
        ];

        foreach ($data as $info) {
            $info = trim($info);

            if (str_starts_with($info, 'Monkey ')) {
                continue;
            }

            $search = 'Starting items: ';
            if (str_starts_with($info, $search)) {
                $items_line = substr($info, strlen($search));
                $items = [];
                foreach (explode(', ', $items_line) as $item) {
                    $items[] = (float) $item;
                }
                $monkey['items'] = $items;
                continue;
            }

            $search = 'Operation: new = old ';
            if (str_starts_with($info, $search)) {
                $monkey['operation'] = substr($info, strlen($search));
                continue;
            }

            $search = 'Test: divisible by ';
            if (str_starts_with($info, $search)) {
                $monkey['test'] = substr($info, strlen($search));
                continue;
            }

            $search = 'If true: throw to monkey ';
            if (str_starts_with($info, $search)) {
                $monkey['test_true'] = substr($info, strlen($search));
                continue;
            }

            $search = 'If false: throw to monkey ';
            if (str_starts_with($info, $search)) {
                $monkey['test_false'] = substr($info, strlen($search));
                continue;
            }
        }

        return $monkey;
    }

    public function round($relief = true): void
    {
        foreach ($this->monkeys as $monkey_id => $monkey) {
            $items = $this->monkeys[$monkey_id]['items'];

            foreach ($items as $item_id => $item) {
                $this->monkeys[$monkey_id]['inspection_count']++;

                $worry_level = $item;

                $operation_number = substr($monkey['operation'], 2);
                $operation_number = ($operation_number === 'old') ? $worry_level : $operation_number;

                if (str_starts_with($monkey['operation'], '*')) {
                    $worry_level = bcmul($worry_level, $operation_number);
                } else {
                    $worry_level = bcadd($worry_level, $operation_number);
                }

                if ($relief) {
                    $worry_level = bcdiv($worry_level, '3');
                    $worry_level = $this->bcfloor($worry_level);
                } else {
                    $worry_level = bcmod($worry_level, $this->lcm);
                }

                if (bcmod($worry_level, $monkey['test']) === '0') {
                    $this->monkeys[$monkey['test_true']]['items'][] = $worry_level;
                } else {
                    $this->monkeys[$monkey['test_false']]['items'][] = $worry_level;
                }

                unset($this->monkeys[$monkey_id]['items'][$item_id]);
            }
        }
    }

    public function monkeyBusiness(): int
    {
        $monkeys_inspections = [];

        foreach ($this->monkeys as $monkey) {
            $monkeys_inspections[] = $monkey['inspection_count'];
        }

        arsort($monkeys_inspections);

        $monkeys_inspections = array_values($monkeys_inspections);

        return $monkeys_inspections[0] * $monkeys_inspections[1];
    }

    public function setLcm()
    {
        $dividers = [];
        foreach ($this->monkeys as $monkey) {
            $dividers[] = $monkey['test'];
        }
        $this->lcm = $this->lcm($dividers);
    }

    public function bcnegative($n): bool
    {
        return str_starts_with($n, '-'); // Is the number less than 0?
    }

    public function bcceil($n): string
    {
        return $this->bcnegative($n) ? (($v = $this->bcfloor(substr($n, 1))) ? "-$v" : $v)
            : bcadd(strtok($n, '.'), strtok('.') != 0);
    }

    public function bcfloor($n): string
    {
        return $this->bcnegative($n) ? '-'.$this->bcceil(substr($n, 1)) : strtok($n, '.');
    }

    public function gcd($a, $b)
    {
        if ($b == 0) {
            return $a;
        }

        return $this->gcd($b, $a % $b);
    }

    public function lcm($arr)
    {
        $n = count($arr);

        $ans = $arr[0];

        for ($i = 1; $i < $n; $i++) {
            $ans = ((($arr[$i] * $ans)) / ($this->gcd($arr[$i], $ans)));
        }

        return $ans;
    }
}
