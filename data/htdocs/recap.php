<?php
session_start();
include './utils/bdd.php';
include './model/rdv1.php';
include './model/recap.php';


// $showRdv="";

// $data =showRdv($bdd);
// // var_dump($data);
// foreach ($data as $rdv){
//     $showRdv = $showRdv."<p>Vous avez demandé un lavage de {$rdv['service_rdv']}</p>
//     <p> A la fréquence {$rdv['frequence']}</p>
//     <p> avec un nombre d'article de {$rdv['nbr_article']}</p>
//     <p> A la date {$rdv['date_rdv']}</p>
//     <p> A l'heure {$rdv['heure_rdv']}</p>
//     <p> {$rdv['services_supplementaire']}</p>
//     <br><br>";
// }


if (isset($_SESSION['user_email']) && isset($_SESSION['user_id']) && isset($_SESSION['user_email']['authenticated']) && $_SESSION['user_email']['authenticated']) {
    // Rediriger vers la page d'accueil ou une autre page
    // var_dump($_SESSION);
}else{
    header('Location: connexion.php');
    exit;
}










$cssacceuil="";
$jscarousel="";
$jspopup="./script/popup.js";
$csscoordonnees="";
$cssrdv="";
$cssheader_footer="./style/header-footer.css";
$csscommon="./style/common.css";
$cssrecap="./style/recap.css";





include './view/header.php';
include './view/recap.php';
include './view/footer.php';

?>