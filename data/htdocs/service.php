<?php
session_start();
include './utils/bdd.php';

// Contenu de chaque service (clé = slug utilisé dans l'URL ?s=...)
$services = [
    'voiture' => [
        'titre'       => 'Lavage automobile',
        'value'       => 'Voiture',
        'image'       => 'img/voiture.jpg',
        'intro'       => "Un intérieur de voiture sain et impeccable : sièges, moquettes et plastiques comme au premier jour.",
        'description' => "Notre équipe redonne vie à l'habitacle de votre véhicule. Nous shampouinons les sièges et les moquettes, dépoussiérons chaque recoin et traitons les taches en profondeur, avec des produits sans danger pour les matériaux.",
        'atouts'      => ['Sièges et moquettes shampouinés', 'Élimination des taches et des odeurs', 'Plastiques et vitres intérieures nettoyés', 'Produits respectueux de l\'habitacle'],
        'prix'        => 'À partir de 39 €',
    ],
    'vitre' => [
        'titre'       => 'Nettoyage de vitres',
        'value'       => 'Vitre',
        'image'       => 'img/Nettoyage Carte1/2.png',
        'intro'       => "Des vitres parfaitement transparentes, sans traces ni auréoles, à l'intérieur comme à l'extérieur.",
        'description' => "Nous nettoyons vos vitres, baies et surfaces vitrées avec un matériel professionnel pour un résultat net et durable. Idéal pour les particuliers comme pour les commerces qui veulent une devanture impeccable.",
        'atouts'      => ['Vitres intérieures et extérieures', 'Sans traces ni auréoles', 'Cadres et rebords essuyés', 'Adapté maison et commerce'],
        'prix'        => 'À partir de 25 €',
    ],
    'canape' => [
        'titre'       => 'Nettoyage de canapé',
        'value'       => 'Canapé',
        'image'       => 'img/canape.jpg',
        'intro'       => "Un canapé ravivé, débarrassé des taches et des acariens, agréable à retrouver chaque jour.",
        'description' => "Nous nettoyons vos canapés en tissu ou en cuir grâce à des méthodes adaptées à chaque matière. Les taches sont traitées en profondeur et les fibres assainies pour retrouver couleur et fraîcheur.",
        'atouts'      => ['Tissus et cuir traités selon la matière', 'Taches éliminées en profondeur', 'Assainissement anti-acariens', 'Séchage rapide'],
        'prix'        => 'À partir de 49 €',
    ],
    'tapis' => [
        'titre'       => 'Nettoyage de tapis',
        'value'       => 'Tapis',
        'image'       => 'img/tapis.jpg',
        'intro'       => "Des tapis aux couleurs éclatantes et aux fibres assainies, comme neufs.",
        'description' => "Vos tapis retrouvent tout leur éclat grâce à un nettoyage en profondeur qui respecte les fibres. Poussières, taches et odeurs disparaissent pour un intérieur plus sain.",
        'atouts'      => ['Nettoyage en profondeur des fibres', 'Couleurs ravivées', 'Élimination des odeurs', 'Respect des matières délicates'],
        'prix'        => 'À partir de 29 €',
    ],
    'matelas' => [
        'titre'       => 'Nettoyage de matelas',
        'value'       => 'Matelas',
        'image'       => 'img/matelas (1).jpg',
        'intro'       => "Un couchage sain, débarrassé des acariens et des taches, pour des nuits sereines.",
        'description' => "Nous assainissons votre matelas en profondeur : élimination des acariens, traitement des taches et neutralisation des odeurs. Un geste essentiel pour votre sommeil et votre santé.",
        'atouts'      => ['Traitement anti-acariens', 'Taches et auréoles éliminées', 'Odeurs neutralisées', 'Séchage rapide'],
        'prix'        => 'À partir de 45 €',
    ],
];

// Récupération et validation du service demandé
$slug = isset($_GET['s']) ? strtolower(trim($_GET['s'])) : '';
if (!isset($services[$slug])) {
    header('Location: index.php');
    exit;
}
$service     = $services[$slug];
$serviceSlug = $slug;

// Ressources pour le header commun
$cssacceuil       = "";
$jscarousel       = "";
$jspopup          = "";
$cssrecap         = "";
$csscoordonnees   = "";
$cssheader_footer = "./style/header-footer.css";
$csscommon        = "./style/common.css";
$cssrdv           = "";

include './view/header.php';
include './view/service.php';
include './view/footer.php';
?>
