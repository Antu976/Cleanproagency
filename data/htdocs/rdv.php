<?php

//j'active la superglobal SESSION
session_start();

// //Je me déco en supprimant ma superglobal SESSION
// session_destroy();




//include de mes ressources
include './utils/bdd.php';
include './model/rdv1.php';

$message ="";
$showUsers="";
// $user_email="";


// // Vérifier si l'utilisateur est connecté
// if(isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
//     // Récupérer l'ID de l'utilisateur depuis la session
//     $user_email = $_SESSION['user']['email'];
    
// // var_dump($_SESSION);
// //étape 1 : vérifier que le formulaire a été envoyé au serveur 
// if(isset ($_POST['submit'])){
//     //étape 2: sécurité -vérifier si les champs nécéssaires sont bien remplie
//     if(isset($_POST["serviceType"]) && !empty($_POST['serviceType'])
//     && isset($_POST['frequency']) && !empty($_POST['frequency'])
//     && isset($_POST['quantity']) && !empty($_POST['quantity'])
//     && isset($_POST['date']) && !empty($_POST['date'])
//     && isset($_POST['time']) && !empty($_POST['time'])
//     && isset($_POST['additionalServices']) && !empty($_POST['additionalServices'])){
//   //ETAPE 3 : Sécurité - nettoyage des données en appelant ma fonction utilitaire sanitize (voir le fichier functions.php)
//         $serviceType = htmlentities(strip_tags(trim($_POST['serviceType'])));
//         $frequency = htmlentities(strip_tags(trim($_POST['frequency'])));
//         $quantity = htmlentities(strip_tags(trim($_POST['quantity'])));
//         $date = htmlentities(strip_tags(trim($_POST['date'])));    
//         $time = htmlentities(strip_tags(trim($_POST['time'])));  
//         $additionalServices = htmlentities(strip_tags(trim($_POST['additionalServices'])));  

//     //ETAPE 4 : Appeler la fonction du model permettant d'enregister un utilisateur
//     $message= rdv($serviceType,$frequency,$quantity, $date, $time,
//     $additionalServices,$user_email,$bdd);
//     }else{
//         $message= "Remplissez le formulaire correctement";
//     }
    
// }

   








// Vérifier si l'utilisateur est connecté
if(isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    // Récupérer l'email de l'utilisateur depuis la session
    $user_email = $_SESSION['user']['email'];
} else {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

// Traitement du formulaire de rendez-vous s'il a été soumis
if(isset($_POST['submit'])) {
    // Vérifier si les champs nécessaires sont remplis
    if(isset($_POST["serviceType"]) && !empty($_POST['serviceType'])
        && isset($_POST['frequency']) && !empty($_POST['frequency'])
        && isset($_POST['quantity']) && !empty($_POST['quantity'])
        && isset($_POST['date']) && !empty($_POST['date'])
        && isset($_POST['time']) && !empty($_POST['time'])
        && isset($_POST['additionalServices']) && !empty($_POST['additionalServices'])
        && isset($_POST['user_id']) && !empty($_POST['user_id'])){
            
        // Nettoyage des données du formulaire
        $serviceType = htmlentities(strip_tags(trim($_POST['serviceType'])));
        $frequency = htmlentities(strip_tags(trim($_POST['frequency'])));
        $quantity = htmlentities(strip_tags(trim($_POST['quantity'])));
        $date = htmlentities(strip_tags(trim($_POST['date'])));
        $time = htmlentities(strip_tags(trim($_POST['time'])));
        $additionalServices = htmlentities(strip_tags(trim($_POST['additionalServices'])));
        $user_id = htmlentities(strip_tags(trim($_POST['user_id'])));
       
        $message= rdv($serviceType,$frequency,$quantity, $date, $time, $additionalServices,$user_email, $user_id,$bdd);
    }else{
        $message= "Remplissez le formulaire correctement";
    }
    // Insertion du rendez-vous dans la base de données
}



$actionRdv="rdv.php";





//j'avais qui se rajoute en double car j'avais mon message en double 


// var_dump($_POST);































$cssacceuil="";
$jscarousel="./script/carousel.js";
$jspopup="";
$cssrecap="";
$csscoordonnees="";
$cssheader_footer="./style/header-footer.css";
$csscommon="./style/common.css";
$cssrdv="./style/rdv.css";
include './view/header.php';
include './view/rdv1.php';
include './view/footer.php';

?>