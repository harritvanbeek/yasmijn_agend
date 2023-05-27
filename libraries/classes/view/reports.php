<?php 
namespace classes\view;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class reports{
    private     $_DB            =   NULL,
                $_CONFIG        =   NULL,
                $_SESSION       =   NULL;

    public function __construct(){
        $this->_DB          = NEW \classes\core\db;                                 
        $this->_CONFIG      = NEW \classes\core\config;                                         
        $this->_SESSION     = NEW \classes\core\session;
    }

    public function trash($data = ""){
        $this->array = ["uuid" => "{$data}"];
        $this->query = "DELETE FROM `agenda_reports` WHERE `uuid` = :uuid";
        return $this->_DB->action($this->query, $this->array);
    }

    public function get(){
        $this->query = "SELECT * FROM `agenda_reports`";
        return $this->_DB->getAll($this->query);
    }

    public function add($data = []){
        $this->query = "INSERT INTO `agenda_reports` (`uuid`, `title`, `message`, `post_date`) VALUES(:uuid, :title, :message, now())";
        return $this->_DB->action($this->query, $data);        
    }
}