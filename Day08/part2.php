<?php
include 'src/input.php';
$level = new Input(8);
$input = $level->get_input();
// $input = "............
// ........0...
// .....0......
// .......0....
// ....0.......
// ......A.....
// ............
// ............
// ........A...
// .........A..
// ............
// ............";

$map = new Map($input);
echo $map->map_nodes() . "\n";
$map->show_game();

class Map{
    public $map;
    public $antenna;
    public $max_y;
    public $max_x;
    public $duplicates;


    public function __construct($string){
        $this->map = $this->create_map($string);
        $this->antenna = $this->map_antenna($this->map);
        $this->max_x = count($this->map[0]);
        $this->max_y = count($this->map);
    }

    public function show_game(){
        foreach ($this->map as $key => $line) {
            foreach ($line as $value) {
                echo $value;
            }
            echo "\n";
        }
    }

    public function count_nodes(){
        $count = 0;
        foreach($this->map as $y => $line){
            foreach($line as $x => $char){
                if($char === '.'){
                    continue;
                }
                $count++;
            }
        }
        return $count;
    }

    public function map_nodes(){
        foreach($this->antenna as $identifier => $keys){
            $this->add_locs($keys);
        }
        return $this->count_nodes();
    }

    public function add_locs($keys){
        $count = 0;
        if(count($keys) < 2){
            return $count;
        }

        foreach($keys as $key => $locations){
            if($key === 0){
                continue;
            }
            [$diffy, $diffx] = $this->diff_antenna($keys[0], $keys[$key]);
            $count += $this->create_nodes($keys[0], ['y' => $diffy, 'x' => $diffx]);
            $count += $this->create_nodes($keys[$key], ['y' => $diffy, 'x' => $diffx], false);
        }
        unset($keys[0]);
        $count += $this->add_locs(array_values($keys));
        return $count;
    }

    public function inbounds($node){
        if(!($node['y'] < 0 || $node['y'] > $this->max_y - 2) && !($node['x'] < 0 || $node['x'] > $this->max_x -1)){
            $this->duplicates = $node;
            $this->map[$node['y']][$node['x']] = "#";

            return true;
        }
        return false;
    }

    public function create_nodes(array $start, array $diff, bool $increment = true){

        $count = 0;
        if($increment){
            $node['x'] = $start['x'] + $diff['x'];
            $node['y'] = $start['y'] + $diff['y'];
        }else{
            $node['x'] = $start['x'] - $diff['x'];
            $node['y'] = $start['y'] - $diff['y'];
        }
        while($this->inbounds($node)){
            $count++;
            if($increment){
                $node['x'] += $diff['x'];
                $node['y'] += $diff['y'];
            }else{
                $node['x'] -= $diff['x'];
                $node['y'] -= $diff['y'];
            }
        }
        return $count;
    }

    public function find_duplicate($y, $x){
        $clone = $this->duplicates;
        if(isset($clone) && count($clone) > 0){
            $duplicate = array_filter($clone, function($dup) use ($y, $x){
                if($dup['y'] === $y && $dup['x'] === $x){
                    return $dup;
                }
            });
            if($duplicate){
                return false;
            }
        }

        return true;
    }

    public function diff_antenna(array $antenna1, array $antenna2){
        [$y, $x] = [$antenna1['y'] - $antenna2['y'], $antenna1['x'] - $antenna2['x']];
        return [$y, $x];
    }
    
    public function create_map(string $input){
        foreach(explode("\n", $input) as $y => $line){
            $map[$y] = str_split($line);
        }
        return $map;
    }
    
    public function map_antenna(array $map){
        foreach($map as $y => $line){
            foreach($line as $x => $letter){
                if($letter == "."){
                    continue;
                }
                $antenna[$letter][] = ['y' => $y, 'x' => $x];
            }
        }
        return $antenna;
    }
}