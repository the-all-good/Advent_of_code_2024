<?php
include 'src/input.php';

$input = new Input(1);
$lines = $input->split_by_newlines();
// $input = "L68
// L30
// R48
// L5
// R60
// L55
// L1
// L99
// R14
// L82";
// $lines = explode("\n", $input);
$position = (int) 50;
$count = 0;

foreach ($lines as $line) {
    preg_match("/(?<dir>[L,R])(?<count>\d{1,4})/", $line, $matches);

    if (! isset($matches['dir'])) {
        var_dump($matches);
    }

    if ($matches['dir'] == "L") {
        $position -= (int) $matches['count'];
    }

    if ($matches['dir'] == "R") {
        $position += (int) $matches['count'];
    }

    if ($position > 100) {
        $position %= 100;
    }

    if ($position < 0) {
        $position %= -100;
    }

    if ($position == 0 || $position == 100) {
        $count++;
    }
}


echo "$count \n";