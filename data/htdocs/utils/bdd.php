<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = "cleanpro";
$dbhost = $_SERVER['REMOTE_ADDR'];
$dbport = 3306;
$dbuser = "root";
$dbpasswd = "root";

$bdd = new PDO("mysql:host=$dbhost;port=$dbport;dbname=$db;charset=utf8mb4", $dbuser, $dbpasswd);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $host = 'localhost';
// $dbname = 'clean';
// $user = 'root';
// $pass = '';
// session_start();

// try {
//     $bdd = new PDO("mysql:host=localhost;dbname=cleanpro","root","",
//     array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//     echo 'Connexion réussie';
// } catch (PDOException $e) {
//     echo ('Erreur de connexion : ' . $e->getMessage());
// }
?>
