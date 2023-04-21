<?php 
namespace classes\core;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class db{

    private $_CONFIG    =   NULL,
            $_PDO       =   NULL,
            $_query     =   NULL,
            $_results   =   NULL,
            $_ERRORS    =   FALSE,
            $_HOST      =   NULL,
            $_DBNAME    =   NULL,
            $_USERNAME  =   NULL,
            $_PASSWORD  =   NULL;

    
    public function __construct(){      
        $this->CONFIG   =   NEW \classes\core\config;
        try {
            $this->_HOST        =   !empty($this->CONFIG->get("mysql/host"))        ? $this->CONFIG->get("mysql/host")      : null;
            $this->_DBNAME      =   !empty($this->CONFIG->get("mysql/dbName"))      ? $this->CONFIG->get("mysql/dbName")    : null;
            $this->_USERNAME    =   !empty($this->CONFIG->get("mysql/username"))    ? $this->CONFIG->get("mysql/username")  : null;
            $this->_PASSWORD    =   !empty($this->CONFIG->get("mysql/password"))    ? $this->CONFIG->get("mysql/password")  : null;
            
            $this->_PDO = NEW \PDO("mysql:host={$this->_HOST};dbname={$this->_DBNAME}", "{$this->_USERNAME}", "{$this->_PASSWORD}");
            $this->_PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            $array  =   [
                "errorMessinger"    => "{$e->getMessage()}",
                "LineNumber"        =>  "{$e->getLine()}",
                "File"              =>  "{$e->getFile()}",
            ];

            $this->file = DIRNAME(DIRNAME(DIRNAME(__FILE__))).DS."logfiles".DS."database.log";
            if( file_exists($this->file) ){
                unlink($this->file);
            }

            $data = "\n\n########## ".date("d.m.Y H:i:s")." ##########\n";  
            $zeile = var_export($array,TRUE);
            $logfile = $this->file;
            $handle = fopen($logfile,"a+");
            $logzeile = $data.$zeile."\n\n";
            fputs($handle,$logzeile);
            fclose($handle);

            die("sorry whe have a database problem, try later again!");
        }
    }

    public function get($data = null, $array = []){
        try{
            if(!empty($array)){
                $this->_query = $this->_PDO->prepare($data);
                $this->_query->execute($array);
                $this->_results = $this->_query->fetch(\PDO::FETCH_OBJ);
            }else{
                $this->_query = $this->_PDO->prepare($data);
                $this->_query->execute();
                $this->_results = $this->_query->fetch(\PDO::FETCH_OBJ);                
            }

            return $this->_results;
        }catch(\PDOException $e){
            die($e->getMessage());
        }       
    }

    public function getAll($data = null, $array = []){
        try{
            if(!empty($array)){
                $this->_query = $this->_PDO->prepare($data);    
                $this->_query->execute($array);         
                $this->_results = $this->_query->fetchAll(\PDO::FETCH_OBJ); 
            }else{
                $this->_query = $this->_PDO->prepare($data);    
                $this->_query->execute();           
                $this->_results = $this->_query->fetchAll(\PDO::FETCH_OBJ);             
            }

            return $this->_results;
        }catch(\PDOException $e){
            die($e->getMessage());
        }
    }
    
    public function action($data = null, $array = []){
        try{
            if(!empty($array)){
                if($this->_PDO->prepare($data)->execute($array)){
                    return true;                
                }
            }else{
                if($this->_PDO->prepare($data)->execute()){
                    return true;                
                }
            }
        }catch(\PDOException $e){
            die($e->getMessage());
        }
    }

}