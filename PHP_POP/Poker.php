<?php
$err = [
    'errCode' => 400,
    'errText' => 'unknown error',
];
if (empty($_SERVER['QUERY_STRING'])) {
    $err['errCode'] = 401;
    $err['errText'] = 'empty pokers';
    exitCode($err);
} else {
    $in = urldecode($_SERVER['QUERY_STRING']);
    $in = htmlspecialchars_decode($in);
}
$pokersArr = gameIn($in);
/*{
    // for debug
    $sum = getPokersSum($pokersArr);
    echo $sum;
    var_dump($pokersArr);
}*/
judge($pokersArr);
exitCode($err);

function gameIn($in)
{
    // change to upper case
    $in = strtoupper($in);
    // delete wrong characters
    $in = preg_replace('/[^\dJQKA]/', '', $in);
    // take the first 5
    $in = substr($in, 0, 5);
    // less than 5 is not right
    if (strlen($in) < 5) {
        $err['errCode'] = 402;
        $err['errText'] = 'not enough pokers';
        exitCode($err);
    }
    // change to array
    $in = str_split($in);
    // get count of each poker
    $pokersArr = [];
    foreach ($in as $item) {
        if (!array_key_exists($item, $pokersArr)) {
            $pokersArr[$item] = 1;
        } else {
            $pokersArr[$item]++;
        }
    }
    // change 1 to A
    if (array_key_exists(1, $pokersArr)) {
        if (array_key_exists('A', $pokersArr)) {
            $pokersArr['A'] += $pokersArr[1];
        } else {
            $pokersArr['A'] = $pokersArr[1];
        }
        unset($pokersArr[1]);
    }
    // change 0 to 10
    if (array_key_exists(0, $pokersArr)) {
        $pokersArr[10] = $pokersArr[0];
        unset($pokersArr[0]);
    }
    return $pokersArr;
}

function judge($pokersArr)
{
    judgeBigBonus($pokersArr);
    judgeOtherBonus($pokersArr);
}

function judgeBigBonus($pokersArr)
{
    $err['errCode'] = 0;
    $err['errText'] = '';
    // bomb
    $bomb = array_search(4, $pokersArr);
    if ($bomb) {
        $err['judgeText'] = [
            'type' => 'BOMB',
            'value' => $bomb,
        ];
        exitCode($err);
    }
    // get sum of pokers
    $sum = getPokersSum($pokersArr);
    // five bulls
    if ($sum == 50) {
        $err['judgeText'] = [
            'type' => 'FIVE BULLS',
        ];
        exitCode($err);
    }
    // five small bulls
    if ($sum == 10) {
        $err['judgeText'] = [
            'type' => 'FIVE SMALL BULLS',
        ];
        exitCode($err);
    }
}

function judgeOtherBonus($pokersArr)
{
    $sum = getPokersSum($pokersArr);
    $value = $sum % 10 == 0 ? 10 : $sum % 10;
    $arr2Calc = [];
    $arr2Show = [];
    $flag = 0;
    foreach ($pokersArr as $poker => $pokerCount) {
        while ($pokerCount > 0) {
            $pokerCount -= 1;
            $arr2Calc[$flag] = getPokerVal($poker);
            $arr2Show[$flag] = $poker;
            $flag++;
        }
    }
    if (judge10($arr2Calc, 0, 1, 2)) {
        showBull($arr2Show, $value, 0, 1, 2);
    } else if (judge10($arr2Calc, 0, 1, 3)) {
        showBull($arr2Show, $value, 0, 1, 3);
    } else if (judge10($arr2Calc, 0, 1, 4)) {
        showBull($arr2Show, $value, 0, 1, 4);
    } else if (judge10($arr2Calc, 0, 2, 3)) {
        showBull($arr2Show, $value, 0, 2, 3);
    } else if (judge10($arr2Calc, 0, 2, 4)) {
        showBull($arr2Show, $value, 0, 2, 4);
    } else if (judge10($arr2Calc, 0, 3, 4)) {
        showBull($arr2Show, $value, 0, 3, 4);
    } else if (judge10($arr2Calc, 1, 2, 3)) {
        showBull($arr2Show, $value, 1, 2, 3);
    } else if (judge10($arr2Calc, 1, 2, 4)) {
        showBull($arr2Show, $value, 1, 2, 4);
    } else if (judge10($arr2Calc, 1, 3, 4)) {
        showBull($arr2Show, $value, 1, 3, 4);
    } else if (judge10($arr2Calc, 2, 3, 4)) {
        showBull($arr2Show, $value, 2, 3, 4);
    } else {
        $err['errCode'] = 0;
        $err['errText'] = '';
        $err['judgeText'] = [
            'type' => 'LOSE',
        ];
        exitCode($err);
    }
}

function getPokersSum($pokersArr)
{
    $sum = 0;
    foreach ($pokersArr as $poker => $pokerCount) {
        $sum += $pokerCount * getPokerVal($poker);
    }
    return $sum;
}

function getPokerVal($poker)
{
    if ($poker == 'A') {
        return 1;
    } else if (in_array($poker, ['J', 'Q', 'K'])) {
        return 10;
    } else {
        return $poker;
    }
}

function judge10($arr2Calc, $a, $b, $c)
{
    return ($arr2Calc[$a] + $arr2Calc[$b] + $arr2Calc[$c]) % 10 == 0 ? true : false;
}

function showBull($arr2Show, $value, $a, $b, $c)
{
    $err['errCode'] = 0;
    $err['errText'] = '';
    $err['judgeText'] = [
        'type' => 'BULLS',
        'value' => $value,
    ];
    $flag_arr2toSum = 0;
    $flag_arr2toLeft = 0;
    $arr2toSum = [];
    $arr2toLeft = [];
    for ($i = 0; $i < 5; $i++) {
        if ($i == $a || $i == $b || $i == $c) {
            $arr2toSum[$flag_arr2toSum] = $arr2Show[$i];
            $flag_arr2toSum++;
            continue;
        } else {
            $arr2toLeft[$flag_arr2toLeft] = $arr2Show[$i];
            $flag_arr2toLeft++;
            continue;
        }
    }
    $err['judgeText']['toSum'] = $arr2toSum;
    $err['judgeText']['toLeft'] = $arr2toLeft;
    exitCode($err);
}

function exitCode($err)
{
    echo json_encode($err);
    exit();
}

?>