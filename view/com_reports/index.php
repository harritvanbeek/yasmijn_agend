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
    $reports    =   NEW \classes\view\reports;
    $agenda     =   NEW \classes\view\agenda;
    $login      =   NEW \classes\view\login;

    switch($action){
        case "thisReports" :
            $uuid   =   !empty($_GET["uuid"]) ? $_GET["uuid"] : NULL;
            echo json_encode($reports->thisReports($uuid));
        break;

        case "getClienten" :
            echo json_encode($agenda->getClients());
       break;

        case "removeDays" :
            if($input->exist()){
                $uuid   =   !empty($input->get("data")["post_uuid"]) ? $input->get("data")["post_uuid"] : NULL;
                $check  =   !empty($input->get("data")["check"])     ? $input->get("data")["check"] : NULL;
                
                if(!empty($input->exist())){
                        $postArray  =  [
                            "uuid"  =>  "{$uuid}",
                            "check" =>  "{$check}",
                        ];
                        
                        if($reports->removeDays($postArray) > 0){
                           $dataArray =    [
                                "data"          =>  "success",
                                "dataContent"   =>  "Systeem is bijgewekt",
                            ]; 
                        }

                        if(!empty($dataArray)){
                            echo json_encode($dataArray); 
                        } 
                }
            }
        break;

        case "days" :
            foreach($agenda->getDates() as $item){                
                $dataArray[] = [
                    "day"         => date("l d F", strtotime($item->date)),
                    "post_uuid"     => "{$item->uuid}",
                ];                                                                                            
            }
            echo json_encode($dataArray); 
        break;   
        
        case "removeReport" :                
            if($input->exist()){
                $uuid = !empty($input->get("data")["uuid"]) ? $input->get("data")["uuid"] : null;
                if($reports->trash($uuid)){
                    $dataArray =    [
                        "data"          =>  "success",
                        "dataContent"   =>  "Systeem is bijgewekt",
                    ];
                };

                if(!empty($dataArray)){
                    echo json_encode($dataArray); 
                } 
            }
        break;

        case "getReports" :
            foreach($reports->get() as $item){
                $dataArray[] =  [
                    "uuid"      => "{$item->uuid}",
                    "clientUuid" =>  "{$item->clientUuid}",
                    "title"     => "{$item->title}",
                    "message"   => "{$item->message}",
                    "post_date" => date("l d, F h:m", strtotime($item->post_date)) //"{$item->post_date}",
                ];
            };

            if(!empty($dataArray)){
                echo json_encode($dataArray); 
            }
        break;

        case "updateReport" :
            if($input->exist()){
                $uuid       = !empty($input->get("data")["uuid"])    ? $input->get("data")["uuid"]          : null;
                $client     = !empty($input->get("data")["client"])     ? $input->get("data")["client"]             : NULL;
                $title      = !empty($input->get("data")["title"])   ? escape($input->get("data")["title"]) : null;
                $message    = !empty($input->get("data")["message"]) ? $input->get("data")["message"]       : null;

                if(empty($title))       {$errors = ["Je geen title opgegeven!"];}
                elseif(empty($message)) {$errors = ["Bericht in nog leeg!"];}

                if(!empty($input->exist()) and empty($errors)){
                    //post new report 
                    $postArray = [
                        "uuid"      => "{$uuid}",
                        "clientUuid" =>  "{$client}",
                        "title"     => "{$title}",
                        "message"   => "{$message}",
                        "post_updated" => date("l d, F h:m", strtotime($post_updated)) //"{$item->post_date}",
                    ];

                    if($reports->thisUpdate($postArray) > 0){
                        $dataArray =    [
                            "data"          =>  "success",
                            "dataContent"   =>  "Systeem is bijgewekt",
                        ];
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

        case "newReport" :
            if($input->exist()){
                $client     = !empty($input->get("data")["client"])     ? $input->get("data")["client"]             : NULL;
                $title      = !empty($input->get("data")["title"])   ? escape($input->get("data")["title"]) : null;
                $message    = !empty($input->get("data")["message"]) ? $input->get("data")["message"]       : null;

                if(empty($title))       {$errors = ["Je geen title opgegeven!"];}
                elseif(empty($message)) {$errors = ["Bericht in nog leeg!"];}

                if(!empty($input->exist()) and empty($errors)){
                    //post new report 
                    $postArray = [
                        "uuid"      => "{$settings->MakeUuid()}",
                        "clientUuid" =>  "{$client}",
                        "title"     => "{$title}",
                        "message"   => "{$message}",
                    ];

                    if($reports->add($postArray) > 0){
                        $dataArray =    [
                            "data"          =>  "success",
                            "dataContent"   =>  "Systeem is bijgewekt",
                        ];
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

        default : 
            if($login->uuidExist() < 1){
                $dataArray =    ["dataUri"  => "login"]; 
                echo json_encode($dataArray);  
            }
        break;
    }