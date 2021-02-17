<?php

namespace App\Helpers;

use Carbon\Carbon;

class CreditHelper
{
    public static function liquidate($data, $getFullData = true)
    {
        $credit = [];
        $interest = $data['interest'];
        $other_value = $data['other_value'];
        $transport_value = $data['transport_value'];
        $capital_value = $data['capital_value'];
        $fee = $data['fee'];
        $start_date = Carbon::parse($data['start_date']);
        $total = $capital_value + $transport_value + $other_value;
        $total_interest = ($total * ($interest / 100)) * $fee;
        $total_credit = $total + $total_interest;
        $value_fee = $total_credit / $fee;
        $credit['total_credit'] = number_format($total_credit, 2, '.', ',');
        $credit['total_interest'] = number_format($total_interest, 2, '.', ',');

        $interest_value = $total_interest / $fee;
        $total_capital = 0;
        $capital_fee = $value_fee - $interest_value;

        if ($getFullData) {
            for ($i = 1; $i <= $fee; $i++) {
                $credit['fees'][] = [
                    'number' => $i,
                    'start_date' => $start_date->format('Y-m-d'),
                    'capital_fee' => number_format(($capital_fee), 2, '.', ','),
                    'interest_value' => number_format($interest_value, 2, '.', ','),
                    'fee_value' => number_format($value_fee, 2, '.', ','),
                    'capital_balance' => number_format(($total_credit -= $value_fee), 2, '.', ',')
                ];

                $total_capital += $capital_fee;
                $start_date = $start_date->addMonths(1);
            }
        }

        $credit['total_capital'] = number_format($total_capital, 2, '.', ',');


        return !$getFullData ? $total_credit : $credit;
    }
}
