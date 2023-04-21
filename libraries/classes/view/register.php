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

    public function passwordExist(){
        $this->array    =   ["user" => "{$GLOBALS["username"]}"];
        $this->query    =   "SELECT `password` FROM `users` WHERE `username` = :user"; 
        $this->password =   $this->_DB->get($this->query, $this->array)->password;       
        if (!password_verify($GLOBALS["password"], $this->password)) {
           return false;
        }           
    }

    public function usernameExist(){
        $this->array =  ["user" => "{$GLOBALS["username"]}"];
        $this->query = "SELECT COUNT('username') as 'exist' FROM `users` WHERE `username` = :user ";
        return $this->_DB->get($this->query, $this->array)->exist;        
    }
}