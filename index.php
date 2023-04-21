<?php 
    define('_BOANN', 1);
     if (defined('_BOANN'))
        {
            //include default settings
            define('BPATH_BASE',    dirname(__FILE__) );
            
            require_once BPATH_BASE . '/includes/defines.php';
            require_once BPATH_BASE . '/includes/framework.php';

            if($_GET["action"] === 'logout'){
                unset($_SESSION["userUuid"]);   
                header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}/yasmijn_agend/");                           
            }else{
                require_once BPATH_BASE . '/templates/index.php';
            }
        }    
