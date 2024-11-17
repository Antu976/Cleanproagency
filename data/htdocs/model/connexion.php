<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    //j'active la superglobal SESSION
    // session_start();
    
//    //Je me déco en supprimant ma superglobal SESSION
//    session_destroy();

// le model qui gère les client

function inscription($lastNameAdd,$firstNameAdd,$emailAdd,$numberPhoneAdd,$adresseAdd, $codePostalAdd, $cityAdd, $passwordAdd,$bdd){
    try{
        $req=$bdd->prepare('INSERT INTO client (name_client,prenom_client, email_client, telephone, adresse, code_postale, ville_rdv, mdp) VALUES(?,?,?,?,?,?,?,?)');
        $req->bindParam(1,$lastNameAdd,PDO::PARAM_STR);
        $req->bindParam(2,$firstNameAdd,PDO::PARAM_STR);
        $req->bindParam(3,$emailAdd,PDO::PARAM_STR);
        $req->bindParam(4,$numberPhoneAdd,PDO::PARAM_INT);
        $req->bindParam(5,$adresseAdd,PDO::PARAM_STR);
        $req->bindParam(6,$codePostalAdd,PDO::PARAM_INT);
        $req->bindParam(7,$cityAdd,PDO::PARAM_STR);
        $req->bindParam(8,$passwordAdd,PDO::PARAM_STR);

        $req->execute();

        return true;
    }catch(Exception $error){
        return $error->getMessage();
    }
       
}

//  var_dump($_SESSION);




function verifierConnexion(){

}
function obtenirIdUtilisateur(){

}



function connexion($emailAdd, $bdd) {
    try {
        $req = $bdd->prepare('SELECT * FROM client WHERE email_client = ?');
        $req->bindParam(1, $emailAdd, PDO::PARAM_STR);
        $req->execute();
        $userData = $req->fetch(PDO::FETCH_ASSOC);
        
        if (($userData != false && isset($userData)) || !empty($userData)){
            // Stocker l'email de l'utilisateur dans la session si la connexion réussit
            $_SESSION['user']['email'] = $userData['email_client'];
            $_SESSION['user']['authenticated'] = true; // Indicateur de connexion réussie
            return $userData;
        } else {
            return false; // Renvoie false si aucun utilisateur n'est trouvé avec cet email
        }
    } catch (Exception $error) {
        return false; // Renvoie false en cas d'erreur de requête
    }
}












    



?>