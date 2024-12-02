<?php
include 'src/input.php';

$level = new Input(2);
$total = 0;

$input = $level->split_by_newlines();
// $input = ['7 6 4 2 1',
// '1 2 7 8 9',
// '9 7 6 2 1',
// '1 3 2 4 5',
// '8 6 4 4 1',
// '1 3 6 7 9'];

foreach ($input as $line) {
    $check = check_safe(explode(" ",$line));
    if($check){
        $total += 1;
    }
}
echo $total . "\n";

function check_safe(array $nums){
    $direction = "";
    $faults = 0;
    $test = $nums;
    for ($i=1; $i < count($nums); $i++) { 

        if ($faults > 1){
            print_r($test);
            print_r($nums);
            return false;
        }

        $diff = $nums[$i -1] - $nums[$i];
        
        if ($direction == "") {
            $direction = $diff == abs($diff) ? "down" : "up";
        }
        
        if ($diff == 0 || abs($diff) > 3){
            echo $nums[$i - 1] . "\n";
            unset($nums[$i -1]);
            $faults += 1;
            $direction = "";
            $nums = array_values($nums);
            $i = 0;
            continue;
        }
        
        if (($diff == abs($diff) && $direction == "up") || ($diff != abs($diff) && $direction == "down")){
            echo $nums[$i - 1] . " {$direction}  {$diff} {$nums[$i]}" .  "\n";
            unset($nums[$i -1]);
            $faults += 1;
            $direction = "";
            $nums = array_values($nums);
            $i = 0;
            continue;
        }
    }

    return $nums;
}