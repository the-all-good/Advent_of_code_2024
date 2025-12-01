<?php
include 'src/input.php';
$level = new Input(7);
$input = $level->get_input();
// $input = "190: 10 19
// 3267: 81 40 27
// 83: 17 5
// 156: 15 6
// 7290: 6 8 6 15
// 161011: 16 10 13
// 192: 17 8 14
// 21037: 9 7 18 13
// 292: 11 6 16 20";

$pattern = "/(?P<result>\d+): (?P<nums>([\d+ ])+)/";
preg_match_all($pattern, $input, $matches);

$results = $matches['result'];
$num_groups = array_map(function ($num){
    return explode(" ", $num);
}, $matches['nums']);

$count = 0;

foreach($results as $key => $result){
    if(attempt($num_groups[$key], $result)){
        $count += $result;
        $test = implode(", ", $num_groups[$key]);
    }
}
echo $count;

function attempt(array $group, int $result){
    $add = add($group[0], $group[1]);
    $multi = multiply($group[0], $group[1]);
    $concat = concat($group[0], $group[1]);
    $addGroup = $group;
    $multiGroup = $group;
    $concatGroup = $group;
    unset($addGroup[0]);
    unset($multiGroup[0]);
    unset($concatGroup[0]);
    $addGroup[1] = $add;
    $multiGroup[1] = $multi;
    $concatGroup[1] = $concat;

    if($add > $result){
        unset($addGroup);
    }
    if($multi > $result){
        unset($multiGroup);
    }
    if($concat > $result){
        unset($concatGroup);
    }

    if(count($group) > 2){
        if(isset($addGroup)){
            if(attempt(array_values($addGroup), $result)){
                return true;
            }
        }
        if(isset($multiGroup)){
            if(attempt(array_values($multiGroup),$result)){
                return true;
            };
        }
        if(isset($concatGroup)){
            if(attempt(array_values($concatGroup),$result)){
                return true;
            };
        }
    }

    if($add === $result && isset($addGroup) && count($addGroup) < 2){
        return true;
    }
    if($multi === $result && isset($multiGroup) && count($multiGroup) < 2){
        return true;
    }
    if($concat === $result && isset($concatGroup) && count($concatGroup) < 2){
        return true;
    }
    return false;
}

function calculate($num1, $num2){
    $add = add($num1, $num2);
    $multi = multiply($num1, $num2);
    return [$add, $multi];
}

function add($num1, $num2){
    return $num1 + $num2;
}

function multiply($num1, $num2){
    return $num1 * $num2;
}

function concat($num1, $num2){
    return intval("{$num1}{$num2}");
}