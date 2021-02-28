<?php

// database params

define('dbServername' , 'localhost');
define('dbUsername' , 'root');
define('dbPassword' , '');
define('dbName' , 'webshop_alkmaar');

//approot
define('APPROOT',dirname(dirname(__FILE__)));

//urlroot (dynamic links)
define('URLROOT', 'http://localhost/alkmaarwebshop-v1');

// sitename
define('SITENAME', 'Alkmaar Webshop');


// constants for validations
define('NUMBERVALIDATION' , "/^[0-9.]*$/");

define('NAMEVALIDATION' , '/^[a-zA-Z0-9_ ]*$/');

define('PASSWORDVALIDATION' , '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}');

