<?php 
    
    define('_BOANN', 1);
    require_once dirname(dirname(dirname(__file__))).'/libraries/import.php';

    $_POST      =   json_decode(file_get_contents("php://input"), true)["0"];
    $action     =   !empty($_GET["action"]) ? $_GET["action"] : null;

    $input      =   NEW \classes\core\input;
    $settings   =   NEW \classes\core\settings;
    $session    =   NEW \classes\core\session;
    $_config    =   NEW \classes\core\config;
    
    $register   =   NEW \classes\view\register;
    $login      =   NEW \classes\view\login;

    switch($action){
        case "login" :
            if($input->exist()){
                $username  = !empty($input->get("data")["user"])        ? escape($input->get("data")["user"])   : NULL;
                $password  = !empty($input->get("data")["password"])    ? $input->get("data")["password"]       : NULL;

                if(empty($username) === true){$errors = ["Gebruikesnaam is een verplichte veld"];}
                if(empty($password) === true){$errors = ["Password is een verplichte veld"];}

                //chek username exists                
                elseif($register->usernameExist() === true)     { $errors = ["Gebruikesnaam bestaat niet"];}
                elseif($register->passwordExist() === false)    { $errors = ["Wachtwoord is onjuist"];}

                if(!empty($input->exist()) and empty($errors)){
                    $uuid = $login->getUuid();                    
                    if(!empty($uuid)){
                        if($session->put('userUuid', $uuid)){                                                    
                            $dataArray =    [
                                "data"          =>  "success",
                                "dataContent"   =>  "Je bent nu ingelocht",
                                "dataUri"       =>  "agenda",
                            ];                            
                        };
                    }
                }else{
                    $dataArray =    [
                        "data"          =>  "error",
                        "dataContent"   =>  "{$errors[0]}",
                    ];
                }                
            }else{
                //errors;
            }
                echo json_encode($dataArray);
        break;

        default : 
            if($login->uuidExist() > 0){
                $dataArray =    [
                    "dataUri"       =>  "agenda",
                ]; 

                echo json_encode($dataArray);  
            }
        break;
    }
