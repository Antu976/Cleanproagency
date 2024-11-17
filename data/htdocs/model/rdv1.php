<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function rdv($serviceType,$frequency,$quantity, $date, $time,
$additionalServices,$user_email,$user_id,$bdd){
    try{
        //ETAPE 5 : Préparation de la requête
        $req=$bdd->prepare("INSERT INTO `rdv` (service_rdv, frequence, nbr_article, date_rdv,heure_rdv,services_supplementaire, email_client, id_client) VALUES(?,?,?,?,?,?,?,?);");
         //ETAPE 6 : Binding de Paramètre
        
        $req->bindParam(1,$serviceType, PDO::PARAM_STR);
        $req->bindParam(2,$frequency, PDO::PARAM_STR);
        $req->bindParam(3,$quantity, PDO::PARAM_STR);
        $req->bindParam(4,$date, PDO::PARAM_STR);
        $req->bindParam(5,$time, PDO::PARAM_INT);
        $req->bindParam(6,$additionalServices, PDO::PARAM_STR);
        $req->bindParam(7, $user_email, PDO::PARAM_STR);
        $req->bindParam(8, $user_id, PDO::PARAM_INT);

        $req->execute(array($serviceType, $frequency, $quantity, $date, $time, $additionalServices,$user_email,$user_id));

        if($req){header("location:recap.php");}

        // return "Rendez-vous ajouté avec succès!";
        return true;
    }catch(Exception $error){
        return "Erreur lors de l'ajout du rendez-vous.";
    }
}


//un return sans rien c'est un return false il faudrait mettre un true ou mettre un message qui retourne.

?>