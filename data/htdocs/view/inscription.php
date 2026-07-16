<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Clean Pro Agency</title>
    <link rel="icon" href="img/flavicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/connexion.css">
    <link rel="stylesheet" href="./style/theme.css">

</head>
<body>
    <h1>Clean Pro Agency</h1>
    <section>
        <img src="./img/connexionphoto2.png" alt="connexionphoto">

    <form action="<?php echo $actionCreateUser ?>" method="POST">
        <h2>Inscription</h2>
    <input type="text" name="lastNameAdd" placeholder="Votre nom" value="<?php echo htmlspecialchars($lastNameAdd ?? ''); ?>" autocomplete="off" required>
    <input type="text" name="firstNameAdd" placeholder="Votre prénom" value="<?php echo htmlspecialchars($firstNameAdd ?? ''); ?>" autocomplete="off" required>
    <input type="email" name="emailAdd" placeholder="Votre email" value="<?php echo htmlspecialchars($emailAdd ?? ''); ?>" autocomplete="off" required>
    <input type="tel" name="numberPhoneAdd" placeholder="Téléphone (ex : 06 12 34 56 78)" value="<?php echo htmlspecialchars($numberPhoneAdd ?? ''); ?>" pattern="^(?:\+33|0)[1-9]([ .\-]?\d{2}){4}$" autocomplete="off" required>
    <input type="text" name="adresseAdd" placeholder="Votre adresse postale" value="<?php echo htmlspecialchars($adresseAdd ?? ''); ?>" autocomplete="off" required>
    <input type="text" name="codePostalAdd" placeholder="Code postal (5 chiffres)" value="<?php echo htmlspecialchars($codePostalAdd ?? ''); ?>" pattern="\d{5}" inputmode="numeric" maxlength="5" autocomplete="off" required>
    <input type="text" name="cityAdd" placeholder="Ville" value="<?php echo htmlspecialchars($cityAdd ?? ''); ?>" autocomplete="off" required>
    <input type="password" name="passwordAdd" placeholder="Mot de passe (6 caractères min.)" minlength="6" autocomplete="off" required>

    <input type="submit" name="submitAddUser" class="sincrire" value="S'inscrire">

    <div class="retour_connexion"><a href="connexion.php" >Vous avez déjà un compte</a></div>
    <p id="messageAddUser"><?php echo $messageAddUser ?></p>
    <p><?php echo  $errorin ?></p>
    </form>
    </section>
   
    
    <footer>
        <div class="square"></div>
    </footer>

    <script>
    (function () {
        const form = document.querySelector('form');
        if (!form) return;
        const q = n => form.querySelector('[name="' + n + '"]');
        const msg = document.getElementById('messageAddUser');
        let validated = false;

        const norm = s => (s || '').toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9]/g, '');
        const nomOk = s => /^[\p{L}'\- ]{2,}$/u.test((s || '').trim());

        function show(txt, info) {
            if (!msg) return;
            msg.textContent = txt;
            msg.style.color = info ? '#056FE8' : '#b3261e';
        }

        async function communes(cp) {
            try {
                const r = await fetch('https://geo.api.gouv.fr/communes?codePostal=' + encodeURIComponent(cp) + '&fields=nom&format=json');
                if (!r.ok) return null;
                return await r.json();
            } catch (e) { return null; }
        }

        form.addEventListener('submit', async function (e) {
            if (validated) return;
            e.preventDefault();

            const nom    = q('lastNameAdd').value;
            const prenom = q('firstNameAdd').value;
            const email  = q('emailAdd').value.trim();
            const phone  = q('numberPhoneAdd').value.replace(/[\s.\-]/g, '');
            const cp     = q('codePostalAdd').value.trim();
            const ville  = q('cityAdd').value.trim();
            const pass   = q('passwordAdd').value;

            const errs = [];
            if (!nomOk(nom))    errs.push("Nom invalide.");
            if (!nomOk(prenom)) errs.push("Prénom invalide.");
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) errs.push("Email invalide.");
            if (!/^(?:\+33|0)[1-9]\d{8}$/.test(phone)) errs.push("Téléphone invalide (ex : 06 12 34 56 78).");
            if (!/^\d{5}$/.test(cp)) errs.push("Code postal : 5 chiffres.");
            if (!nomOk(ville)) errs.push("Ville invalide.");
            if (pass.length < 6) errs.push("Mot de passe : 6 caractères minimum.");
            if (errs.length) { show(errs.join(' ')); return; }

            show("Vérification de la commune…", true);
            const list = await communes(cp);
            if (list === null) {
                // API injoignable depuis le navigateur : le serveur tranchera
            } else if (!list.length) {
                show("Ce code postal n'existe pas."); return;
            } else {
                const vn = norm(ville);
                if (!list.some(c => norm(c.nom) === vn)) {
                    show("La ville ne correspond pas au code postal " + cp + ". Communes possibles : " + list.map(c => c.nom).slice(0, 6).join(', ') + ".");
                    return;
                }
            }
            validated = true;
            const btn = q('submitAddUser');
            if (btn) { btn.click(); } else { form.submit(); }
        });
    })();
    </script>
</body>

</html>

