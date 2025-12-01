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
    echo $position;
    if (! isset($matches['dir'])) {
        var_dump($matches);
    }

    if ($matches['dir'] == "L") {
        if ($position == 0) {
            $count--;
        }
        $position -= (int) $matches['count'];
    }

    if ($matches['dir'] == "R") {
        if ($position == 100) {
            $count--;
        }
        $position += (int) $matches['count'];
    }

    while ($position > 100) {
        $position -= 100;
        $count++;
    }

    while ($position < 0) {
        $position += 100;
        $count++;
    }

    if ($position == 0 || $position == 100) {
        $count++;
    }

    echo " -- $position -- $matches[0] -- $count\n";
}

echo "$count \n";