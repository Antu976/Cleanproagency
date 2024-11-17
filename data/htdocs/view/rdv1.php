<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// session_start();
?>


<main>
    <article>
        <h1>Prise de Rendez-vous</h1>
        <p>Votre temps est précieux <br>Laissez-nous organiser votre nettoyage parfaitement</p>
    </article>


    <section>
        <div class="formulaire">
            <div class="titre-form">
                <h1>Veuillez renseigner le service souhaité</h1>
            </div>
            <form id="appointmentForm" action="<?php echo $actionRdv ?>" method="POST">
                <label for="serviceType">Type de Service :</label>
                <select id="serviceType" name="serviceType" required>
                    <option value="Voiture">Nettoyage de Voiture</option>
                    <option value="Canapé">Nettoyage de Canapé</option>
                    <option value="Tapis">Nettoyage de Tapis</option>
                    <option value="Matelas">Nettoyage de Matelas</option>
                </select>

                <label for="frequency">Fréquence :</label>
                <select id="frequency" name="frequency" required>
                    <option value="Ponctuelle">Ponctuelle</option>
                    <option value="Mensuelle">Mensuelle</option>
                    <option value="Trimestrielle">Trimestrielle</option>
                </select>

                <label for="quantity">Nombre d'Articles à Nettoyer :</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" required>

                <label for="date">Date souhaitée :</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Heure souhaitée :</label>
                <input type="time" id="time" name="time" required>

                <label for="additionalServices">Services Supplémentaires :</label>
                <textarea id="additionalServices" name="additionalServices" rows="4" placeholder="Ajoutez des détails supplémentaires ici..."></textarea>
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <button type="submit" name="submit">Valider</button>
            </form>     
            <p class="messagephp"><?php echo $message ?></p>
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


</main>