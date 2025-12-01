<?php
include 'src/input.php';
$level = new Input(9);
$input = $level->get_input();

// $input = "2333133121414131402";

$disk = map_disk($input);
$allocate = reallocate_disk($disk);
$map = remap_disk($allocate);
echo check_sum($map) . "\n";


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

function remap_disk(array $disk){
    $result = [];
    foreach($disk as $key => $value){
        if($value === "."){
            $result[] = ".";
            continue;
        }
        for ($i=0; $i < intval($value['count']); $i++) { 
            $result[] = $value['num'];
        }
    }
    return $result;
}

function map_disk(string $line){
    $characters = str_split($line);
    $result = [];
    foreach ($characters as $key => $char) {
        $letters = "";
        if($key % 2 == 0){
            $letter = $key / 2;
        }else{
            $letter = ".";
        }
        if($letter === "."){
            for($i = $char; $i > 0; $i--){
                $result[] = $letter;
            }
        }else{
            $result[] = ['num' => $key /2, 'count' => $char];
        }
    }
    return $result;
}

function reallocate_disk(array $characters){
    $reverse = array_reverse($characters, true);
    foreach($reverse as $i => $value){
        if($characters[$i] === "."){
            continue;
        }
        $dot_start= find_spot($characters[$i]['count'], $characters);
        if(!$dot_start){
            continue;
        }

        $characters = replace_char($characters[$i], $dot_start, $i, $characters);
    }
    return $characters;
}

function replace_char(array $map, int $start, int $end, array $characters){
    if($start > $end){
        return $characters;
    }
    $characters[$start] = $characters[$end];
    $characters[$end] = ".";

    for($i = $map['count'] -1; $i > 0; $i--){
        array_splice($characters, $end, 0, ".");
        unset($characters[$start + $i]);
        $characters = array_values($characters);
    }
    return $characters;
}

function find_spot($char, $characters){
    $length = intval($char);
    $count = 0;
    foreach($characters as $key => $letter){
        if($count === 0 && $letter === "."){
            $start = $key;
        }
        if($letter === "."){
            $count++;
        }else{
            $count = 0;
        }
        if($count === $length){
            return $start;
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