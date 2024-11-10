<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'agencia_de_viajes';


try{
    $PDO = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);
} catch (PDOException $e){
    die('Connection failed: ' .$e->getMessage());
}


// $e = error
?>
