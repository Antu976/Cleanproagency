<?php
session_start();

include './utils/bdd.php';
include './model/connexion.php';

$messageAddUser  = '';
$messageConnexion  = '';
$afficherUser = '';
$lastNameAdd = '';
$firstNameAdd ='';
$emailAdd ='';
$passwordAdd ='';
$numberPhoneAdd="";
$adresseAdd="";
$adresseAdd="";
$codePostalAdd="";
$cityAdd="";



$actionconnexion ="connexion.php";


$error='';





// Vérifier si l'utilisateur est déjà connecté
// if (isset($_SESSION['user_mail']) && isset($_SESSION['user_mail']['authenticated']) && $_SESSION['user']['authenticated']) {
//     // Rediriger vers la page d'accueil ou une autre page
// }
// var_dump($_SESSION);
if (isset($_SESSION['user_email']) && isset($_SESSION['user_id']) && isset($_SESSION['user_email']['authenticated']) && $_SESSION['user_email']['authenticated']) {
    // Rediriger vers la page d'accueil ou une autre page
    // var_dump($_SESSION);
}

// Traitement du formulaire de connexion
if (isset($_POST['submitConnexion'])) {
    // Vérifier si les champs email et mot de passe sont remplis
    if (isset($_POST['emailAdd']) && !empty($_POST['emailAdd']) &&
        isset($_POST['passwordAdd']) && !empty($_POST['passwordAdd'])) {

        // Récupérer les valeurs du formulaire
        $emailAdd = htmlentities(strip_tags(trim($_POST['emailAdd'])));
        $passwordAdd = htmlentities(strip_tags(trim($_POST['passwordAdd'])));


        $emailAdd = filter_var( $emailAdd, FILTER_SANITIZE_EMAIL);

        // Validate e-mail
        if (filter_var( $emailAdd, FILTER_VALIDATE_EMAIL)) {
            $error =(" $emailAdd l'adresse email est valide");
        } else {
             $error = (" $emailAdd l'adresse email n'est pas valide");
           
        }



        // Appeler la fonction de connexion du modèle
        $userData = connexion($emailAdd, $bdd);

        // Vérifier si l'utilisateur existe
        if (($userData != false && isset($userData)) || !empty($userData)) {
            // Vérifier si le mot de passe est correct
            if (password_verify($passwordAdd, $userData['mdp'])) {
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['user_id'] = $userData['id_client'];
                $_SESSION['user_email'] = $userData;
                $_SESSION['user_email']['authenticated'] = true; // Indicateur de connexion réussie
                // Rediriger vers la page d'accueil ou une autre page
                header('Location: index.php');
                exit;
            } else {
                $messageConnexion = "Mot de passe incorrect.";
            }
        } else {
            $messageConnexion = "Aucun utilisateur trouvé avec cet email.";
        }
    } else {
        $messageConnexion = "Veuillez saisir un email et un mot de passe.";
    }
}





// print_r($_SESSION);



$cssacceuil="";
$jscarousel="";
$jspopup="";
$cssrecap="";
$csscoordonnees="";
$cssheader_footer="";
$csscommon="";
$cssrdv="";

include './view/connexion.php';
?>