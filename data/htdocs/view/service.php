<main class="service-page">

    <!-- Bannière du service -->
    <section class="svc-hero">
        <div class="svc-hero-inner">
            <nav class="svc-breadcrumb">
                <a href="index.php">Accueil</a> <span>/</span> <span>Services</span>
                <span>/</span> <strong><?php echo $service['titre']; ?></strong>
            </nav>
            <h1><?php echo $service['titre']; ?></h1>
            <p><?php echo $service['intro']; ?></p>
            <div class="svc-hero-actions">
                <a class="hero-btn hero-btn--primary" href="rdv.php?service=<?php echo urlencode($service['value']); ?>">Réserver ce service</a>
                <a class="hero-btn hero-btn--ghost" href="rdv.php?service=<?php echo urlencode($service['value']); ?>">Demander un devis</a>
            </div>
        </div>
    </section>

    <!-- Détail du service -->
    <section class="svc-body">
        <div class="svc-content">
            <h2>En quoi consiste la prestation ?</h2>
            <p><?php echo $service['description']; ?></p>

            <ul class="svc-atouts">
                <?php foreach ($service['atouts'] as $atout): ?>
                    <li><i class="fa-solid fa-circle-check"></i> <?php echo $atout; ?></li>
                <?php endforeach; ?>
            </ul>

            <p class="svc-prix"><?php echo $service['prix']; ?></p>
            <a class="hero-btn hero-btn--primary" href="rdv.php?service=<?php echo urlencode($service['value']); ?>">Réserver ce service</a>
        </div>

        <?php if (!empty($service['image'])): ?>
            <div class="svc-media">
                <img src="<?php echo $service['image']; ?>" alt="<?php echo $service['titre']; ?>">
            </div>
        <?php endif; ?>
    </section>

    <!-- Autres services -->
    <section class="svc-others">
        <h2 class="section-title">Nos autres services</h2>
        <div class="svc-others-grid">
            <?php foreach ($services as $key => $s): ?>
                <?php if ($key === $serviceSlug) continue; ?>
                <a class="svc-chip" href="service.php?s=<?php echo $key; ?>">
                    <?php echo $s['titre']; ?> <i class="fa-solid fa-arrow-right"></i>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

</main>
