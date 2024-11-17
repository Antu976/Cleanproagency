<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


    //j'active la superglobal SESSION
    // session_start();
    
//    //Je me déco en supprimant ma superglobal SESSION
//    session_destroy();

function client($lastName,$firstName, $mail, $numberPhone, $addresse, $codePostal, $city,$bdd){
    try{
        //etape 5: preparation de la requête
        $req=$bdd->prepare("INSERT INTO client (name_client, prenom_client, email_client, telephone, adresse, code_postale, ville_rdv) VALUES(?,?,?,?,?,?,?)" );

        //etape:6 binding de paramètre

        $req->bindParam(1,$lastName, PDO::PARAM_STR);
        $req->bindParam(2,$firstName, PDO::PARAM_STR);
        $req->bindParam(3,$mail, PDO::PARAM_STR);
        $req->bindParam(4,$numberPhone, PDO::PARAM_STR);
        $req->bindParam(5,$addresse, PDO::PARAM_STR);
        $req->bindParam(6,$codePostal, PDO::PARAM_STR);
        $req->bindParam(7,$city, PDO::PARAM_STR);

        $req->execute();

        return "";
    }catch(Exception $error){
        return $error ->getMessage();
    }
}


?>