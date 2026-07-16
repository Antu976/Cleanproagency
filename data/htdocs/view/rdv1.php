<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// session_start();
?>


<main class="rdv-page">
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
                <?php
                    $optionsService = [
                        'Voiture' => 'Nettoyage de Voiture',
                        'Vitre'   => 'Nettoyage de Vitre',
                        'Canapé'  => 'Nettoyage de Canapé',
                        'Tapis'   => 'Nettoyage de Tapis',
                        'Matelas' => 'Nettoyage de Matelas',
                    ];
                    $pre = isset($preselectService) ? $preselectService : '';
                ?>
                <select id="serviceType" name="serviceType" required>
                    <?php foreach ($optionsService as $val => $label): ?>
                        <option value="<?php echo $val; ?>" <?php echo ($val === $pre) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="frequency">Fréquence :</label>
                <select id="frequency" name="frequency" required>
                    <option value="Ponctuelle">Ponctuelle</option>
                    <option value="Mensuelle">Mensuelle</option>
                    <option value="Trimestrielle">Trimestrielle</option>
                </select>

                <label for="quantity">Nombre d'articles à nettoyer :</label>
                <select id="quantity" name="quantity" required>
                    <?php for ($i = 1; $i <= 3; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>

                <label for="date">Date souhaitée :</label>
                <select id="date" name="date" required>
                    <option value="">— Choisissez une date —</option>
                    <?php foreach (($openDates ?? []) as $od): ?>
                        <option value="<?php echo $od['value']; ?>"><?php echo $od['label']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Créneau horaire :</label>
                <div id="planning" class="planning">
                    <p class="planning-hint">Choisissez d'abord une date pour voir les créneaux disponibles.</p>
                </div>
                <input type="hidden" id="time" name="time">

                <label for="additionalServices">Services supplémentaires (facultatif) :</label>
                <textarea id="additionalServices" name="additionalServices" rows="4" placeholder="Ajoutez des détails supplémentaires ici..."></textarea>
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?? ''; ?>">
                <button type="submit" name="submit">Valider</button>
            </form>

            <script>
            (function () {
                const HORAIRES = <?php echo json_encode($horaires ?? []); ?>;
                const TAKEN    = <?php echo json_encode($plannedSlots ?? []); ?>;
                const TODAY    = "<?php echo date('Y-m-d'); ?>";
                const NOWH     = <?php echo (int)date('H'); ?>;

                const dateInput = document.getElementById('date');
                const planning  = document.getElementById('planning');
                const timeField = document.getElementById('time');
                const form      = document.getElementById('appointmentForm');
                if (!dateInput) return;

                const pad = n => String(n).padStart(2, '0');

                function render() {
                    timeField.value = '';
                    planning.innerHTML = '';
                    const val = dateInput.value;
                    if (!val) {
                        planning.innerHTML = '<p class="planning-hint">Choisissez d\'abord une date.</p>';
                        return;
                    }
                    const wd = new Date(val + 'T00:00:00').getDay();
                    const h = HORAIRES[wd];
                    if (!h) {
                        planning.innerHTML = '<p class="planning-closed">Fermé ce jour-là. Ouvert du mardi au samedi.</p>';
                        return;
                    }
                    const taken = TAKEN[val] || [];
                    const grid = document.createElement('div');
                    grid.className = 'planning-grid';
                    let dispo = 0;
                    for (let hr = h[0]; hr < h[1]; hr++) {
                        const slot = pad(hr) + ':00';
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'slot';
                        btn.textContent = slot;
                        const pris  = taken.includes(slot);
                        const passe = (val === TODAY && hr <= NOWH);
                        if (pris || passe) {
                            btn.classList.add('slot--off');
                            btn.disabled = true;
                            btn.title = pris ? 'Déjà réservé' : 'Créneau passé';
                        } else {
                            dispo++;
                            btn.addEventListener('click', function () {
                                grid.querySelectorAll('.slot').forEach(s => s.classList.remove('slot--active'));
                                btn.classList.add('slot--active');
                                timeField.value = slot;
                            });
                        }
                        grid.appendChild(btn);
                    }
                    planning.appendChild(grid);
                    if (dispo === 0) {
                        planning.insertAdjacentHTML('beforeend', '<p class="planning-closed">Aucun créneau disponible ce jour. Essayez une autre date.</p>');
                    }
                }

                dateInput.addEventListener('change', render);
                form.addEventListener('submit', function (e) {
                    if (!timeField.value) {
                        e.preventDefault();
                        if (!planning.querySelector('.planning-error')) {
                            planning.insertAdjacentHTML('beforeend', '<p class="planning-closed planning-error">Veuillez sélectionner un créneau horaire.</p>');
                        }
                    }
                });
            })();
            </script>
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