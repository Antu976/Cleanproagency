(function () {
    //utilisation de la directive "use strict" pour activer le mode strict en js
    // cela implique une meilleure gestion des erreurs et une syntaxe plus stricte pour le code  notamment en signalant plus d'erreurs
    "use strict"
    //Déclare la constante pour la durée de chaque slide
    const slideTimeout = 5000;
    // récupère les boutons de navigation 
    const prev = document.querySelector('#prev');
    const next = document.querySelector('#next');
    // récupère tous les éléments de chaque slides, c'est une nodelist
    const $slides = document.querySelectorAll('.slide');
    // initialisation de la variable pour les "dots" on va pouvoir stocker les references aux balles de pagination
    let $dots;

    // Initialisation de la variable pour l'intervalle d'affichage des slides
    let intervalId;

    //initialisation du slide courant à 1, on stocke l'identifiant de l'intervalle qui controle le défilement automatique
    let currentSlide = 1;

    //fonction pour afficher un slide spécifique en utilisant un index
    function slideTo(index) {
        //vérifie si l'index est valide (compris entre 0 et le nombre de slides -1)
        // La condition vérifiée ici est index >= $slides.length || index < 1. Si cette condition est vraie (c'est-à-dire, si index est plus grand ou égal au nombre total de diapositives, ou si index est inférieur à 1), alors currentSlide est défini à 0. Si la condition est fausse, currentSlide est mis à la valeur de index.
        currentSlide = index >= $slides.length || index < 1 ? 0 : index;
        //Boucle sur tous les éléments de types slides pour les déplacer, c'est une liste d'ou foreach

        //         Ici, une boucle forEach est utilisée pour parcourir chaque diapositive dans $slides.
        // Pour chaque diapositive ($elt), la propriété CSS transform est mise à jour avec une valeur translateX, qui décale la diapositive horizontalement. Le décalage est basé sur l'index de la diapositive actuelle (currentSlide), multiplié par -100%. Cela signifie que chaque diapositive est déplacée vers la gauche par un multiple complet de la largeur du conteneur, alignant ainsi la diapositive ciblée avec la zone d'affichage du carrousel.
        $slides.forEach($elt => $elt.style.transform = `translateX(-${currentSlide * 100}%)`);
        // Boucle sur tous les "dots" pour mettre à jour la couleur par la classe "active" ou "inactive"
        //meme chose que le cas des slides avec key l'index des points
        $dots.forEach(($elt, key) => $elt.classList = `dot ${key === currentSlide ? 'active' : 'inactive'}`);
    }
    // Fonction pour afficher le prochain slide on la la boucle des slides qui se fait
    function showSlide() {
        slideTo(currentSlide);
        currentSlide++;
    }
    // Boucle pour créer les "dots" en fonction du nombre de slides
    for (let i = 1; i <= $slides.length; i++) {
        // Pour chaque itération de la boucle, cette ligne détermine si le "dot" à créer doit être marqué comme active ou inactive. Si l'indice de l'itération courante (i) correspond à l'indice de la diapositive actuellement affichée (currentSlide), le "dot" est considéré comme actif (active). Sinon, il est considéré comme inactif (inactive). Cela permet de visualiser quel "dot" correspond à la diapositive visible à l'écran
        let dotClass = i == currentSlide ? 'active' : 'inactive';
        // Cette ligne crée un élément HTML span pour le "dot", en utilisant un modèle de chaîne de caractères (template string). Cet élément reçoit un attribut data-slidId contenant l'indice de la diapositive qu'il représente, ainsi que la classe déterminée précédemment (dot et soit active soit inactive). Cela permet d'associer chaque "dot" à sa diapositive respective et de styliser visuellement l'état actif ou inactif
        let $dot = `<span data-slidId="${i}" class="dot ${dotClass}"></span>`;
        //ajout des points créer au dom et le += est utilisé pour s'assurer que chaque dot est ajouté à la suite des précédents, construisant ainsi la liste complète des dots representant toutes les diapositives 
        document.querySelector('.carousel-dots').innerHTML += $dot;
    }
    // Récupère tous les "dots"
    $dots = document.querySelectorAll('.dot');
    // Boucle pour ajouter des écouteurs d'événement "click" sur chaque "dot"
    $dots.forEach(($elt, key) => $elt.addEventListener('click', () => slideTo(key)));
    // Ajout d'un écouteur d'événement "click" sur le bouton "prev" pour afficher le slide précédent
    prev.addEventListener('click', () => slideTo(--currentSlide))
    // Ajout d'un écouteur d'événement "click" sur le bouton "next" pour afficher le slide suivant
    next.addEventListener('click', () => slideTo(++currentSlide))
    // Initialisation de l'intervalle pour afficher les slides
    intervalId = setInterval(showSlide, slideTimeout)
    // Boucle sur tous les éléments de type "slide" pour ajouter des écouteurs d'événement pour les interactions avec la souris et le toucher
    $slides.forEach($elt => {
        let startX;
        let endX;
        // Efface l'intervalle d'affichage des slides lorsque la souris passe sur un slide
        $elt.addEventListener('mouseover', () => {
            clearInterval(intervalId);
        }, false)
        // Réinitialise l'intervalle d'affichage des slides lorsque la souris sort d'un slide
        $elt.addEventListener('mouseout', () => {
            intervalId = setInterval(showSlide, slideTimeout);
        }, false);
        // Enregistre la position initiale du toucher lorsque l'utilisateur touche un slide
        $elt.addEventListener('touchstart', (event) => {
            startX = event.touches[0].clientX;
        });
        // Enregistre la position finale du toucher lorsque l'utilisateur relâche son doigt
        $elt.addEventListener('touchend', (event) => {
            endX = event.changedTouches[0].clientX;
            // Si la position initiale est plus grande que la position finale, affiche le prochain slide
            if (startX > endX) {
                slideTo(currentSlide + 1);
                // Si la position initiale est plus petite que la position finale, affiche le slide précédent
            } else if (startX < endX) {
                slideTo(currentSlide - 1);
            }
        });
    })
})()



