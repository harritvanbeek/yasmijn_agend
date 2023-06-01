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

    /*delete days or appontments */
    public function removeDays($array = []){
        return self::_removeDays($array);
    }


    protected function _removeDays($array = []){
        if(!empty($array["check"])){
            $this->query[] = "DELETE FROM `agenda_appointment` WHERE `uuid` = '{$array['uuid']}' ";
            $this->query[] = "DELETE FROM `agenda_dates` WHERE `dateUuid` = '{$array['uuid']}' ";
        }else{
            $this->query[] = "DELETE FROM `agenda_appointment` WHERE `uuid` = '{$array['uuid']}' ";
        } 

        foreach($this->query as $query){                
            $this->return = $this->_DB->action($query);
        }
        return $this->return;
    }

    /* reports */
    public function thisUpdate($data = ""){
        $this->query = "UPDATE `agenda_reports`
                            SET 
                                `clientUuid` = '{$data['clientUuid']}',
                                `title`   = '{$data['title']}',
                                `message` = '{$data['message']}',
                                `post_updated` = now()
                            WHERE `uuid` = '{$data['uuid']}'
                       ";
        return $this->_DB->action($this->query); 
    }

    public function thisReports($data = ""){
        $this->array = ["uuid" => "{$data}"];


        $this->select = "
                        `agenda_reports`.`uuid`,
                        `agenda_reports`.`clientUuid`,
                        `agenda_reports`.`title`,
                        `agenda_reports`.`message`,
                        `agenda_reports`.`post_date`,
                        `agenda_reports`.`post_updated`,
                        `clients`.`client`
                        ";

        $this->query = "SELECT {$this->select} 
                        FROM `agenda_reports`
                        LEFT JOIN `clients`
                            ON `clients`.`uuid` = `agenda_reports`.`clientUuid`
                        WHERE `agenda_reports`.`uuid` = :uuid ";
        return $this->_DB->get($this->query, $this->array); 
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
        $this->query = "INSERT INTO `agenda_reports` (`uuid`, `clientUuid`, `title`, `message`, `post_date`) VALUES(:uuid, :clientUuid, :title, :message, now())";
        return $this->_DB->action($this->query, $data);        
    }
}