<?php
session_start();
//j'active la superglobal SESSION
// session_start();

// //Je me déco en supprimant ma superglobal SESSION
// session_destroy();



//include des mes ressources 
include './utils/bdd.php';
include './model/coordonnees.php';

$message ="";
$showUsers="";

//etape 1: vérifier que le formulaire a été envoyé au serveur
if(isset($_POST['userSubmit'])){
    //etape 2: sécurité: vérifier si les champs nécéssaires sont bien remplie

    if(isset($_POST["name"]) && !empty($_POST['name'])
    && isset($_POST['prenom']) && !empty($_POST['prenom'])
    && isset($_POST['email']) && !empty($_POST['email'])
    && isset($_POST['phone']) && !empty($_POST['phone'])
    && isset($_POST['Adresse']) && !empty($_POST['Adresse'])
    && isset($_POST['code']) && !empty($_POST['code'])
    && isset($_POST['ville']) && !empty($_POST['ville'])){
  //ETAPE 3 : Sécurité - nettoyage des données en appelant ma fonction utilitaire sanitize (voir le fichier functions.php)
  $lastName = htmlentities(strip_tags(trim($_POST['name'])));
  $firstName = htmlentities(strip_tags(trim($_POST['prenom'])));
  $mail = htmlentities(strip_tags(trim($_POST['email'])));
  $numberPhone = htmlentities(strip_tags(trim($_POST['phone'])));    
  $addresse= htmlentities(strip_tags(trim($_POST['Adresse'])));  
  $codePostal = htmlentities(strip_tags(trim($_POST['code']))); 
  $city = htmlentities(strip_tags(trim($_POST['ville'])));  

    //ETAPE 4 : Appeler la fonction du model permettant d'enregister un utilisateur
    $message= client($lastName,$firstName, $mail, $numberPhone, $addresse, $codePostal, $city,$bdd);
    }else{
        $message= "Remplissez le formulaire correctement";
    }
    // header('location:coordonnees.php');
}














$cssacceuil="";
$jscarousel="./script/carousel.js";
$jspopup="";
$cssrecap="";
$cssrdv='';
$cssheader_footer="./style/header-footer.css";
$csscommon="./style/common.css";
$csscoordonnees="./style/coordonnees.css";
include './view/header.php';
include './view/coordonees.php';
include './view/footer.php';
?>