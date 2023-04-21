<?php 
namespace classes\view;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class login{

    private $_DB        =   NULL,
            $_SESSION   =   NULL;
    
    public function __construct(){
        $this->_DB          = NEW \classes\core\db; 
        $this->_SESSION     = NEW \classes\core\session;    
    }

    public function uuidExist(){
        $this->uuid     = $this->_SESSION->get('userUuid')->uuid;
        $this->array    =   ["uuid" => "{$this->uuid}"];
        $this->query    =   "SELECT count(`uuid`) as `exist` FROM `users` WHERE `uuid` = :uuid"; 
        $this->data     =   $this->_DB->get($this->query, $this->array);  
        return $this->data->exist;             
    }

    public function getUuid(){
        $this->array    =   ["user" => "{$GLOBALS["username"]}"];
        $this->query    =   "SELECT `uuid` FROM `users` WHERE `username` = :user"; 
        $this->data     =   $this->_DB->get($this->query, $this->array);  
        return $this->data;            
    }
}