<?php
include 'src/input.php';

$input = new Input("https://adventofcode.com/2024/day/1/input");
$input = $input->split_by_newlines();

/*
    Seperate the 2 lists into arrays
    Sort arrays
    Compare array diffs
*/
$list1 = [];
$list2 = [];
$total = 0;

foreach($input as $line){
    $nums = explode('   ',$line);
    $list1[] = $nums[0];
    $list2[] = $nums[1];
}

sort($list1, SORT_NUMERIC);
sort($list2, SORT_NUMERIC);

for($count = 0; $count < count($list1); $count++){
    $total += abs(intval($list1[$count]) - intval($list2[$count]));
}

echo $total . "\n";