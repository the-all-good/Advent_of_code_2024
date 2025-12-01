<?php
include 'src/input.php';
$level = new Input(9);
$input = $level->get_input();

// $input = "2333133121414131402";

$disk = map_disk($input);
$allocated = reallocate_disk($disk);

echo check_sum($allocated);


function check_sum(array $characters){
    $result = 0;
    foreach($characters as $key => $char){
        if($char === "."){
            continue;
        }
        $result += $key * intval($char);
    }
    return $result;
}

function map_disk(string $line){
    $characters = str_split($line);
    $result = [];
    foreach ($characters as $key => $char) {
        if($key % 2 == 0){
            $letter = $key / 2;
        }else{
            $letter = ".";
        }
        for($i = $char; $i > 0; $i--){
            $result[] = $letter;
        }
    }
    return $result;
}

function reallocate_disk(array $characters){
    foreach($characters as $key => $char){
        $check = check_order($characters);
        if($check){
            return $characters;
        }
        if($char === "."){
            $change = get_last($characters);
            $characters[$key] = $characters[$change];
            $characters[$change] = ".";
        }
    }
    return $characters;
}

function get_last(array $characters){
    for($i = count($characters) -1; $i > 0; $i--){
        if($characters[$i] !== "."){
            return $i;
        }
    }
}

function check_order(array $characters){
    $check = false;

    for($i = count($characters) -1; $i > 0; $i--){
        if($characters[$i] !== "."){
            $check = true;
        }
        if($characters[$i] === "." && $check){
            return false;
        }
    }
    return true;
}