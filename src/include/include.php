<?php

/**
* @author PUG <pugpaprika21@gmail.com>
* @edit 4-05-2566
*/

$err_on = 1;

ini_set('display_errors', $err_on);
ini_set('display_startup_errors', $err_on);
error_reporting(E_ALL);

session_start();

date_default_timezone_set('Asia/Bangkok');

$path = __DIR__ . '../../';

$db_config = require "{$path}configs/db_settings.php";

require "{$path}functions/@@helpers.php";
require "{$path}functions/@@mysqli_db.php";
require "{$path}classes/Http.php";
require "{$path}classes/Str.php";
require "{$path}classes/DBConfig.php";
require "{$path}classes/Query.php";
require "{$path}classes/DB.php"; 

define('APP_NAME_TITLE', '');

define('CREATE_DATE_AT', now('d'));
define('CREATE_TIME_AT', now('t'));
define('CREATE_DT_AT', now());

define('U_SYS_TOKEN', token_generator(rend_string()));
define('U_IP', getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv("REMOTE_ADDR"));
define('APP_URL', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

$db = DB::selectDriver($db_config, 'mysql');
unset($db_config);

$request = anyRequest();