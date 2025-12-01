<?php
include 'src/input.php';
$level = new Input(3);

$input = $level->get_input();
$pattern = "/mul\((?P<num_1>\d{1,3}),(?P<num_2>\d{1,3})\)|(?<do>do\(\))|(?<dont>don\'t\(\))/";

preg_match_all($pattern, $input, $matches);

$total = 0;
$on = true;
for ($i=0; $i < count($matches["num_1"]); $i++) { 
    if($matches['do'][$i]){
        $on = true;
        continue;
    }
    if($matches['dont'][$i]){
        $on = false;
        continue;
    }
    if($on){
        $total += $matches["num_1"][$i] * $matches["num_2"][$i];
    }
}
echo $total;