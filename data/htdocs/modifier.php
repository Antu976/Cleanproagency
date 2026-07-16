<?php
session_start();
include './utils/bdd.php';

// Gérer un rendez-vous exige d'être connecté
if (!isset($_SESSION['user']['email'])) {
    header('Location: connexion.php');
    exit;
}

$messageMod = "";

// Horaires d'ouverture : jour (0=dim ... 6=sam) => [début, fin]
$horaires = [2 => [8, 20], 3 => [8, 20], 4 => [8, 20], 5 => [8, 20], 6 => [9, 21]];

function creneauxDuJour($date, $horaires) {
    $ts = strtotime($date);
    if ($ts === false) return [];
    $jour = (int)date('w', $ts);
    if (!isset($horaires[$jour])) return [];
    list($debut, $fin) = $horaires[$jour];
    $slots = [];
    for ($h = $debut; $h < $fin; $h++) $slots[] = sprintf('%02d:00', $h);
    return $slots;
}

// Rendez-vous à modifier
$id  = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$mod = [];
if ($id > 0) {
    $req = $bdd->prepare("SELECT * FROM rdv WHERE id = ?");
    $req->execute([$id]);
    $mod = $req->fetch() ?: [];
}

// Traitement de la modification
if (isset($_POST['modifier'])) {
    if (!empty($_POST['serviceType']) && !empty($_POST['frequency'])
        && !empty($_POST['quantity']) && !empty($_POST['date'])
        && !empty($_POST['time']) && !empty($_POST['id'])) {

        $serviceType        = htmlentities(strip_tags(trim($_POST['serviceType'])));
        $frequency          = htmlentities(strip_tags(trim($_POST['frequency'])));
        $quantity           = (int)$_POST['quantity'];
        $date               = htmlentities(strip_tags(trim($_POST['date'])));
        $time               = substr(htmlentities(strip_tags(trim($_POST['time']))), 0, 5);
        $additionalServices = htmlentities(strip_tags(trim($_POST['additionalServices'] ?? '')));
        $idPost             = (int)$_POST['id'];

        $erreurs = [];
        $aujourdhui = date('Y-m-d');

        if ($quantity < 1 || $quantity > 10) $erreurs[] = "La quantité doit être comprise entre 1 et 10.";
        if ($date < $aujourdhui) $erreurs[] = "La date choisie est déjà passée.";

        $slots = creneauxDuJour($date, $horaires);
        if (empty($slots)) {
            $erreurs[] = "Nous sommes fermés ce jour-là (ouvert du mardi au samedi).";
        } elseif (!in_array($time, $slots, true)) {
            $erreurs[] = "Le créneau horaire choisi n'est pas valide.";
        } else {
            if ($date === $aujourdhui && (int)substr($time, 0, 2) <= (int)date('H')) {
                $erreurs[] = "Ce créneau est déjà passé pour aujourd'hui.";
            }
            // Déjà pris par un AUTRE rendez-vous ?
            $chk = $bdd->prepare("SELECT COUNT(*) FROM rdv WHERE date_rdv = ? AND LEFT(heure_rdv, 5) = ? AND id <> ?");
            $chk->execute([$date, $time, $idPost]);
            if ($chk->fetchColumn() > 0) $erreurs[] = "Ce créneau est déjà réservé, merci d'en choisir un autre.";
        }

        if (empty($erreurs)) {
            try {
                $up = $bdd->prepare("UPDATE rdv SET service_rdv=?, frequence=?, nbr_article=?, date_rdv=?, heure_rdv=?, services_supplementaire=? WHERE id=?");
                $up->execute([$serviceType, $frequency, $quantity, $date, $time, $additionalServices, $idPost]);
                header("Location: recap.php");
                exit;
            } catch (Exception $e) {
                $messageMod = "Erreur lors de la modification.";
            }
        } else {
            $messageMod = implode(' ', $erreurs);
        }
    } else {
        $messageMod = "Veuillez remplir tous les champs obligatoires.";
    }
}

// Créneaux déjà réservés (hors ce rendez-vous) pour griser le planning
$plannedSlots = [];
try {
    $q = $bdd->prepare("SELECT date_rdv, LEFT(heure_rdv, 5) AS h FROM rdv WHERE date_rdv >= CURDATE() AND id <> ?");
    $q->execute([$id]);
    foreach ($q as $row) $plannedSlots[$row['date_rdv']][] = $row['h'];
} catch (Exception $e) {
    $plannedSlots = [];
}

// Dates ouvrées proposées (+ la date actuelle du RDV si nécessaire)
$joursFr = ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'];
$moisFr  = [1 => 'janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
function formaterDate($d, $joursFr, $moisFr) {
    $ts = strtotime($d);
    if ($ts === false) return $d;
    return $joursFr[(int)date('w', $ts)] . ' ' . date('j', $ts) . ' ' . $moisFr[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}
$openDates = [];
$cur = new DateTime('today');
$garde = 0;
while (count($openDates) < 30 && $garde < 120) {
    $w = (int)$cur->format('w');
    if (isset($horaires[$w])) {
        $openDates[] = ['value' => $cur->format('Y-m-d'), 'label' => formaterDate($cur->format('Y-m-d'), $joursFr, $moisFr)];
    }
    $cur->modify('+1 day');
    $garde++;
}
$dateActuelle = $mod['date_rdv'] ?? '';
if ($dateActuelle !== '') {
    $dejaLa = false;
    foreach ($openDates as $od) { if ($od['value'] === $dateActuelle) { $dejaLa = true; break; } }
    if (!$dejaLa) {
        array_unshift($openDates, ['value' => $dateActuelle, 'label' => formaterDate($dateActuelle, $joursFr, $moisFr) . ' (actuel)']);
    }
}

$cssacceuil       = "";
$jscarousel       = "./script/carousel.js";
$jspopup          = "";
$csscoordonnees   = "";
$cssheader_footer = "./style/header-footer.css";
$csscommon        = "./style/common.css";
$cssrecap         = "";
$cssrdv           = "./style/rdv.css";
include './view/header.php';
include './view/modifier.php';
include './view/footer.php';
?>
