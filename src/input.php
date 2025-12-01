<?php

class Input{
    public $output;
    public $url = "https://adventofcode.com/2024/day/";
    public $day;
    private $cookie;
    
    function __construct($day){
        $this->day = $day;
        $this->cookie = "session=" . parse_ini_file('.env')['SESSION'];
        $ch = curl_init("{$this->url}{$this->day}/input");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $this->output = $output;
    }

    public function get_input(){
        return $this->output;
    }

    public function split_by_newlines(){
        $split = explode("\n", $this->get_input());
        foreach($split as $key => $line){
            if($line === ""){
                unset($split[$key]);
            }
        }
        return $split;
    }

    public function submit_answer($part, $answer){
        $ch = curl_init("{$this->url}{$this->day}/answer");
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            http_build_query(['level' => $part, 'answer' => $answer]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}