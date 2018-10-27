<?php 

//Note: This file should be included first in every php page.

define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER','simpleadmin');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));


require_once BASE_PATH.'/lib/MysqliDb.php';

/*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
*/

define('DB_HOST', "zioncg1.clbrnd07xbtf.us-east-1.rds.amazonaws.com");
define('DB_USER', "scmm_webapp");
define('DB_PASSWORD', "W^\"iu^M\"[wpB]]5vB3aWndoT)4{W%i[gL]4}#y~+");
define('DB_NAME', "scmm_webapp");

/**
* Get instance of DB object
*/
function getDbInstance()
{
	return new MysqliDb(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME); 
}
