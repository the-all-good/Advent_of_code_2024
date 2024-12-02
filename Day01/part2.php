<?php
include 'src/input.php';

$input = new Input("1");
$submit = $input;
$input = $input->split_by_newlines();

/*
    Seperate the 2 lists into arrays
    Sort arrays
    Create second list number count
    Create score function
    Compare array diffs
*/
$list1 = [];
$list2 = [];
$powerList = [];
$total = 0;

foreach($input as $line){
    $nums = explode('   ',$line);
    $list1[] = $nums[0];
    $list2[] = $nums[1];
}

sort($list1, SORT_NUMERIC);
sort($list2, SORT_NUMERIC);

foreach($list2 as $number){
    if(array_key_exists($number, $powerList)){
        $powerList[$number] += 1;
    }else{
        $powerList[$number] = 1;
    }
}

for($count = 0; $count < count($list1); $count++){
    $total += abs(intval($list1[$count]) * (array_key_exists($list1[$count], $powerList) ? $powerList[$list1[$count]] : 0));
}

echo $submit->submit_answer(1, $total);