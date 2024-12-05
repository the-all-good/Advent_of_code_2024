<?php
include 'src/input.php';
$level = new Input(5);
$input = $level->get_input();

/*
    Get rules
    Get inputs
    Iterate over each input and check if the rule is valid
    Fail if invalid, continue if valid
    Return middle numer if valid
*/

$rulesPattern = "/(?P<num1>\d+)\|(?P<num2>\d+)/";
$inputPattern = "/(\d+,)+\d+/";

preg_match_all($rulesPattern, $input, $rules);
preg_match_all($inputPattern, $input, $cases);

$total = 0;
foreach($cases[0] as $case){
    $nums = explode(',', $case);
    if(validCase($nums)){
        $total += $nums[(count($nums) -1) /2];
    }
}
echo $total . "\n";

function validCase(array $case){

    for ($i=0; $i < count($case) -1; $i++) { 
        if(!checkRule($case[$i], $case[$i+1])){
            return false;
        }
    }
    return true;
}

function checkRule($num1, $num2){
    global $rules;

    for ($x=0; $x < count($rules[0]) -1; $x++) { 
        if($rules['num1'][$x] === $num1 && $rules['num2'][$x] === $num2){
            return true;
        }
        if($rules['num2'][$x] === $num1 && $rules['num1'][$x] === $num2){
            return false;
        }
    }
}