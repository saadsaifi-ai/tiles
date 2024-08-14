<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
define('DB_SERVER','localhost');
define('DB_USER','phpmyadmin');
define('DB_PASS' ,'tiger123');
define('DB_NAME', 'tile1');

class DBconection
{
	public $dbh;
function __construct()
{

$this->dbh =mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Check connection
if (mysqli_connect_errno())
{
	throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
 }
}

}

?>
