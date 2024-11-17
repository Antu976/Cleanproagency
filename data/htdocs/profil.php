<?php
session_start();
// echo $_SESSION['user_email'];

include './utils/bdd.php';
include './model/profil.php';

$showUser="";



// Vérifier si l'utilisateur est connecté
if(isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    // Récupérer l'email de l'utilisateur depuis la session
    $user_email = $_SESSION['user']['email'];

    $data = showUser($bdd, $user_email);

    foreach ($data as $user){
        $showUser = $showUser."<p>Nom:  {$user['name_client']}</p>
        <p>Prénom:  {$user['prenom_client']}</p>
        <p>Email: {$user['email_client']}</p>
        <p>Téléphone: {$user['telephone']}</p>
        <p>Adresse:  {$user['adresse']}</p>
        <p>Code postale: {$user['code_postale']}</p>
        <p>Ville: {$user['ville_rdv']}</p>
        <br><br>";
    }


} else {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}




// $user_id = $_SESSION['user_id'];
// $req = $bdd->prepare("SELECT * FROM client WHERE id_client= ?");
// $req->execute([$user_id]);
// while($user=$req->fetch()){

// $data =showUser($bdd);
// // var_dump($data);
// foreach ($data as $user){
//     $showUser = $showUser."<p>Nom:  {$user['name_client']}</p>
//     <p>Prénom:  {$user['prenom_client']}</p>
//     <p>Email: {$user['email_client']}</p>
//     <p>Téléphone: {$user['telephone']}</p>
//     <p>Adresse:  {$user['adresse']}</p>
//     <p>Code postale: {$user['code_postale']}</p>
//     <p>Ville: {$user['ville_rdv']}</p>
//     <br><br>";
// }

// }




$cssacceuil="";
$jscarousel="";
$jspopup="";
$csscoordonnees="";
$cssrdv="";
$cssheader_footer="";
$csscommon="";
$cssrecap="";

include './view/profil.php';

?>