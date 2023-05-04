<?php 
namespace classes\view;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class agenda{

    public function __construct(){
        $this->_DB          = NEW \classes\core\db;                                 
        $this->_CONFIG      = NEW \classes\core\config;                                         
        $this->_SESSION     = NEW \classes\core\session;
    }


    public function trashClient($date){
        $this->array = ["uuid" => "{$date}"];
        $this->query = "DELETE FROM `clients` WHERE `uuid` = :uuid ";
        return $this->_DB->action($this->query, $this->array);
    }

    public function updateClient($date = []){
        $this->query = "UPDATE `clients` SET `client` = :client WHERE `uuid` = :uuid"; 
        return $this->_DB->action($this->query, $date);
    }

    public function postClient($date = []){
        $this->query = "INSERT INTO `clients` (`uuid`, `client`) VALUES(:uuid, :client)";
        return $this->_DB->action($this->query, $date);
    }

    public function clientExist($client){
        $this->array = ["client" => "{$client}"];
        $this->query = "SELECT count('client') as `exist` FROM `clients` WHERE `client` = :client ";
        return $this->_DB->get($this->query, $this->array)->exist;
    }


    public function getClients(){
        $this->query = "SELECT * FROM `clients`";
        return $this->_DB->getAll($this->query);
    }

    public function thisAppointment($date = ""){
        $this->array =  ["dates" => "{$date}"];
        $this->query = "SELECT * 
                                FROM `agenda_dates` 
                                WHERE `agendaUuid` = :dates ";
        return $this->_DB->get($this->query, $this->array);
    }

    public function get($date = ""){
        $this->array =  ["dates" => "{$date}"];
        $this->query = "SELECT * 
                                FROM `agenda_dates` 
                                WHERE `date` = :dates ";
        return $this->_DB->getAll($this->query, $this->array);
    }

    public function datesExist($date){
        $this->query = "SELECT COUNT(`date`) as `exists` FROM `agenda_appointment` WHERE `date` = '{$date}' ";
        return $this->_DB->get($this->query)->exists;
    }

    public function getDateUuid($date){
        $this->query = "SELECT * FROM `agenda_appointment` WHERE `date` = '{$date}' ";
        return $this->_DB->get($this->query);
    }

    public function getDates(){
        $this->query = "SELECT * 
                            FROM `agenda_appointment` 
                            GROUP BY `date`
                            ORDER BY `date` ASC
                        ";
        return $this->_DB->getAll($this->query);
    }

    public function getAppointment($data = ""){
        $this->array = ["uuid" => "{$data}"];
        $this->query = "SELECT * FROM `agenda_dates` WHERE `dateUuid` = :uuid ";
        return $this->_DB->getAll($this->query, $this->array);
    }

    public function trash($data = ""){
        $this->array = ["uuid" => "{$data}"];
        $this->query = "DELETE FROM `agenda_dates` WHERE `agendaUuid` = :uuid ";
        return $this->_DB->action($this->query, $this->array);
    }

    public function datePost($data = []){
        $this->query = "INSERT INTO `agenda_appointment` 
                            (`uuid`, `date`) 
                            VALUES (:uuid, :date)";
        return $this->_DB->action($this->query, $data);
    }

    public function post($data = []){
        $this->query = "INSERT INTO `agenda_dates` 
                            (`agendaUuid`, `userUuid`, `dateUuid`, `time`, `message`, `subject`) 
                            VALUES (:agendaUuid, :userUuid, :dateUuid, :time, :message, :subject)";
        return $this->_DB->action($this->query, $data);
    }
}