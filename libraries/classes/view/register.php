<?php 
namespace classes\view;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class register{
    private     $_DB            =   NULL,
                $_CONFIG        =   NULL,
                $_SESSION       =   NULL;

    public function __construct(){
        $this->_DB          = NEW \classes\core\db;                                 
        $this->_CONFIG      = NEW \classes\core\config;                                         
        $this->_SESSION     = NEW \classes\core\session;
    }

    public function passwordExist($username = ""){
        $this->username     =   !empty($username) ? $username : $GLOBALS["username"];
        $this->stePassword  =   !empty($GLOBALS["oldPassword"]) ? $GLOBALS["oldPassword"] : $GLOBALS["password"];
        
        $this->array    =   ["user" => "{$this->username}"];
        $this->query    =   "SELECT `password` FROM `users` WHERE `username` = :user"; 
        $this->password =   $this->_DB->get($this->query, $this->array)->password;       
        if (!password_verify($this->stePassword, $this->password)) {
           return false;
        }           
    }
    

    public function usernameExist(){
        $this->array =  ["user" => "{$GLOBALS["username"]}"];
        $this->query = "SELECT COUNT('username') as 'exist' FROM `users` WHERE `username` = :user ";
        return $this->_DB->get($this->query, $this->array)->exist;        
    }

    public function userExist($newUsername){
        $this->array = ["user" => "{$newUsername}"];
        $this->query = "SELECT count('username') as `exist` FROM `users` WHERE `username` = :user ";
        return $this->_DB->get($this->query, $this->array)->exist;
    }
}