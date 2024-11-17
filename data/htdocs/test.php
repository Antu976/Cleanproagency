<?php

$host = 'localhost';
$dbname = 'clean';
$user = 'root';
$pass = '';
// session_start();

// try {
    $bdd = new PDO("mysql:host=localhost;dbname=clean","root","",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $req = $bdd->prepare('SELECT * FROM client;');
        $req->execute();
        $userData = $req->fetch(PDO::FETCH_ASSOC);
        if (($userData != false && isset($userData)) || !empty($userData)) {

        }
        var_dump($userData);


        