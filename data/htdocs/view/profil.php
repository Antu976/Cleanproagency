<?php
$p        = $profilData ?? [];
$prenom   = $p['prenom_client'] ?? '';
$nom      = $p['name_client'] ?? '';
$premiereLettre = function ($s) {
    $s = (string)$s;
    return function_exists('mb_substr') ? mb_substr($s, 0, 1) : substr($s, 0, 1);
};
$initiales = strtoupper($premiereLettre($prenom) . $premiereLettre($nom));

function champ($valeur) {
    $valeur = trim((string)($valeur ?? ''));
    return $valeur !== '' ? htmlspecialchars($valeur) : '—';
}
?>

<main class="profil-page">
    <section class="profil-wrap">
        <div class="profil-card">

            <div class="profil-head">
                <div class="profil-avatar">
                    <?php echo $initiales !== '' ? htmlspecialchars($initiales) : '<i class="fa-regular fa-user"></i>'; ?>
                </div>
                <div class="profil-identity">
                    <h1><?php echo htmlspecialchars(trim($prenom . ' ' . $nom)) ?: 'Mon profil'; ?></h1>
                    <p class="profil-sub"><?php echo champ($p['email_client'] ?? ''); ?></p>
                </div>
            </div>

            <div class="profil-info">
                <div class="info-row">
                    <span class="info-label"><i class="fa-regular fa-envelope"></i> Email</span>
                    <span class="info-value"><?php echo champ($p['email_client'] ?? ''); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fa-solid fa-phone"></i> Téléphone</span>
                    <span class="info-value"><?php echo champ($p['telephone'] ?? ''); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fa-solid fa-location-dot"></i> Adresse</span>
                    <span class="info-value"><?php echo champ($p['adresse'] ?? ''); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fa-solid fa-envelopes-bulk"></i> Code postal</span>
                    <span class="info-value"><?php echo champ($p['code_postale'] ?? ''); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fa-solid fa-city"></i> Ville</span>
                    <span class="info-value"><?php echo champ($p['ville_rdv'] ?? ''); ?></span>
                </div>
            </div>

            <div class="profil-actions">
                <a href="recap.php" class="hero-btn hero-btn--primary"><i class="fa-regular fa-calendar-check"></i> Vos rendez-vous</a>
                <a href="deconnexion.php" class="profil-logout"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
            </div>

        </div>
    </section>
</main>
