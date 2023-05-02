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
        case "changePassword" :
            if($input->exist()){
                $oldPassword    = !empty($input->get("data")["old_password"])    ? escape($input->get("data")["old_password"])      : NULL;
                $newPassword    = !empty($input->get("data")["new_password"])    ? escape($input->get("data")["new_password"])      : NULL;
                $repeatPassword = !empty($input->get("data")["repeat_password"]) ? escape($input->get("data")["repeat_password"])   : NULL;
                
                $uuid           = $login->getUsername($session->get("userUuid")->uuid); 

                if(empty($oldPassword)      === true)                {$errors = ["Oude wachtwoord is een verplichte veld"];}
                elseif($register->passwordExist($uuid) === false)    {$errors = ["Wachtwoord is onjuist"];}
                elseif(empty($newPassword)      === true)            {$errors = ["Nieuw wachtwoord is een verplichte veld"];}
                elseif(empty($repeatPassword)   === true)            {$errors = ["Repeat wachtwoord is een verplichte veld"];}
                elseif($newPassword !== $repeatPassword)             {$errors = ["Wachtwoorden komen niet overeen"];}

                if(!empty($input->exist()) and empty($errors)){
                    //set new password
                    $postArray = [
                        "uuid"      =>  $session->get("userUuid")->uuid,
                        "password"  =>  $settings->passwordHash($newPassword),
                    ];
                    
                    if($login->updatePassword($postArray)){
                        $dataArray =    [
                            "data"          =>  "success",
                            "dataContent"   =>  "Wachtwoord is bijgewekt",
                        ];
                    };

                }else{
                    $dataArray =    [
                        "data"          =>  "error",
                        "dataContent"   =>  "{$errors[0]}",
                    ];
                }

                if(!empty($dataArray)){
                    echo json_encode($dataArray); 
                }
            }
        break;

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
                    };
                }else{
                        $dataArray =    [
                            "data"          =>  "errors",
                            "dataUri"       =>  "Database disconnect error",
                        ];
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
                
                if(empty($time) === true)        { $errors = ["Tijd is een verplichte veld!"]; }
                elseif(empty($date) === true)    { $errors = ["Datum is een verplichte veld!"]; }
                elseif(empty($message) === true) { $errors = ["Bericht is een verplichte veld!"]; }
                elseif(empty($subject) === true) { $errors = ["Onderwerp is een verplichte veld!"]; }
                
                if(!empty($input->exist()) and empty($errors)){                    
                    $newDate    = date("Y-m-d", strtotime($date));

                    /*debug($newDate, 1);*/
                    /*debug($agenda->datesExist($newDate), 1);*/
                    if($agenda->datesExist($newDate) > 0){
                        $dateUuid = $agenda->getDateUuid($newDate)->uuid;
                    }else{
                        //save appointment
                        $dateUuid   = $settings->MakeUuid();
                        $dataPost = [
                            "uuid"  => "{$dateUuid}",
                            "date"  => "{$newDate}", //0000-00-00
                        ];

                        $agenda->datePost($dataPost);
                    }

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
                        $dataArray =    [
                            "data"          =>  "errors",
                            "dataUri"       =>  $errors[0],
                        ];
                    };
                }else{
                        $dataArray =    [
                            "data"          =>  "errors",
                            "dataUri"       =>  "Database disconnect error",
                        ];
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