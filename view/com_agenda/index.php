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
        case "trashClient" :
            if($input->exist()){
                $uuid     =    !empty($input->get("data")["uuid"])     ? escape($input->get("data")["uuid"])      : NULL;
                //chek agende user is not exist
                if(!empty($input->exist()) and empty($errors)){
                    if($agenda->trashClient($uuid)){
                        $dataArray =    [
                            "data"          =>  "success",                                
                        ];
                    };                   
                }

                if(!empty($dataArray)){
                    echo json_encode($dataArray); 
                }
            }
        break;

        case "getClienten" :
             echo json_encode($agenda->getClients());
        break;

        case "postClienten" :
            if($input->exist()){
                $uuid     =    !empty($input->get("data")["uuid"])     ? escape($input->get("data")["uuid"])      : NULL;
                $client   =    !empty($input->get("data")["client"])   ? escape($input->get("data")["client"])    : NULL;
                
               
                if(empty($client)){$errors = ["je hebt niets opgegeven!"];}
                elseif($agenda->clientExist($client)){$errors = ["Client bestaat al!"];}

                if(!empty($input->exist()) and empty($errors)){
                    if($uuid){
                        $postArray = [
                            "uuid"    =>  $uuid,
                            "client"  =>  $client,
                        ];
                        
                        if($agenda->updateClient($postArray)){
                            $dataArray =    [
                                "data"          =>  "success",                                
                            ];
                        };                         
                    }else{
                        $postArray = [
                            "uuid"    =>  $settings->MakeUuid(),
                            "client"  =>  $client,
                        ];
                        
                        if($agenda->postClient($postArray)){
                            $dataArray =    [
                                "data"          =>  "success",                                
                            ];
                        };                         
                    }
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

        case "changeUsername" :
            if($input->exist()){

                $newUsername    = !empty($input->get("data")["new_username"])    ? escape($input->get("data")["new_username"])      : NULL;
                $repeatUsername = !empty($input->get("data")["repeat_username"]) ? escape($input->get("data")["repeat_username"])   : NULL;

                $uuid           = $login->getUsername($session->get("userUuid")->uuid); 

                if(empty($newUsername)      === true)            {$errors = ["Nieuw gebruikersnaam is een verplichte veld"];}
                elseif($register->userExist($newUsername)){$errors = ["Gebruikesnaam bestaat al!"];}
                elseif(empty($repeatUsername)   === true)            {$errors = ["Repeat gebruikersnaam is een verplichte veld"];}
                elseif($newUsername !== $repeatUsername)             {$errors = ["gebruikersnaam komt niet overeen"];}
                if(!empty($input->exist()) and empty($errors)){
                    //set new password
                    $postArray = [
                        "uuid"      =>  $session->get("userUuid")->uuid,
                         "username"  =>  $newUsername,
                    ];
                    
                    if($login->updateUsername($postArray)){
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

        case "nowAppointment" :
                $date = date("Y-m-d", getdate()[0]); 
                if(!empty($date)){
                    foreach($agenda->nowAppointment($date) as $item){
                       $dataArray[] = [
                            "appointment"  => [
                                "agendaUuid"    =>  "{$item->agendaUuid}",
                                "userUuid"      =>  "{$item->userUuid}",
                                "date"          =>  date("D d F", strtotime($item->date)),
                                "time"          =>  date("H:i", strtotime($item->time)),
                                "message"       =>  "{$item->message}",
                                "subject"       =>  "{$item->subject}",
                                "client"        =>  "{$item->client}",
                            ],                   
                       ]; 
                    };
                }
                if(!empty($dataArray)){
                    echo json_encode($dataArray); 
                }
        break;

        case "filterClient" :
            if($input->exist()){
                $client   = !empty($input->get("data")["client"])     ? $input->get("data")["client"]    : null;
                if(!empty($client)){
                    foreach($agenda->filterClient($client) as $item){
                       $dataArray[] = [
                            "appointment"  => [
                                "agendaUuid"    =>  "{$item->agendaUuid}",
                                "userUuid"      =>  "{$item->userUuid}",
                                "date"          =>  date("D d F", strtotime($item->date)),
                                "time"          =>  date("H:i", strtotime($item->time)),
                                "message"       =>  "{$item->message}",
                                "subject"       =>  "{$item->subject}",
                                "client"        =>  "{$item->client}",
                            ],                   
                       ]; 
                    };
                }

                if(!empty($dataArray)){
                    echo json_encode($dataArray); 
                }
            }
        break;

        case "getAppointment" :
            if($input->exist()){
                $week       = !empty($input->get("data")["weekID"])     ? $input->get("data")["weekID"]       : null; 
                $month      = !empty($input->get("data")["month"])      ? $input->get("data")["month"]      : null; 
                $post_uuid  = !empty($input->get("data")["post_uuid"])  ? $input->get("data")["post_uuid"]  : NULL;
                
                if(!empty($post_uuid)){ 
                    

                    foreach($agenda->getAppointment($post_uuid) as $item){
                       $dataArray[] = [
                            "appointment"  => [
                                "agendaUuid"    =>  "{$item->agendaUuid}",
                                "userUuid"      =>  "{$item->userUuid}",
                                "date"          =>  date("D d F", strtotime($item->date)),
                                "time"          =>  date("H:i", strtotime($item->time)),
                                "message"       =>  "{$item->message}",
                                "subject"       =>  "{$item->subject}",
                                "client"        =>  "{$item->client}",
                            ],                   
                       ]; 
                    };
                }elseif(!empty($month)){
                    foreach($agenda->getByMonth($month) as $item){
                       $dataArray[] = [
                            "appointment"  => [
                                "agendaUuid"    =>  "{$item->agendaUuid}",
                                "userUuid"      =>  "{$item->userUuid}",
                                "date"          =>  date("D d F", strtotime($item->date)),                                
                                "time"          =>  date("H:i", strtotime($item->time)),
                                "message"       =>  "{$item->message}",
                                "subject"       =>  "{$item->subject}",
                                "client"        =>  "{$item->client}",
                            ],                   
                       ]; 
                    };
                }else{
                    foreach($agenda->getByWeeks($week) as $item){
                       $dataArray[] = [
                            "appointment"  => [
                                "agendaUuid"    =>  "{$item->agendaUuid}",
                                "userUuid"      =>  "{$item->userUuid}",
                                "date"          =>  date("D d F", strtotime($item->date)),                                
                                "time"          =>  date("H:i", strtotime($item->time)),
                                "message"       =>  "{$item->message}",
                                "subject"       =>  "{$item->subject}",
                                "client"        =>  "{$item->client}",
                            ],                   
                       ]; 
                    };
                }

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

        case "getWeeks" :
            foreach($agenda->getWeeks() as $item){ 
                if($item->week){
                    $dataArray[] = [
                        "week" => "Week {$item->week}",                    
                        "weekID" => "{$item->week}",                    
                    ];                                                                                                                
                }               
            }
                echo json_encode($dataArray);            
        break;

        case "getMonths" :
            foreach($agenda->getMonth() as $item){ 
                if($item->month){
                    $dataArray[] = [
                        "month" => "{$item->month}",                    
                    ];                                                                                                                
                }               
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
                    "client"     =>  "{$item->uuid}",
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

        case "updateAppointment" :
            if($input->exist()){
                $time       = !empty($input->get("data")["time"])       ? escape($input->get("data")["time"])       : NULL;
                $date       = !empty($input->get("data")["date"])       ? escape($input->get("data")["date"])       : NULL;
                $client     = !empty($input->get("data")["client"])     ? $input->get("data")["client"]             : NULL;
                $message    = !empty($input->get("data")["data"])       ? $input->get("data")["data"]               : NULL;
                $subject    = !empty($input->get("data")["onderwerp"])  ? escape($input->get("data")["onderwerp"])  : NULL;
                $setDate    = new DateTime($date);
                                       
                if(empty($time) === true)        { $errors = ["Tijd is een verplichte veld!"]; }
                elseif(empty($date) === true)    { $errors = ["Datum is een verplichte veld!"]; }
                elseif(empty($message) === true) { $errors = ["Bericht is een verplichte veld!"]; }
                elseif(empty($subject) === true) { $errors = ["Onderwerp is een verplichte veld!"]; }

                if(!empty($input->exist()) and empty($errors)){
                    $newDate    = date("Y-m-d", strtotime($date));

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
                        "client"     =>  "{$client}",
                        "dateUuid"   =>  "{$dateUuid}",
                        
                        "week"       =>  $setDate->format("W"),                        
                        "month"      =>  $setDate->format("M"),  

                        "time"       =>  "{$time}",                        
                        "message"    =>  "{$message}",
                        "subject"    =>  "{$subject}",
                    ];

                    if($agenda->update($dataArray)){
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

        case "newAppointment" :
            if($input->exist()){
                $time       = !empty($input->get("data")["time"])       ? escape($input->get("data")["time"])       : NULL;
                $date       = !empty($input->get("data")["date"])       ? escape($input->get("data")["date"])       : NULL;
                $client     = !empty($input->get("data")["client"])     ? $input->get("data")["client"]             : NULL;
                $message    = !empty($input->get("data")["data"])       ? $input->get("data")["data"]               : NULL;
                $subject    = !empty($input->get("data")["onderwerp"])  ? escape($input->get("data")["onderwerp"])  : NULL;
                $setDate    = new DateTime($date);
                                       
                if(empty($time) === true)        { $errors = ["Tijd is een verplichte veld!"]; }
                elseif(empty($date) === true)    { $errors = ["Datum is een verplichte veld!"]; }
                elseif(empty($message) === true) { $errors = ["Bericht is een verplichte veld!"]; }
                elseif(empty($subject) === true) { $errors = ["Onderwerp is een verplichte veld!"]; }
                
                if(!empty($input->exist()) and empty($errors)){                    
                    $newDate    = date("Y-m-d", strtotime($date));
                    
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
                        "client"     =>  "{$client}",
                        "dateUuid"   =>  "{$dateUuid}",
                        
                        "week"       =>  $setDate->format("W"),                        
                        "month"      =>  $setDate->format("M"),  

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