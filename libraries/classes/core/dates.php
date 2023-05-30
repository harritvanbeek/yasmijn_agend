<?php 
namespace classes\core;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class dates {
    
    public function translateDays(){
        $this->array = [
            "Tuesday" => "Dinsdag",
            "Wensday" => "Woensdag",
        ];

        return $this->array;
    }

    public function translateMonth(){
        
    }


}