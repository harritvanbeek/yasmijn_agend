<?php
    
    $protocol   = isset($_SERVER["HTTPS"]) ? 'https' : 'http';  
    defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

    // Global definitions
    $parts      = explode(DIRECTORY_SEPARATOR, BPATH_BASE);

    
    if($_SERVER["SERVER_NAME"] !== "boann.home"){        
        $home = "/yasmijn_agend";
    }elseif($_SERVER["SERVER_NAME"] !== "agenda.yasmijnvels.nl"){
        $home = "/yasmijn_agend";
    }

    define('DS',                  DIRECTORY_SEPARATOR);
    define('BOANN_ROOT',          implode(DS, $parts));
    define('BOANN_SITE',          BOANN_ROOT);
    define('USER_IP',             $_SERVER["REMOTE_ADDR"]);
    define('BOANN_LIBRARIES',     BOANN_ROOT . DS . 'libraries');
    define('BOANN_THEMES',        BPATH_BASE . DS . 'templates');
    define('BOANN_CACHE',         BPATH_BASE . DS . 'cache');
    define('BPATH_CONFIGURATION', BPATH_BASE . DS);
    define('SITE',                "//{$_SERVER["SERVER_NAME"]}{$home}");    
    define('ASSETS',              SITE."/assets");  
    define('THEMES',              SITE."/templates");     