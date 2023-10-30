<?php
use APP\Authentifications;
use APP\Autoloader;
use APP\MyDB;

// require_once'classes/MyDB.php';
require_once'classes/Authentification.php';
require_once'classes/functions.php';
require_once'classes/Autoloader.php';
Autoloader::register();
$errorNom=$errorPrenom=$errorEmail=$errorTelephone=$errorPassword="";
$valueNom=$valuePrenom=$valueEmail=$valueTelephone=$valuePassword="";
check();
$host = "localhost";
$dbname ="taxi";
$username="root";
$password= "root";

$connection1 = new MyDB($host, $dbname, $username, $password); 
$connection1->Connection();
$conn = $connection1->getConn();
$insert = new Authentifications($conn);
if ($_SERVER["REQUEST_METHOD"] ==='POST') {
if (isset($_POST["connexion"])) {
    $email = $_POST["email"];   
    $password = $_POST["password"]; 
    $insert->KayMaAuthentifierLa($email, $password);    
}elseif (isset($_POST["inscription"])) {
    $insert->ValidationFormulaire();;
}

    
}











?>