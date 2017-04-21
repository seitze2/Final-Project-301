<?php

$user = 'seitze2';
$password = 'XcAwrkZ7';

$database = new PDO('mysql:host=csweb.hh.nku.edu;dbname=db_spring17_seitze2', $user, $password);

function my_autoloader($class)
{
	include('classes/class.' . $class . '.php');
}

session_start();

$current_url = basename($_SERVER['REQUEST_URI']);

spl_autoload_register('my_autoloader');

if (!isset($_SESSION["userID"]) && $current_url != 'login.php') {
    header("Location: login.php");
}

elseif (isset($_SESSION["userID"])) {	
	$user = new User($_SESSION["userID"], $database);
}
?>