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
    <title>Document</title>
    <link rel="stylesheet" href="./style/connexion.css">

</head>
<body>
    <h1>Clean Pro Agency</h1>
    <section>
        <img src="./img/connexionphoto2.png" alt="connexionphoto">

    <form action="<?php echo $actionCreateUser ?>" method="POST">
        <h2>Inscription</h2>
    <input type="text" name="lastNameAdd" placeholder="Votre Nom"  autocomplete="off" required>
    <input type="text" name="firstNameAdd" placeholder="Votre Prénom"  autocomplete="off" required>
    <input type="email" name="emailAdd" placeholder="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  autocomplete="off" required>
    <input type="tel"  name="numberPhoneAdd" placeholder="Votre numero de téléphone " autocomplete="off" required>
    <input type="text" name="adresseAdd" placeholder="Votre adresse postale " autocomplete="off"required>
    <input type="number" name="codePostalAdd" placeholder="Code postale " autocomplete="off" required>
    <input type="text" name="cityAdd" placeholder="Ville " autocomplete="off" required>
    <input type="password" name="passwordAdd" placeholder="Votre Mot de Passe" autocomplete="off"  required>

    <input type="submit" name="submitAddUser" class="sincrire">

    <div class="retour_connexion"><a href="connexion.php" >Vous avez déjà un compte</a></div>
    <p id="messageAddUser"><?php echo $messageAddUser ?></p>
    <p><?php echo  $errorin ?></p>
    </form>
    </section>
   
    
    <footer>
        <div class="square"></div>
    </footer>
</body>

</html>

