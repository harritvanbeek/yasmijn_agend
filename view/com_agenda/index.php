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
    $agenda     =   NEW \classes\view\agenda;
    $login      =   NEW \classes\view\login;

    switch($action){
        case "getAppointment" :
            if($input->exist()){
                $post_uuid = !empty($input->get("data")["post_uuid"]) ? $input->get("data")["post_uuid"] : NULL;
                foreach($agenda->getAppointment($post_uuid) as $item){
                   $dataArray[] = [
                        "appointment"  => [
                            "agendaUuid"    =>  "{$item->agendaUuid}",
                            "userUuid"      =>  "{$item->userUuid}",
                            "time"          =>  date("H:i", strtotime($item->time)),
                            "message"       =>  "{$item->message}",
                            "subject"       =>  "{$item->subject}",
                        ],                   
                   ]; 
                };

                if(!empty($dataArray)){
                    echo json_encode($dataArray); 
                }
            }
        break;

        case "getAppointments" :
            foreach($agenda->getDates() as $item){                
                $dataArray[] = [
                    "dates"         => date("l d F", strtotime($item->date)),
                    "post_uuid"     => "{$item->uuid}",
                ];                                                                                            
            }
                echo json_encode($dataArray); 
        break;

        case "thisAppointment" :                
            if($input->exist()){
                $uuid   = !empty($input->get("data")) ? $input->get("data") : NULL;
                $item   = $agenda->thisAppointment($uuid);                
                $dataArray  =   [
                    "date"       =>  date("d F, Y", strtotime($item->date)), //21 April, 2023
                    "time"       =>  date("H:i:s", strtotime($item->time)), //00:00:00
                    "onderwerp"  =>  "{$item->subject}",
                    "data"       =>  "{$item->message}",
                ];
                
                //debug($dataArray);
                echo json_encode($dataArray);
            }
        break;

        case "deleteAppointment" :
            if($input->exist()){
                //debug( $input->get("data") );
                $uuid = !empty($input->get("data")) ? $input->get("data") : NULL;
                if($uuid){
                    if($agenda->trash($uuid)){
                        $dataArray =    [
                            "data"          =>  "success",
                            "dataUri"       =>  "agenda",
                        ];
                    }else{};
                }else{

                }
                echo json_encode($dataArray);                 
            }
        break;

        case "newAppointment" :
            if($input->exist()){
                $time       = !empty($input->get("data")["time"])       ? escape($input->get("data")["time"])       : NULL;
                $date       = !empty($input->get("data")["date"])       ? escape($input->get("data")["date"])       : NULL;
                $message    = !empty($input->get("data")["data"])       ? $input->get("data")["data"]               : NULL;
                $subject    = !empty($input->get("data")["onderwerp"])  ? escape($input->get("data")["onderwerp"])  : NULL;
                
                $errors     =   "";

                if(!empty($input->exist()) and empty($errors)){                    
                    $dateUuid =   $settings->MakeUuid();

                    //save appointment
                    $dataPost = [
                        "uuid"  => "{$dateUuid}",
                        "date"  => date("Y-m-d", strtotime($date)), //0000-00-00
                    ];

                    $agenda->datePost($dataPost);

                    //save appointments
                    $dataArray  =   [
                        "agendaUuid" =>  "{$settings->MakeUuid()}",
                        "userUuid"   =>  "{$session->get('userUuid')->uuid}",
                        "dateUuid"   =>  "{$dateUuid}",
                        "time"       =>  "{$time}",                        
                        "message"    =>  "{$message}",
                        "subject"    =>  "{$subject}",
                    ];
                    
                    if($agenda->post($dataArray)){
                        $dataArray =    [
                            "data"          =>  "success",
                            "dataUri"       =>  "agenda",
                        ];  
                    }else{

                    };
                }else{

                }
                    
                    if(!empty($dataArray)){
                        echo json_encode($dataArray);  
                    }
            }
        break;


        default : 
            if($login->uuidExist() < 1){
                $dataArray =    ["dataUri"  => "login"]; 
                echo json_encode($dataArray);  
            }
        break;
    }