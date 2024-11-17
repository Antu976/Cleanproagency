<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// session_start();
?>



<main>
    <article>

        <h1>Vos Rendez-vous</h1>
        <!-- <p>Votre temps est précieux <br>Laissez-nous organiser votre nettoyage parfaitement</p> -->
    </article>

    <form>
        <div class="titre-form">
            <h2>Veuillez vous assurer que toutes vos informations sont correctes</h2>
        </div>

        <table>
            <th>ID</th>
            <th>service demandé</th>
            <th>Fréquence</th>
            <th>Quantité</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Services Supplémentaires</th>
    <?php
    //on recupère l'id de la personne connecter
    $user_id = $_SESSION['user_id'];
    $req = $bdd->prepare("SELECT * FROM rdv WHERE id_client= ?");
    $req->execute([$user_id]);
    while($aff=$req->fetch()){?>
            <tr>
            <td><?php echo $aff['id']; ?></td>
            <td><?php echo $aff['service_rdv']; ?></td>
            <td><?php echo $aff['frequence']; ?></td>
            <td><?php echo $aff['nbr_article']; ?></td>
            <td><?php echo $aff['date_rdv']; ?></td>
            <td><?php echo $aff['heure_rdv']; ?></td>
            <td><?php echo $aff['services_supplementaire']; ?></td>
            <td>
                <a href="Modifier.php?id=<?php echo $aff['id'] ?>">Modifier</a>
                <a href="supprimer.php?id=<?php echo $aff['id'] ?>">supprimer</a>
            </td>
        </tr>
        <?php } ?>
        </table>



        <div id="button">
            <button type="submit"><a href="rdv.php">Retour</a></button>
        </div>
    </form>


</main>