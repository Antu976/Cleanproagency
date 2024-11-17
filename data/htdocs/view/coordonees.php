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
    
            <div class="container-formulaire">
                <div class="titre-container-formulaire">
                    <h1>Veuillez renseigner vos coordonnées, s'il vous plaît ?</h1>
                </div>
                <form id="appointmentForm" action=" coordonnees.php" method="post">
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="name" required>

                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>

                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone">Téléphone :</label>
                    <input type="tel" id="phone" name="phone" required>

                    <label for="prenom">Adresse:</label>
                    <input type="text" id="Adresse" name="Adresse">

                    <label for="code">Code postale :</label>
                    <input type="number" id="code" name="code">

                    <label for="ville">ville:</label>
                    <input type="text" id="ville" name="ville">
                    <div id="button">
                        <button type="submit"><a href="RDV1.html">Retour</a></button>
                        <button type="submit" name="userSubmit" >Suivant</button>
                    </div>
                    <p id="page">2/2</p>
                </form>
                <p class="messagephp"><?php echo $message ?></p>
       
            <?php echo $showUsers ?>
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

