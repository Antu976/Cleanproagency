<?php

session_start();
include './utils/bdd.php';



$messageMod="";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $req = $bdd->prepare("SELECT * FROM rdv WHERE id = ?");
    $req->bindParam(1,$id, PDO::PARAM_INT);
    $req->execute();
    $mod = $req->fetch();
}

if (isset($_POST['modifier'])) {
    if(isset($_POST["serviceType"]) && !empty($_POST['serviceType'])
        && isset($_POST['frequency']) && !empty($_POST['frequency'])
        && isset($_POST['quantity']) && !empty($_POST['quantity'])
        && isset($_POST['date']) && !empty($_POST['date'])
        && isset($_POST['time']) && !empty($_POST['time'])
        && isset($_POST['additionalServices']) && !empty($_POST['additionalServices'])
        && isset($_POST['id']) && !empty($_POST['id'])){
            
        // Nettoyage des données du formulaire
        $serviceType = htmlentities(strip_tags(trim($_POST['serviceType'])));
        $frequency = htmlentities(strip_tags(trim($_POST['frequency'])));
        $quantity = htmlentities(strip_tags(trim($_POST['quantity'])));
        $date = htmlentities(strip_tags(trim($_POST['date'])));
        $time = htmlentities(strip_tags(trim($_POST['time'])));
        $additionalServices = htmlentities(strip_tags(trim($_POST['additionalServices'])));
        $id = htmlentities(strip_tags(trim($_POST['id'])));

        $messageMod= mod($serviceType,$frequency,$quantity, $date, $time, $additionalServices,$id,$bdd);
    
        }
    }

    function mod($serviceType,$frequency,$quantity, $date, $time,
    $additionalServices,$id,$bdd){

        try{
    $req = $bdd->prepare("UPDATE rdv SET service_rdv=?, frequence=?, nbr_article=?, date_rdv=?, heure_rdv=?, services_supplementaire=? where id= ?");
    $req->bindParam(1,$serviceType, PDO::PARAM_STR);
    $req->bindParam(2,$frequency, PDO::PARAM_STR);
    $req->bindParam(3,$quantity, PDO::PARAM_STR);
    $req->bindParam(4,$date, PDO::PARAM_INT);
    $req->bindParam(5,$time, PDO::PARAM_INT);
    $req->bindParam(6,$additionalServices, PDO::PARAM_STR);
    $req->bindParam(7,$id, PDO::PARAM_INT);
    // Exécutez la requête en passant les valeurs de liaison dans execute
    $req->execute([$serviceType, $frequency, $quantity, $date, $time, $additionalServices,$id]);

     $req->execute(array($serviceType,$frequency,$quantity, $date, $time,$additionalServices,$id));

        header("location:recap.php");

    var_dump($req);
}catch(Exception $error){
    echo $error->getMessage();
    return "Erreur lors de la modification.";
}
    }




$cssacceuil="";
$jscarousel = "./script/carousel.js";
$jspopup = "";
$csscoordonnees = "";
$cssrdv = "";
$cssheader_footer = "./style/header-footer.css";
$csscommon = "./style/common.css";
$cssrecap = "";
$cssrdv = "./style/rdv.css";
include './view/header.php';
include './view/modifier.php';
include './view/footer.php';

?>