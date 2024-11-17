<?php
session_start();
//j'active la superglobal SESSION
// session_start();

// //Je me déco en supprimant ma superglobal SESSION
// session_destroy();


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

$errorin="";


if(isset($_POST['submitAddUser'])){
    if(isset($_POST['lastNameAdd']) && !empty($_POST['lastNameAdd']) 
        && isset($_POST['firstNameAdd']) && !empty($_POST['firstNameAdd'])
        && isset($_POST['emailAdd']) && !empty($_POST['emailAdd'])
        && isset($_POST['numberPhoneAdd']) && !empty($_POST['numberPhoneAdd'])
        && isset($_POST['adresseAdd']) && !empty($_POST['adresseAdd'])
        && isset($_POST['codePostalAdd']) && !empty($_POST['codePostalAdd'])
        && isset($_POST['cityAdd']) && !empty($_POST['cityAdd'])
        && isset($_POST['passwordAdd']) && !empty($_POST['passwordAdd'])){

        $lastNameAdd = htmlentities(strip_tags(trim($_POST['lastNameAdd'])));
        $firstNameAdd = htmlentities(strip_tags(trim($_POST['firstNameAdd'])));
        $emailAdd = htmlentities(strip_tags(trim($_POST['emailAdd'])));
        $numberPhoneAdd = htmlentities(strip_tags(trim($_POST['numberPhoneAdd'])));    
        $adresseAdd= htmlentities(strip_tags(trim($_POST['adresseAdd'])));  
        $codePostalAdd = htmlentities(strip_tags(trim($_POST['codePostalAdd']))); 
        $cityAdd = htmlentities(strip_tags(trim($_POST['cityAdd']))); 
        $passwordAdd = htmlentities(strip_tags(trim($_POST['passwordAdd'])));

    


        $passwordAdd =password_hash($passwordAdd, PASSWORD_BCRYPT);

        $messageAddUser = inscription($lastNameAdd,$firstNameAdd,$emailAdd,$numberPhoneAdd,$adresseAdd,$codePostalAdd, $cityAdd, $passwordAdd,$bdd);

    }
    else {
    
        $messageAddUser= 'Mmmhhhhh je pense que nous sommes face à un litige';
    }
}




$actionCreateUser = "inscription.php";

    if(isset($_POST['submitAddUser'])){
        $_SESSION['lastName'] = $_POST['lastNameAdd'];
        $_SESSION['firstName'] = $_POST['firstNameAdd'];
        $_SESSION['email'] = $_POST['emailAdd'];
        $_SESSION['numberPhone'] = $_POST['numberPhoneAdd'];
        $_SESSION['adresse'] = $_POST['adresseAdd'];
        $_SESSION['codePostal'] = $_POST['codePostalAdd'];
        $_SESSION['city'] = $_POST['cityAdd'];
        
        $messageAddUser= 'Votre inscription a bien été prise en compte maintenant veuillez vous connecter';
        // header('location:index.php');
        // exit();
       
    }

    // $emailAdd = filter_var( $emailAdd, FILTER_SANITIZE_EMAIL);

    //     // // Validate e-mail
    //     if (filter_var( $emailAdd, FILTER_VALIDATE_EMAIL)) {
    //         $errorin = " l'adresse email est valide ";
    //         header('location:index.php');
    //         exit();
    //     } else {
    //         $errorin = "l'adresse email n'est pas valide";
    //         header('location: inscription.php');
    //         exit();
    //     }
    




























$cssacceuil=""; 
$jscarousel="";
$jspopup="";
$cssrecap="";
$csscoordonnees="";
$cssheader_footer="";
$csscommon="";
$cssrdv="";

include './view/inscription.php';
?>