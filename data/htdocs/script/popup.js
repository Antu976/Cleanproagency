document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('confirmer');
  
    form.addEventListener('click', function (event) {
      event.preventDefault();
  
      Swal.fire({
        icon: 'success', // Type d'icône 
        title: 'Rendez-vous pris avec succès !',
        text: 'Nous vous contacterons bientôt.',
        showConfirmButton: false, // Affiche le bouton de confirmation
        timer: 3000 // Temps d'affichage du pop-up en millisecondes (ici, 3 secondes)
      });
  
      form.reset();
    });
  });
  