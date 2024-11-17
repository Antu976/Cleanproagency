<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/profil.css">
</head>

<body>
    <div class="header">
        <a href="">
            <h1>Mon Profil</h1>
        </a>
        <a href="recap.php">
            <button class="recap"> Vos Rendez-vous</button>
        </a>
    </div>


    <section>
        <p><?php echo $showUser ?></p>

        <a href="deconnexion.php">
            <button> Déconnexion</button>
        </a>
    </section>


</body>

</html>