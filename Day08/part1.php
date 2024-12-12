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
echo $map->map_nodes();

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

    public function map_nodes(){
        $result = 0;
        foreach($this->antenna as $identifier => $keys){
            $result += $this->add_locs($keys);
        }
        return $result;
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
            $nodea['y'] = $keys[0]['y'] + $diffy;
            $nodea['x'] = $keys[0]['x'] + $diffx;
            $nodeb['y'] = $keys[$key]['y'] - $diffy;
            $nodeb['x'] = $keys[$key]['x'] - $diffx;

            if(!($nodea['y'] < 0 || $nodea['y'] > $this->max_y) && !($nodea['x'] < 0 || $nodea['x'] > $this->max_x)){
                if($this->find_duplicate($nodea['y'], $nodea['x'])){
                    $this->duplicates[] = $nodea;
                    $count++;
                }
            }
            if(!($nodeb['y'] < 0 || $nodeb['y'] > $this->max_y) && !($nodeb['x'] < 0 || $nodeb['x'] > $this->max_x)){
                if($this->find_duplicate($nodeb['y'], $nodeb['x'])){
                    $this->duplicates[] = $nodeb;
                    $count++;
                }
            }
        }
        unset($keys[0]);
        $count += $this->add_locs(array_values($keys));
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