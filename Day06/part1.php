<?php
include 'src/input.php';
$level = new Input(6);
$input = $level->get_input();


$directions = [
    "up" => ["y" => -1,"x" => 0, 'next'=> "right"],
    "right" => ["y" => 0,"x" => 1, 'next'=> "down"],
    "down" => ["y" => 1,"x" => 0, 'next'=> "left"],
    "left" => ["y" => 0,"x" => -1, 'next'=> "up"],
];
$direction = "up";
$map = create_map($input);
$max_y = count($map);
$max_x = count($map[0]);

$play = play_game($map);
echo count_x($play) . "\n";

function show_game($map){
    foreach ($map as $key => $line) {
        foreach ($line as $value) {
            echo $value;
        }
        echo "\n";
    }
}

function play_game($map){
    $check = check_player($map);
    while($check){
        $player = get_player($map);
        $map = take_step($player['y'], $player['x'], $map);
        $check = check_player($map);
    }
    return $map;
}

function count_x($map){
    $count = 0;
    foreach ($map as $y => $line){
        foreach($line as $x=> $value){
            if ($value === "X"){
                $count++;
            }
        }
    }
    return $count;
}

function take_step(int $y, int $x,array $map){
    global $directions, $direction, $max_x, $max_y;
    $dir = $directions[$direction];

    if($y + $dir['y'] > $max_y -1 || $x + $dir['x'] > $max_x -1){
        $map[$y][$x] = "X";
        return $map;
    }

    if($map[$y + $dir['y']][$x + $dir['x']] === "#"){
        $direction = $dir['next'];
        return take_step($y, $x, $map);
    }

    $map[$y][$x] = "X";
    if($y + $dir['y'] < $max_y && $x + $dir['x'] < $max_x){
        $map[$y + $dir['y']][$x + $dir['x']] = "^";
    }
    return $map;
}

function check_player($map){
    foreach ($map as $y => $line) {
        if(in_array("^", $line)){
            return true;
        }
    }
    return false;
}

function get_player($map){
    foreach ($map as $y => $line){
        foreach($line as $x=> $value){
            if ($value === "^"){
                return ['y'=>$y, 'x'=>$x];
            }
        }
    }
}

function create_map($input){
    foreach(explode("\n", $input) as $line){
        if($line !== ""){
            $map[] = str_split($line);
        }
    }
    return $map;
}