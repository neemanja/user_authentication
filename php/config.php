<?php

/*define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'mysqlpass');
define('DB_HOST', 'localhost');
define('DB_NAME', 'userauthentication');*/


    class Configs { 
        public $DB_USERNAME = 'root'; 
        public $DB_PASSWORD = 'mysqlpass'; 
        public $DB_NAME = 'userauthentication'; 
        public $DB_HOST = 'localhost'; 
        public $serverphp = 'http://localhost:8000';
        public $rootPass = 'mysqlpass';
        public $users = array('root');
    }

    $config = new Configs;

?>