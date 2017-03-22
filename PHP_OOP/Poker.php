<?php

class Poker
{
    var $pokersArr;
    var $countArr;
    var $sum;
    var $value;
    var $err;

    function __construct()
    {
        $this->pokersArr = [];
        $this->countArr = [];
        $this->sum = 0;
        $this->value = -1;
        $this->err = [
            'errCode' => 401,
            'errText' => 'empty pokers',
        ];
    }

    function gameStart($in)
    {
        if ($this->gameIn($in)) {
            $this->judge();
        }
        // for debug
        // echo $this->toJSON();
        // var_dump($this);
    }

    function gameIn($in)
    {
        if (empty($in)) {
            return false;
        } else {
            $in = urldecode($in);
            $in = htmlspecialchars_decode($in);
        }
        // change to upper case
        $in = strtoupper($in);
        // delete wrong characters
        $in = preg_replace('/[^\dJQKA]/', '', $in);
        // take the first 5
        $in = substr($in, 0, 5);
        // less than 5 is not right
        if (strlen($in) < 5) {
            $this->err['errCode'] = 402;
            $this->err['errText'] = 'not enough pokers';
            return false;
        }
        // change to array
        $in = str_split($in);
        // change 1 to A, change 0 to 10
        for ($i = 0; $i < sizeof($in); $i++) {
            if ($in[$i] == '1') {
                $in[$i] = 'A';
            } else if ($in[$i] == '0') {
                $in[$i] = '10';
            }
        }
        $this->pokersArr = $in;
        // get count of each poker
        foreach ($this->pokersArr as $item) {
            if (!array_key_exists($item, $this->countArr)) {
                $this->countArr[$item] = 1;
            } else {
                $this->countArr[$item]++;
            }
        }
        // get sum of pokers
        $this->getPokersSum();
        return true;
    }

    function judge()
    {
        $this->err['errCode'] = 0;
        $this->err['errText'] = '';
        if (empty($this->pokersArr)) {
            return;
        }
        if ($this->judgeBigBonus() == false) {
            if ($this->judgeOtherBonus() == false) {
                $this->err['judgeText'] = [
                    'type' => 'LOSE',
                ];
            }
        }

    }

    function judgeBigBonus()
    {
        // bomb
        $bomb = array_search(4, $this->countArr);
        if ($bomb) {
            $this->err['judgeText'] = [
                'type' => 'BOMB',
                'value' => $bomb,
            ];
            $this->value = $bomb;
            return true;
        }
        // five bulls
        if ($this->sum == 50) {
            $this->err['judgeText'] = [
                'type' => 'FIVE BULLS',
            ];
            return true;
        }
        // five small bulls
        if ($this->sum == 10) {
            $this->err['judgeText'] = [
                'type' => 'FIVE SMALL BULLS',
            ];
            return true;
        }
    }

    function judgeOtherBonus()
    {
        $this->value = $this->sum % 10 == 0 ? 10 : $this->sum % 10;
        if ($this->judge10(0, 1, 2)) {
            $this->showBull(0, 1, 2);
        } else if ($this->judge10(0, 1, 3)) {
            $this->showBull(0, 1, 3);
        } else if ($this->judge10(0, 1, 4)) {
            $this->showBull(0, 1, 4);
        } else if ($this->judge10(0, 2, 3)) {
            $this->showBull(0, 2, 3);
        } else if ($this->judge10(0, 2, 4)) {
            $this->showBull(0, 2, 4);
        } else if ($this->judge10(0, 3, 4)) {
            $this->showBull(0, 3, 4);
        } else if ($this->judge10(1, 2, 3)) {
            $this->showBull(1, 2, 3);
        } else if ($this->judge10(1, 2, 4)) {
            $this->showBull(1, 2, 4);
        } else if ($this->judge10(1, 3, 4)) {
            $this->showBull(1, 3, 4);
        } else if ($this->judge10(2, 3, 4)) {
            $this->showBull(2, 3, 4);
        } else {
            return false;
        }
        return true;
    }

    function getPokersSum()
    {
        $sum = 0;
        foreach ($this->countArr as $poker => $pokerCount) {
            $sum += $pokerCount * $this->getPokerVal($poker);
        }
        $this->sum = $sum;
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

    function judge10($a, $b, $c)
    {
        return ($this->getPokerVal($this->pokersArr[$a]) + $this->getPokerVal($this->pokersArr[$b]) + $this->getPokerVal($this->pokersArr[$c])) % 10 == 0;
    }

    function showBull($a, $b, $c)
    {
        $this->err['judgeText'] = [
            'type' => 'BULLS',
            'value' => $this->value,
        ];
        $flag_arr2toSum = 0;
        $flag_arr2toLeft = 0;
        $arr2toSum = [];
        $arr2toLeft = [];
        for ($i = 0; $i < 5; $i++) {
            if ($i == $a || $i == $b || $i == $c) {
                $arr2toSum[$flag_arr2toSum] = $this->pokersArr[$i];
                $flag_arr2toSum++;
                continue;
            } else {
                $arr2toLeft[$flag_arr2toLeft] = $this->pokersArr[$i];
                $flag_arr2toLeft++;
                continue;
            }
        }
        $this->err['judgeText']['toSum'] = $arr2toSum;
        $this->err['judgeText']['toLeft'] = $arr2toLeft;
    }

    function toJSON()
    {
        return json_encode($this->err);
    }
}

?>