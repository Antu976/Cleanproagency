<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Clean Pro Agency — services de nettoyage à Ramonville-Saint-Agne : voiture, canapé, tapis, matelas, vitres. Prenez rendez-vous en ligne.">
    <title>Clean Pro Agency — Nettoyage & prise de rendez-vous</title>
    <link rel="icon" href="img/flavicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cfd316f793.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href=<?php echo $cssrdv ?>>
    <link rel="stylesheet" href=<?php echo $csscoordonnees ?>>
    <link rel="stylesheet" href=<?php echo $cssheader_footer ?>>
    <link rel="stylesheet" href=<?php echo $csscommon ?>>
    <link rel="stylesheet" href=<?php echo $cssrecap ?>>
    <link rel="stylesheet" href=<?php echo $cssacceuil ?>>
    <link rel="stylesheet" href="style/theme.css">
    <script src=<?php echo $jscarousel ?> defer></script>
</head>

<body>
    
    <header>
        <!-- Barre utilitaire -->
        <div class="topbar">
            <div class="topbar-inner">
                <span class="topbar-item"><i class="fa-regular fa-clock"></i> Mar–Ven : 8h–20h · Sam : 9h–21h</span>
                <a class="topbar-item" href="#footer"><i class="fa-solid fa-location-dot"></i> Ramonville-Saint-Agne</a>
                <a class="topbar-item topbar-contact" href="#footer"><i class="fa-solid fa-phone-volume"></i> Nous contacter</a>
            </div>
        </div>

        <!-- Navbar -->
        <nav id="nav">

            <a href="index.php" class="brand"><img src="./img/logo.png" alt="Clean Pro Agency"></a>

            <ul>
                <li>
                    <a href="index.php">Accueil</a>
                </li>

                <li>
                    <a href="service.php?s=voiture">Lavage Automobile</a>
                </li>

                <li>
                    <a href="service.php?s=vitre">Nettoyage Vitre</a>
                </li>

                <li>
                    <a href="service.php?s=canape">Nettoyage Canapé</a>
                </li>

                <li>
                    <a href="service.php?s=tapis">Nettoyage Tapis </a>
                </li>
                <li>
                    <a href="service.php?s=matelas">Nettoyage Matelas</a>
                </li>
                <li class="nav-cta-li">
                    <a href="rdv.php" class="nav-cta">Prendre RDV</a>
                </li>
                <!---------------------- Profil --------------------------------->
                <li>
                    <a href="profil.php" id="profil"><i class="fa-regular fa-circle-user fa-xl" style="color: #F6CB5B;"></i></a>
                </li>
            </ul>
            <a class="contact2" href="#footer"> <i class="fa-solid fa-phone-volume"
                style="color: #F6CB5B;"></i> Nous Contacter</a>
            <div id="icons"></div>

        </nav>

        <!--------------------------------------------Navbar------------------------------------>

        <!-------------------------------------------------Header------------------------------->
    </header>

    <script>
    const links = document.querySelectorAll("nav li");

icons.addEventListener("click", () => {
    nav.classList.toggle("active");
});

links.forEach((link) => {
    link.addEventListener("click", () => {
        nav.classList.remove("active");
    });
});
</script>