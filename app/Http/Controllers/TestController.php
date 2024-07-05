<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function soal1(): void
    {
        $total = 4;
        $strings = ['abcd', 'acbd', 'aaab', 'acbd'];
        echo $this->findString($total, $strings);
        echo '<br>';

        $total = 5;
        $strings = ['pisang', 'goreng', 'enak', 'sekali', 'rasanya'];
        echo $this->findString($total, $strings);
        echo '<br>';

        $total = 3;
        $strings = ['Satu', 'Sate', 'Tujuh'];
        echo $this->findString($total, $strings);
        echo '<br>';
    }

    private function findString(int $total, array $strings): string
    {
        for ($i = 0; $i < $total; $i++) {
            $strings[$i] = strtolower($strings[$i]);
        }

        $matches = [];

        for ($i = 0; $i < $total; $i++) {
            for ($j = $i + 1; $j < $total; $j++) {
                if ($strings[$i] == $strings[$j]) {
                    $matches[] = $j + 1;
                }
            }
            if (!empty($matches)) {
                array_unshift($matches, $i + 1);
                return implode(' ', $matches);
            }
        }

        return 'false';
    }

    public function soal2(): void
    {
        $total = 700649;
        $pay = 800000;
        $this->changesCount($total, $pay);

        $total = 657650;
        $pay = 600000;
        echo ($this->changesCount($total, $pay) === false ? 'False, kurang bayar<br>' : '');

        $total = 575650;
        $pay = 580000;
        $this->changesCount($total, $pay);
    }

    private function changesCount(int $total, int $pay): bool
    {
        $nominals = [100000, 50000, 20000, 10000, 5000, 2000, 1000, 500, 200, 100];

        if ($pay < $total) {
            return false;
        }

        $changes = $pay - $total;
        $changesRound = floor($changes / 100) * 100;

        $decimals = [];
        $changesLeft = $changesRound;

        foreach ($nominals as $nominal) {
            if ($changesLeft >= $nominal) {
                $decimalTotal = floor($changesLeft / $nominal);
                $changesLeft -= $decimalTotal * $nominal;
                $decimals[] = [$nominal, $decimalTotal];
            }
        }

        echo 'Kembalian yang harus diberikan kasir: ' . number_format($changes, 0, ',', '.') . ',<br>dibulatkan menjadi ' . number_format($changesRound, 0, ',', '.') . '<br>';
        echo 'Pecahan uang:<br>';
        foreach ($decimals as $decimal) {
            echo $decimal[1] . " " . ( $decimal[0] >= 1000 ? "lembar " : "koin ") . number_format($decimal[0], 0, ',', '.') . "\n";
        }

        return false;
    }

    public function soal3(): void
    {
        $testCases = [
            "{{[<>[{{}}]]}}" => true,
            "{<{[[{{[]<{{[{[]<>}]}}<>>}}]]}>}" => true,
            "{{[{<[[{<{<<<[{{{[]{<{[<[[<{{[[[[[<{[{<[<<[[<<{[[{[<<<<<<[{[{[{{<{[[<{<<<{<{[<>]}>}>>[]>}>]]}>}}]}]}]>>>>>>>]}]]}>>]]>>]>}]}>]]]]]}}>]]>]}>}}}}]>>>}>}]]>}]}}" => true,
            "[<{<{[{[{}[[<[<{{[<[<[[[<{{[<<<[[[<[<{{[<<{{<{<{<[<{[{{[{{{{[<<{{{<{[{[[[{<<<[{[<{<<<>>>}>]}]>>>}]]]}]}>}}}>>]}}}}]}}]}>]>}>}>}}>>]}}>]>]]]>>>]}}>]]]>]>]}}>]>]]}]}>}>]" => true,
            "[[{[[<{{{{[[[<[{[[<{{{{[{[{[[[<<{<{[{<<<[[<[{[<{{[{[<[[<<[{<<[[[{<[{[[{{<<>[<<{{<<{[[[<{}{[{{{[[{{[[<[{}]>]]}}]]}}}]}>]]]}>>}}>>]>}}]]}]>}]]]>>}]>>]]>]}]}}>]}]>]]>>>}]}>}>>]]]}]}]}}}}>]]}]>]]]}}}}>]]}]]" => true,
            "[{}<>]" => true,
            "]" => false,
            "][" => false,
            "[>]" => false,
            "[>" => false
        ];

        foreach ($testCases as $input => $expected) {
            $result = $this->isValid($input) ? 'true' : 'false';
            echo 'Input: ' . $input . '<br>Expected: ' . ($expected ? 'true' : 'false') . '<br>Output: ' . $result . '<br><br>';
        }
    }

    private function isValid(string $input): bool
    {
        $length = strlen($input);
        if ($length < 1 || $length > 4096) {
            return false;
        }

        $allowedChars = ['<', '>', '{', '}', '[', ']'];
        $openers = ['<', '{', '['];
        $closers = ['>', '}', ']'];
        $pairs = ['<' => '>', '{' => '}', '[' => ']'];

        $stack = [];

        for ($i = 0; $i < $length; $i++) {
            $char = $input[$i];

            if (!in_array($char, $allowedChars)) {
                return false;
            }

            if (in_array($char, $openers)) {
                $stack[] = $char;
            } elseif (in_array($char, $closers)) {
                if (empty($stack)) {
                    return false;
                }

                $potentialOpeners = array_reverse($stack);
                $foundMatchingOpener = false;
                foreach ($potentialOpeners as $opener) {
                    if ($pairs[$opener] === $char) {
                        array_pop($stack);
                        $foundMatchingOpener = true;
                        break;
                    }
                }

                if (!$foundMatchingOpener) {
                    return false;
                }
            }
        }

        return empty($stack);
    }

    public function soal4(): void
    {
        $testCases = [
            [
                'totalLeave' => 7,
                'joinDate' => '2021-05-01',
                'leaveDate' => '2021-07-05',
                'leaveDuration' => 1
            ],
            [
                'totalLeave' => 7,
                'joinDate' => '2021-05-01',
                'leaveDate' => '2021-11-05',
                'leaveDuration' => 3
            ],
            [
                'totalLeave' => 7,
                'joinDate' => '2021-01-05',
                'leaveDate' => '2021-12-18',
                'leaveDuration' => 1
            ],
            [
                'totalLeave' => 7,
                'joinDate' => '2021-01-05',
                'leaveDate' => '2021-12-18',
                'leaveDuration' => 3
            ]
        ];

        foreach ($testCases as $testCase) {
            $result = $this->takeLeave(
                $testCase['totalLeave'],
                $testCase['joinDate'],
                $testCase['leaveDate'],
                $testCase['leaveDuration']
            );
            echo 'Input:';
            echo '<br>Jumlah Cuti Bersama = ' . $testCase['totalLeave'];
            echo '<br>Tanggal join karyawan = ' . $testCase['joinDate'];
            echo '<br>Tanggal rencana cuti = ' . $testCase['leaveDate'];
            echo '<br>Durasi cuti (hari) = ' . $testCase['leaveDuration'];
            echo '<br>Output:';
            echo $result['status'] ? '<br>True' : '<br>False';
            echo '<br>Alasan: ' . $result['reason'];
            echo '<br><br>';
        }
    }

    private function takeLeave(int $totalLeave, string $joinDate, string $leaveDate, int $leaveDuration): array
    {
        $officeLeave = 14;
        $personalLeave = $officeLeave - $totalLeave;
        $joinDate = new \DateTime($joinDate);
        $leaveDate = new \DateTime($leaveDate);
        $leaveDuration = (int) $leaveDuration;

        $joinDatePlus180Days = clone $joinDate;
        $joinDatePlus180Days->modify('+180 days');
        $joinYear = (int) $joinDate->format('Y');

        $endOfYear = new \DateTime($joinYear . '-12-31');

        if ($joinDatePlus180Days < $endOfYear) {
            $remainingDays = (int) $endOfYear->diff($joinDatePlus180Days)->format('%a');
        } else {
            $remainingDays = 0;
        }

        $quotaForNewEmployee = floor($remainingDays / 365 * $personalLeave);

        if ($leaveDate < $joinDatePlus180Days) {
            return [
                'status' => false,
                'reason' => 'Belum 180 hari sejak tanggal join karyawan'
            ];
        }

        if ($leaveDuration > 3) {
            return [
                'status' => false,
                'reason' => 'Durasi cuti lebih dari 3 hari berturut-turut'
            ];
        }

        if ($joinDate->format('Y') == $leaveDate->format('Y') && $leaveDuration > $quotaForNewEmployee) {
            return [
                'status' => false,
                'reason' => 'Hanya boleh mengambil ' . $quotaForNewEmployee . ' hari cuti di tahun pertama'
            ];
        }

        return [
            'status' => true,
            'reason' => 'Cuti diperbolehkan'
        ];
    }
}
