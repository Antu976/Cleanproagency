<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function showUser($bdd, $user_email){
    try{
        //Etape 2: Préparation de la requête
        $req=$bdd->prepare('SELECT * FROM client where email_client=?');

        //Etape 3 : Exécuter la requête
        $req->execute([$user_email]);

        //Etape 4 :Récuperation des données
        $data=$req->fetchAll();

        //Etape 5: J'envoie les données au controler
        return $data;
    }catch(Exception $error){
        return $error->getMessage();
    }
}





?>