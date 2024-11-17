<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prise de Rendez-vous</title>
    <link rel="icon" href="img/flavicon.png" type="flavicon">
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
    <script src=<?php echo $jscarousel ?> defer></script>
</head>

<body>
    
    <header>
        <!-------------------------------------------------Header------------------------------>
        <a class="contact" href="profil.html"> <i class="fa-solid fa-phone-volume" style="color: #F6CB5B;"></i> Nous Contacter</a>
        <!-------------------------------------------Navbar------------------------------------>
        <nav id=nav>

            <img src="./img/logo.png" alt="logo">

            <ul>
                <li>
                    <a href="index.php">Accueil</a>
                </li>

                <li>
                    <a href="#">Lavage Automobile</a>
                </li>

                <li>
                    <a href="#">Nettoyage Vitre</a>
                </li>

                <li>
                    <a href="#">Nettoyage Canapé</a>
                </li>

                <li>
                    <a href="#">Nettoyage Tapis </a>
                </li>
                <li>
                    <a href="#">Nettoyage Matelas</a>
                </li>
                <!---------------------- Profile dropdown --------------------------------->
                <li>
                    <a href="profil.php" id="profil"><i class="fa-regular fa-circle-user fa-xl" style="color: #F6CB5B;"></i></a>
                </li>
            </ul>
            <a class="contact2" href="profil.html" target="_blank"> <i class="fa-solid fa-phone-volume"
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