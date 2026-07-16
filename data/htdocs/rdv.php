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

   








// Réserver exige un compte : on redirige AVANT le formulaire,
// pour ne pas remplir le formulaire pour rien.
$user_email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : null;
if(!$user_email) {
    // On mémorise la destination (avec le service choisi) pour y revenir après connexion
    $_SESSION['redirect_after_login'] = 'rdv.php' . (isset($_GET['service']) ? '?service=' . urlencode($_GET['service']) : '');
    header('Location: connexion.php');
    exit;
}

// Horaires d'ouverture : jour de la semaine (0=dim ... 6=sam) => [heure début, heure fin]
$horaires = [
    2 => [8, 20],  // mardi
    3 => [8, 20],  // mercredi
    4 => [8, 20],  // jeudi
    5 => [8, 20],  // vendredi
    6 => [9, 21],  // samedi
];

// Génère les créneaux (1h) proposés pour une date donnée
function creneauxDuJour($date, $horaires) {
    $ts = strtotime($date);
    if ($ts === false) return [];
    $jour = (int)date('w', $ts);
    if (!isset($horaires[$jour])) return [];
    list($debut, $fin) = $horaires[$jour];
    $slots = [];
    for ($h = $debut; $h < $fin; $h++) {
        $slots[] = sprintf('%02d:00', $h);
    }
    return $slots;
}

// Traitement du formulaire de rendez-vous s'il a été soumis
if(isset($_POST['submit'])) {
    // Champs obligatoires (les services supplémentaires sont facultatifs)
    if(!empty($_POST['serviceType']) && !empty($_POST['frequency'])
        && !empty($_POST['quantity']) && !empty($_POST['date'])
        && !empty($_POST['time']) && !empty($_POST['user_id'])) {

        // Nettoyage des données du formulaire
        $serviceType        = htmlentities(strip_tags(trim($_POST['serviceType'])));
        $frequency          = htmlentities(strip_tags(trim($_POST['frequency'])));
        $quantity           = (int)$_POST['quantity'];
        $date               = htmlentities(strip_tags(trim($_POST['date'])));
        $time               = substr(htmlentities(strip_tags(trim($_POST['time']))), 0, 5);
        $additionalServices = htmlentities(strip_tags(trim($_POST['additionalServices'] ?? '')));
        $user_id            = htmlentities(strip_tags(trim($_POST['user_id'])));

        // Validations : on empêche toute saisie invalide
        $erreurs = [];
        $aujourdhui = date('Y-m-d');

        if ($quantity < 1 || $quantity > 10) {
            $erreurs[] = "La quantité doit être comprise entre 1 et 10.";
        }
        if ($date < $aujourdhui) {
            $erreurs[] = "La date choisie est déjà passée.";
        }

        $slots = creneauxDuJour($date, $horaires);
        if (empty($slots)) {
            $erreurs[] = "Nous sommes fermés ce jour-là (ouvert du mardi au samedi).";
        } elseif (!in_array($time, $slots, true)) {
            $erreurs[] = "Le créneau horaire choisi n'est pas valide.";
        } else {
            // Créneau déjà passé pour aujourd'hui ?
            if ($date === $aujourdhui && (int)substr($time, 0, 2) <= (int)date('H')) {
                $erreurs[] = "Ce créneau est déjà passé pour aujourd'hui.";
            }
            // Créneau déjà réservé ?
            $chk = $bdd->prepare("SELECT COUNT(*) FROM rdv WHERE date_rdv = ? AND LEFT(heure_rdv, 5) = ?");
            $chk->execute([$date, $time]);
            if ($chk->fetchColumn() > 0) {
                $erreurs[] = "Ce créneau est déjà réservé, merci d'en choisir un autre.";
            }
        }

        if (empty($erreurs)) {
            $message = rdv($serviceType, $frequency, $quantity, $date, $time, $additionalServices, $user_email, $user_id, $bdd);
        } else {
            $message = implode(' ', $erreurs);
        }
    } else {
        $message = "Veuillez remplir tous les champs obligatoires.";
    }
}



$actionRdv="rdv.php";

// Service pré-sélectionné depuis une page service (rdv.php?service=...)
$preselectService = isset($_GET['service']) ? htmlentities(strip_tags(trim($_GET['service']))) : '';

// Créneaux déjà réservés (à partir d'aujourd'hui) pour griser le planning
$plannedSlots = [];
try {
    $q = $bdd->query("SELECT date_rdv, LEFT(heure_rdv, 5) AS h FROM rdv WHERE date_rdv >= CURDATE()");
    foreach ($q as $row) {
        $plannedSlots[$row['date_rdv']][] = $row['h'];
    }
} catch (Exception $e) {
    $plannedSlots = [];
}

// Liste des prochaines dates OUVRÉES (mardi au samedi) proposées dans le formulaire
$joursFr = ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'];
$moisFr  = [1 => 'janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
$openDates = [];
$cur = new DateTime('today');
$garde = 0;
while (count($openDates) < 30 && $garde < 120) {
    $w = (int)$cur->format('w');
    if (isset($horaires[$w])) {
        $openDates[] = [
            'value' => $cur->format('Y-m-d'),
            'label' => $joursFr[$w] . ' ' . $cur->format('j') . ' ' . $moisFr[(int)$cur->format('n')] . ' ' . $cur->format('Y'),
        ];
    }
    $cur->modify('+1 day');
    $garde++;
}





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