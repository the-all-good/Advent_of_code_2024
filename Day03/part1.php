<?php
include 'src/input.php';

$level = new Input(3);

$input = $level->get_input();
$pattern = "/mul\((?P<num_1>\d{1,3}),(?P<num_2>\d{1,3})\)/";

preg_match_all($pattern, $input, $matches);
$total = 0;
for ($i=0; $i < count($matches["num_1"]); $i++) { 
    $total += $matches["num_1"][$i] * $matches["num_2"][$i];
}

echo $total;