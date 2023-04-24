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

    public function getUsername($uuid = ""){
        $this->array =  ["uuid" => "{$uuid}"];
        $this->query = "SELECT `username` FROM `users` WHERE `uuid` = :uuid ";
        return $this->_DB->get($this->query, $this->array)->username;        
    }

    public function updatePassword($array = []){
        $this->query    =   "UPDATE `users` SET `password` = :password WHERE `uuid` = :uuid ";
        $this->return   =   $this->_DB->action($this->query, $array);
        return $this->return;
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