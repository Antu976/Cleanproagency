<?php
// Ressources pour le header commun
$cssrdv          = "";
$csscoordonnees  = "";
$cssheader_footer = "./style/header-footer.css";
$csscommon       = "./style/common.css";
$cssrecap        = "";
$cssacceuil      = "";
$jscarousel      = "";

include './view/header.php';
?>

<main>
    <div class="page-contenu">
        <h1>À propos de nous</h1>

        <p>Clean Pro Agency est une entreprise de nettoyage basée à
           Ramonville-Saint-Agne. Nous aidons les particuliers et les professionnels
           à retrouver des espaces impeccables, sans effort de leur côté.</p>

        <h2>Nos services</h2>
        <p>Nettoyage de voiture, de canapé, de tapis, de matelas et de vitres.
           Chaque prestation est réalisée par une équipe qualifiée, avec des produits
           respectueux de l'environnement.</p>

        <h2>Nos engagements</h2>
        <p>Économie, sérénité, transparence et proximité : nous mettons un point
           d'honneur à proposer un service clair, ponctuel et de qualité, adapté à
           vos besoins.</p>

        <h2>Prendre rendez-vous</h2>
        <p>La réservation se fait en quelques clics depuis votre espace en ligne.
           <a href="rdv.php">Prenez rendez-vous dès maintenant</a>.</p>
    </div>
</main>

<?php include './view/footer.php'; ?>
