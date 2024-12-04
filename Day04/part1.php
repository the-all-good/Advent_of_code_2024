<?php
include 'src/input.php';
$level = new Input(4);

$input = $level->split_by_newlines();

$map = mapWordSearch($input);
$max_x = count($map[0]);
$max_y = count($map);

echo get_x($map) . "\n";

function get_x($map){
    $result = 0;
    foreach ($map as $y => $line){
        foreach ($line as $x => $letter){
            if ($letter === "X"){
                $result += checkWord($x, $y);
            }
        }
    }
    return $result;
}


function checkWord($x, $y){
    global $map, $max_x, $max_y;
    $counter = 0;
    ## Check Up
    if($y > 2){
        if ("{$map[$y][$x]}{$map[$y -1][$x]}{$map[$y -2][$x]}{$map[$y -3][$x]}" === "XMAS"){
            $counter++;
        }
    }
    ## Check Down
    if($y < $max_y - 3){
        if ("{$map[$y][$x]}{$map[$y +1][$x]}{$map[$y +2][$x]}{$map[$y +3][$x]}" === "XMAS"){
            $counter++;
        }
    }
    ## Check Right
    if($x < $max_x - 3){
        if ("{$map[$y][$x]}{$map[$y][$x +1]}{$map[$y][$x +2]}{$map[$y][$x +3]}" === "XMAS"){
            $counter++;
        }
    }
    ## Check Left   
    if($x > 2){
        if ("{$map[$y][$x]}{$map[$y][$x -1]}{$map[$y][$x -2]}{$map[$y][$x -3]}" === "XMAS"){
            $counter++;
        }
    }
    ## Check Up Left
    if($y > 2 && $x > 2){
        if ("{$map[$y][$x]}{$map[$y -1][$x -1]}{$map[$y -2][$x-2]}{$map[$y -3][$x-3]}" === "XMAS"){
            $counter++;
        }
    }
    ## Check Down Right
    if($y < $max_y - 3 && $x < $max_x -3){
        if ("{$map[$y][$x]}{$map[$y +1][$x+1]}{$map[$y +2][$x+2]}{$map[$y +3][$x+3]}" === "XMAS"){
            $counter++;
        }
    }
    ## Check Up Right
    if($y > 2 && $x < $max_x -3){
        if ("{$map[$y][$x]}{$map[$y-1][$x +1]}{$map[$y-2][$x +2]}{$map[$y-3][$x +3]}" === "XMAS"){
            $counter++;
        }
    }
    ## Check Down Left
    if($x > 2 &&  $y < $max_y - 3){
        if ("{$map[$y][$x]}{$map[$y+1][$x -1]}{$map[$y+2][$x -2]}{$map[$y+3][$x -3]}" === "XMAS"){
            $counter++;
        }
    }

    return $counter;
}

function mapWordSearch($input){
    foreach($input as $key => $value){
        $map[$key] = str_split($value);
    }
    return $map;
}