<main class="rdv-page">
    <article>
        <h1>Modifier le rendez-vous</h1>
        <p>Mettez à jour les informations de votre réservation.</p>
    </article>

    <section>
        <div class="formulaire">
            <div class="titre-form">
                <h1>Veuillez modifier votre rendez-vous</h1>
            </div>

            <?php
                $curService = $mod['service_rdv'] ?? '';
                $curFreq    = $mod['frequence'] ?? '';
                $curQty     = (int)($mod['nbr_article'] ?? 1);
                $curDate    = $mod['date_rdv'] ?? '';
                $curTime    = isset($mod['heure_rdv']) ? substr($mod['heure_rdv'], 0, 5) : '';
                $curNote    = $mod['services_supplementaire'] ?? '';
                $optionsService = [
                    'Voiture' => 'Nettoyage de Voiture',
                    'Vitre'   => 'Nettoyage de Vitre',
                    'Canapé'  => 'Nettoyage de Canapé',
                    'Tapis'   => 'Nettoyage de Tapis',
                    'Matelas' => 'Nettoyage de Matelas',
                ];
                $optionsFreq = ['Ponctuelle', 'Mensuelle', 'Trimestrielle'];
            ?>

            <form id="appointmentForm" action="modifier.php" method="POST">
                <input type="hidden" name="id" value="<?php echo isset($mod['id']) ? (int)$mod['id'] : (int)($_GET['id'] ?? 0); ?>">

                <label for="serviceType">Type de service :</label>
                <select id="serviceType" name="serviceType" required>
                    <?php foreach ($optionsService as $val => $label): ?>
                        <option value="<?php echo $val; ?>" <?php echo ($val === $curService) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="frequency">Fréquence :</label>
                <select id="frequency" name="frequency" required>
                    <?php foreach ($optionsFreq as $f): ?>
                        <option value="<?php echo $f; ?>" <?php echo ($f === $curFreq) ? 'selected' : ''; ?>><?php echo $f; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="quantity">Nombre d'articles à nettoyer :</label>
                <select id="quantity" name="quantity" required>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo ($i === $curQty) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>

                <label for="date">Date souhaitée :</label>
                <select id="date" name="date" required>
                    <?php foreach (($openDates ?? []) as $od): ?>
                        <option value="<?php echo $od['value']; ?>" <?php echo ($od['value'] === $curDate) ? 'selected' : ''; ?>><?php echo $od['label']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Créneau horaire :</label>
                <div id="planning" class="planning"></div>
                <input type="hidden" id="time" name="time" value="<?php echo htmlspecialchars($curTime); ?>">

                <label for="additionalServices">Services supplémentaires (facultatif) :</label>
                <textarea id="additionalServices" name="additionalServices" rows="4" placeholder="Ajoutez des détails supplémentaires ici..."><?php echo htmlspecialchars($curNote); ?></textarea>

                <button type="submit" name="modifier">Enregistrer</button>
            </form>
            <p class="messagephp"><?php echo $messageMod ?? ''; ?></p>
        </div>

        <!-- Carrousel -->
        <div class="container">
            <div class="carousel">
                <div class="carousel-inner">
                    <div class="slide"><img src="img/Nettoyage Carte1/1.png" alt="la Première"></div>
                    <div class="slide"><img src="img/Nettoyage Carte1/2.png" alt="la Deuxième"></div>
                    <div class="slide"><img src="img/Nettoyage Carte1/3.png" alt="la troisième"></div>
                </div>
                <div class="carousel-controls">
                    <button id="prev"><i class="fa-solid fa-circle-chevron-left"></i></button>
                    <button id="next"><i class="fa-solid fa-circle-chevron-right"></i></button>
                </div>
                <div class="carousel-dots"></div>
            </div>
        </div>
    </section>

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

        let wanted = timeField.value; // créneau souhaité (pré-rempli avec l'actuel)
        const pad = n => String(n).padStart(2, '0');

        function render() {
            planning.innerHTML = '';
            const val = dateInput.value;
            if (!val) { planning.innerHTML = '<p class="planning-hint">Choisissez une date.</p>'; timeField.value = ''; return; }
            const wd = new Date(val + 'T00:00:00').getDay();
            const h = HORAIRES[wd];
            if (!h) { planning.innerHTML = '<p class="planning-closed">Fermé ce jour-là.</p>'; timeField.value = ''; return; }
            const taken = TAKEN[val] || [];
            const grid = document.createElement('div');
            grid.className = 'planning-grid';
            let matched = false;
            for (let hr = h[0]; hr < h[1]; hr++) {
                const slot = pad(hr) + ':00';
                const btn = document.createElement('button');
                btn.type = 'button'; btn.className = 'slot'; btn.textContent = slot;
                const pris  = taken.includes(slot);
                const passe = (val === TODAY && hr <= NOWH);
                if (pris || passe) {
                    btn.classList.add('slot--off'); btn.disabled = true;
                    btn.title = pris ? 'Déjà réservé' : 'Créneau passé';
                } else {
                    btn.addEventListener('click', function () {
                        grid.querySelectorAll('.slot').forEach(s => s.classList.remove('slot--active'));
                        btn.classList.add('slot--active');
                        wanted = slot; timeField.value = slot;
                    });
                    if (slot === wanted) { btn.classList.add('slot--active'); timeField.value = slot; matched = true; }
                }
                grid.appendChild(btn);
            }
            planning.appendChild(grid);
            if (!matched) timeField.value = '';
        }

        dateInput.addEventListener('change', render);
        render();

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
</main>
