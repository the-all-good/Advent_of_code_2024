<?php
include 'src/input.php';

$level = new Input(2);
$total = 0;

$input = $level->split_by_newlines();

foreach ($input as $line) {
    $check = check_safe(explode(" ",$line));
    if($check){
        $total += 1;
    }
}
echo $total . "\n";

function check_safe(array $nums){
    $direction = "";
    for ($i=1; $i < count($nums); $i++) { 
        $diff = $nums[$i -1] - $nums[$i];
        
        if ($direction == "") {
            $direction = $diff == abs($diff) ? "up" : "down";
        }
        
        if ($diff == 0 || abs($diff) > 3){
            return false;
        }
        
        if (($diff == abs($diff) && $direction == "down") || ($diff != abs($diff) && $direction == "up")){
            return false;
        }
    }
    return true;
}