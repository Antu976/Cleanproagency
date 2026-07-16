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
        <h1>Mentions légales</h1>

        <h2>Éditeur du site</h2>
        <p>Clean Pro Agency<br>
           11 Avenue de l'Europe, 31520 Ramonville-Saint-Agne, France</p>

        <h2>Contact</h2>
        <p>Pour toute question, retrouvez nos coordonnées en bas de page ou via la
           page de contact.</p>

        <h2>Hébergement</h2>
        <p>Ce site est hébergé par l'hébergeur choisi par Clean Pro Agency.</p>

        <h2>Propriété intellectuelle</h2>
        <p>L'ensemble des contenus (textes, images, logo) présents sur ce site est la
           propriété de Clean Pro Agency, sauf mention contraire. Toute reproduction
           sans autorisation est interdite.</p>

        <h2>Données personnelles</h2>
        <p>Les informations recueillies via les formulaires servent uniquement à la
           gestion de vos rendez-vous. Conformément au RGPD, vous disposez d'un droit
           d'accès, de rectification et de suppression de vos données.</p>
    </div>
</main>

<?php include './view/footer.php'; ?>