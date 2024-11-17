

<style>
section{
    margin-top:5%
}
</style>

<section>
<div class="formulaire">
    <div class="titre-form">
        <h1>Veuillez modifier votre Rendez-vous </h1>
    </div>
    <form id="appointmentForm" action="" method="POST">
        <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id">
        <label for="serviceType">Type de Service :</label>
        <select id="serviceType" name="serviceType" required>
        <?php if (isset($mod) && isset($mod['service_rdv'])) : ?>
            <option value="<?php echo $mod['service_rdv']; ?>">Nettoyage de Voiture</option>
            <option value="<?php echo $mod['service_rdv']; ?>">Nettoyage de Canapé</option>
            <option value="<?php echo $mod['service_rdv']; ?>">Nettoyage de Tapis</option>
            <option value="<?php echo $mod['service_rdv']; ?>">Nettoyage de Matelas</option>
            <?php endif; ?>
        </select>

        <label for="frequency">Fréquence :</label>
        <select id="frequency" name="frequency" required>
        <?php if (isset($mod) && isset($mod['frequence'])) : ?>
            <option value="<?php echo $mod['frequence']; ?>">Ponctuelle</option>
            <option value="<?php echo $mod['frequence']; ?>">Mensuelle</option>
            <option value="<?php echo $mod['frequence']; ?>">Trimestrielle</option>
            <?php endif; ?>
        </select>

        <label for="quantity">Nombre d'Articles à Nettoyer :</label>
        <?php if (isset($mod) && isset($mod['nbr_article'])) : ?>
        <input type="number" id="quantity" name="quantity" min="1" value="<?php echo $mod['nbr_article']; ?>" required>
        <?php endif; ?>

        <label for="date">Date souhaitée :</label>
        <?php if (isset($mod) && isset($mod['date_rdv'])) : ?>
        <input value="<?php echo $mod['date_rdv']; ?>" type="date" id="date" name="date" required>
        <?php endif; ?>

        <label for="time">Heure souhaitée :</label>
        <?php if (isset($mod) && isset($mod['heure_rdv'])) : ?>
        <input value="<?php echo $mod['heure_rdv']; ?>" type="time" id="time" name="time" required>
        <?php endif; ?>

        <label for="additionalServices">Services Supplémentaires :</label>
        <?php if (isset($mod) && isset($mod['services_supplementaire'])) : ?>
        <textarea value="<?php echo $mod['services_supplementaire']; ?>" id="additionalServices" name="additionalServices" rows="4" placeholder="Ajoutez des détails supplémentaires ici..."></textarea>
        <?php endif; ?>
        <button type="submit" name="modifier">Suivant</button>
    </form>
</div>

   <!------------------------------------------- le carousel---------------------------------------------->

        <!-- conteneur principal pour le carrousel  qui va permettre de styliser et positionner le carousel sur la page-->
        <div class="container">
            <!-- l'élement carrousel spécifie l'elment lui même qui va contenir les diapositives ainsi que les controles -->
            <div class="carousel">
                <!-- conteneur interne pour les diapositives  permet de groupes les diapositives-->
                <div class="carousel-inner">
                    <!-- Première diapositive -->
                    <div class="slide">
                        <img src="img/Nettoyage Carte1/1.png" alt="la Première">
                    </div>
                    <!-- Deuxième diapositive -->
                    <div class="slide">
                        <img src="img/Nettoyage Carte1/2.png" alt="la Deuxième">
                    </div>
                    <!-- troisième diapositive -->
                    <div class="slide">
                        <img src="img/Nettoyage Carte1/3.png" alt="la troisième">
                    </div>
                </div>
                <!-- conteneur pour les boutons de naviagtion  -->
                <div class="carousel-controls">
                    <!-- Bouton pour passer à la diapositive précédente -->
                    <button id="prev"><i class="fa-solid fa-circle-chevron-left"></i></i></button>
                    <!-- Boutton pour passer à la diapostive suivante -->
                    <button id="next"><i class="fa-solid fa-circle-chevron-right"></i></button>
                </div>
                <div class="carousel-dots"></div>
            </div>
        </div>
    </section>