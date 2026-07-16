<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    //j'active la superglobal SESSION
    // session_start();
    
//    //Je me déco en supprimant ma superglobal SESSION
//    session_destroy();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Clean Pro Agency</title>
    <link rel="icon" href="img/flavicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/connexion.css">
    <link rel="stylesheet" href="./style/theme.css">
</head>
<body>

    <h1>Clean Pro Agency</h1>
    <section>
        <img src="./img/connexionphoto2.png" alt="connexionphoto">

        
        <form action="<?php echo $actionconnexion ?>" method="POST">
        <h2>Connexion</h2>
            <input type="email" name="emailAdd" placeholder="Votre Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  autocomplete="off" required>
            <input type="password" name="passwordAdd" placeholder="Votre Mot de Passe" autocomplete="off" required>
            <button type="submit" name="submitConnexion" class="connecter">Se connecter</button>

            <a href="inscription.php" class="inscription">Créer un nouveau compte</a>

            <p class="errorMessage"><?php echo $messageConnexion ?>
            <?php echo  $error ?></p>
        </form>

      
    </section>

    <footer>
        <div class="square"></div>
    </footer>
</body>
</html>