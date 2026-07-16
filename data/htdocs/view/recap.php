<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<main class="recap-page">
    <article>
        <h1>Vos rendez-vous</h1>
        <p>Retrouvez, modifiez ou annulez vos réservations en un clic.</p>
    </article>

    <section class="recap-wrap">
        <?php
        // On récupère les rendez-vous de la personne connectée
        $user_id = $_SESSION['user_id'];
        $req = $bdd->prepare("SELECT * FROM rdv WHERE id_client = ?");
        $req->execute([$user_id]);
        $rdvs = $req->fetchAll();
        ?>

        <?php if (empty($rdvs)): ?>
            <div class="recap-empty">
                <i class="fa-regular fa-calendar-xmark"></i>
                <h2>Aucun rendez-vous pour le moment</h2>
                <p>Vous n'avez pas encore de réservation à votre nom.</p>
            </div>
        <?php else: ?>
            <div class="recap-grid">
                <?php foreach ($rdvs as $aff): ?>
                    <article class="rdv-card">
                        <div class="rdv-card-head">
                            <span class="rdv-service"><i class="fa-solid fa-broom"></i> <?php echo $aff['service_rdv']; ?></span>
                            <span class="rdv-id">#<?php echo $aff['id']; ?></span>
                        </div>

                        <div class="rdv-meta">
                            <span class="rdv-badge"><i class="fa-regular fa-calendar"></i> <?php echo $aff['date_rdv']; ?></span>
                            <span class="rdv-badge"><i class="fa-regular fa-clock"></i> <?php echo $aff['heure_rdv']; ?></span>
                            <span class="rdv-badge"><i class="fa-solid fa-repeat"></i> <?php echo $aff['frequence']; ?></span>
                            <span class="rdv-badge"><i class="fa-solid fa-layer-group"></i> <?php echo $aff['nbr_article']; ?> article(s)</span>
                        </div>

                        <?php if (!empty(trim($aff['services_supplementaire'] ?? ''))): ?>
                            <p class="rdv-note"><i class="fa-solid fa-circle-info"></i> <?php echo $aff['services_supplementaire']; ?></p>
                        <?php endif; ?>

                        <div class="rdv-actions">
                            <a class="rdv-btn rdv-btn--edit" href="modifier.php?id=<?php echo $aff['id']; ?>"><i class="fa-solid fa-pen"></i> Modifier</a>
                            <a class="rdv-btn rdv-btn--del" href="supprimer.php?id=<?php echo $aff['id']; ?>" onclick="return confirm('Supprimer définitivement ce rendez-vous ?');"><i class="fa-solid fa-trash"></i> Supprimer</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="recap-back">
            <a href="rdv.php" class="hero-btn hero-btn--primary"><i class="fa-solid fa-plus"></i> Nouveau rendez-vous</a>
        </div>
    </section>
</main>
