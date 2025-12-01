<?php
include 'src/input.php';
$level = new Input(5);

$input = $level->get_input();

$rulesPattern = "/(?P<num1>\d+)\|(?P<num2>\d+)/";
$inputPattern = "/(\d+,)+\d+/";

preg_match_all($rulesPattern, $input, $rules);
preg_match_all($inputPattern, $input, $cases);

$total = 0;
foreach($cases[0] as $case){
    $nums = explode(',', $case);
    $attempt = validCase($nums);
    if($attempt){
        $total += $attempt;
    }
}
echo $total . "\n";

function validCase(array $case){

    $firstTry = false;

    for ($i=0; $i < count($case) -1; $i++) { 
        if(checkRule($case[$i], $case[$i+1])){
            continue;
        }else{
            $firstTry = true;
            [$case[$i],$case[$i+1]] = [$case[$i+1],$case[$i]];
        }
    }
    if ($firstTry) {
        $confirm = validCase($case);
        if(!$confirm){
            return $case[(count($case) -1) /2];
        }else{
            return $confirm;
        }
    }
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