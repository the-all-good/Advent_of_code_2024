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
            if ($letter === "A"){
                $result += checkWord($x, $y);
            }
        }
    }
    return $result;
}


function checkWord($x, $y){
    global $map, $max_x, $max_y;
    $counter = 0;
    ## Check
    if($x > 0 && $y > 0 && $y < $max_y -1 && $x < $max_x -1){
        #both forward
        if (("{$map[$y-1][$x-1]}{$map[$y][$x]}{$map[$y+1][$x+1]}" === "MAS" || "{$map[$y-1][$x-1]}{$map[$y][$x]}{$map[$y+1][$x+1]}" === "SAM") && ("{$map[$y+1][$x-1]}{$map[$y][$x]}{$map[$y-1][$x+1]}" === "MAS" || "{$map[$y+1][$x-1]}{$map[$y][$x]}{$map[$y-1][$x+1]}" === "SAM")){
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