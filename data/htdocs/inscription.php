<?php
session_start();

include './utils/bdd.php';
include './model/connexion.php';

$messageAddUser = '';
$lastNameAdd    = '';
$firstNameAdd   = '';
$emailAdd       = '';
$numberPhoneAdd = '';
$adresseAdd     = '';
$codePostalAdd  = '';
$cityAdd        = '';
$errorin        = '';

$actionCreateUser = "inscription.php";

/* ------------------------- Outils de validation ------------------------- */

// Normalise un texte (minuscules, sans accents ni séparateurs) pour comparer des villes
function normaliserTexte($s) {
    $s = (string)$s;
    $accents = [
        'À'=>'a','Â'=>'a','Ä'=>'a','Á'=>'a','Ã'=>'a','à'=>'a','â'=>'a','ä'=>'a','á'=>'a','ã'=>'a',
        'É'=>'e','È'=>'e','Ê'=>'e','Ë'=>'e','é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
        'Î'=>'i','Ï'=>'i','Í'=>'i','î'=>'i','ï'=>'i','í'=>'i',
        'Ô'=>'o','Ö'=>'o','Ó'=>'o','Õ'=>'o','ô'=>'o','ö'=>'o','ó'=>'o','õ'=>'o',
        'Ù'=>'u','Û'=>'u','Ü'=>'u','Ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u','ú'=>'u',
        'Ç'=>'c','ç'=>'c','Ñ'=>'n','ñ'=>'n',
    ];
    $s = strtr($s, $accents);
    $s = strtolower($s);
    return preg_replace('/[^a-z0-9]/', '', $s);
}

// Récupère une URL (cURL sinon file_get_contents), renvoie le corps ou null
function recupererUrl($url) {
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'CleanProAgency');
        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($res !== false && $code >= 200 && $code < 300) ? $res : null;
    }
    if (ini_get('allow_url_fopen')) {
        $ctx = stream_context_create(['http' => ['timeout' => 4], 'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
        $res = @file_get_contents($url, false, $ctx);
        return ($res !== false) ? $res : null;
    }
    return null;
}

// Liste des communes pour un code postal (API officielle), ou null si indisponible
function communesPourCP($cp) {
    $url  = "https://geo.api.gouv.fr/communes?codePostal=" . urlencode($cp) . "&fields=nom&format=json";
    $data = recupererUrl($url);
    if ($data === null) return null;
    $json = json_decode($data, true);
    if (!is_array($json)) return null;
    $noms = [];
    foreach ($json as $c) {
        if (isset($c['nom'])) $noms[] = $c['nom'];
    }
    return $noms;
}

/* ------------------------ Traitement du formulaire ---------------------- */

if (isset($_POST['submitAddUser'])) {
    $lastNameAdd    = htmlentities(strip_tags(trim($_POST['lastNameAdd'] ?? '')));
    $firstNameAdd   = htmlentities(strip_tags(trim($_POST['firstNameAdd'] ?? '')));
    $emailAdd       = trim($_POST['emailAdd'] ?? '');
    $numberPhoneAdd = trim($_POST['numberPhoneAdd'] ?? '');
    $adresseAdd     = htmlentities(strip_tags(trim($_POST['adresseAdd'] ?? '')));
    $codePostalAdd  = trim($_POST['codePostalAdd'] ?? '');
    $cityAdd        = htmlentities(strip_tags(trim($_POST['cityAdd'] ?? '')));
    $passwordAdd    = (string)($_POST['passwordAdd'] ?? '');

    $erreurs = [];

    // Champs obligatoires
    if ($lastNameAdd === '' || $firstNameAdd === '' || $emailAdd === '' || $numberPhoneAdd === ''
        || $adresseAdd === '' || $codePostalAdd === '' || $cityAdd === '' || $passwordAdd === '') {
        $erreurs[] = "Merci de remplir tous les champs.";
    }

    // Nom / prénom / ville : lettres uniquement (pas de chiffres ni caractères parasites)
    $rawLast  = trim($_POST['lastNameAdd'] ?? '');
    $rawFirst = trim($_POST['firstNameAdd'] ?? '');
    $rawCity  = trim($_POST['cityAdd'] ?? '');
    if ($rawLast !== '' && !preg_match('/^[\p{L}\'\- ]{2,}$/u', $rawLast)) {
        $erreurs[] = "Le nom n'est pas valide.";
    }
    if ($rawFirst !== '' && !preg_match('/^[\p{L}\'\- ]{2,}$/u', $rawFirst)) {
        $erreurs[] = "Le prénom n'est pas valide.";
    }
    if ($rawCity !== '' && !preg_match('/^[\p{L}\'\- ]{2,}$/u', $rawCity)) {
        $erreurs[] = "Le nom de ville n'est pas valide.";
    }

    // Email
    if ($emailAdd !== '' && !filter_var($emailAdd, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }

    // Téléphone français (10 chiffres commençant par 0, ou +33)
    $phoneNorm = preg_replace('/[\s.\-]/', '', $numberPhoneAdd);
    if ($numberPhoneAdd !== '' && !preg_match('/^(?:\+33|0)[1-9]\d{8}$/', $phoneNorm)) {
        $erreurs[] = "Le numéro de téléphone n'est pas valide (ex : 06 12 34 56 78).";
    }

    // Code postal (5 chiffres)
    if ($codePostalAdd !== '' && !preg_match('/^\d{5}$/', $codePostalAdd)) {
        $erreurs[] = "Le code postal doit contenir 5 chiffres.";
    }

    // Mot de passe
    if ($passwordAdd !== '' && strlen($passwordAdd) < 6) {
        $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    // Email déjà utilisé ?
    if (empty($erreurs)) {
        try {
            $chk = $bdd->prepare("SELECT COUNT(*) FROM client WHERE email_client = ?");
            $chk->execute([$emailAdd]);
            if ($chk->fetchColumn() > 0) {
                $erreurs[] = "Un compte existe déjà avec cette adresse email.";
            }
        } catch (Exception $e) { /* on ne bloque pas si la requête échoue */ }
    }

    // Le code postal correspond-il à la ville ? (API officielle ; ignoré si indisponible)
    if (empty($erreurs) && preg_match('/^\d{5}$/', $codePostalAdd)) {
        $communes = communesPourCP($codePostalAdd);
        if (is_array($communes) && !empty($communes)) {
            $villeNorm = normaliserTexte($cityAdd);
            $ok = false;
            foreach ($communes as $c) {
                if (normaliserTexte($c) === $villeNorm) { $ok = true; break; }
            }
            if (!$ok) {
                $exemples = implode(', ', array_slice($communes, 0, 6));
                $erreurs[] = "La ville ne correspond pas au code postal $codePostalAdd. Communes possibles : $exemples.";
            }
        }
    }

    // Inscription si tout est bon
    if (empty($erreurs)) {
        $hash = password_hash($passwordAdd, PASSWORD_BCRYPT);
        $res  = inscription($lastNameAdd, $firstNameAdd, $emailAdd, $numberPhoneAdd, $adresseAdd, $codePostalAdd, $cityAdd, $hash, $bdd);
        if ($res === true) {
            $messageAddUser = "Votre inscription a bien été prise en compte. Vous pouvez maintenant vous connecter.";
            // On vide les champs après un succès
            $lastNameAdd = $firstNameAdd = $emailAdd = $numberPhoneAdd = $adresseAdd = $codePostalAdd = $cityAdd = '';
        } else {
            $messageAddUser = is_string($res) ? $res : "Une erreur est survenue lors de l'inscription.";
        }
    } else {
        $messageAddUser = implode(' ', $erreurs);
    }
}

$cssacceuil       = "";
$jscarousel       = "";
$jspopup          = "";
$cssrecap         = "";
$csscoordonnees   = "";
$cssheader_footer = "";
$csscommon        = "";
$cssrdv           = "";

include './view/inscription.php';
?>
