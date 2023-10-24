function envoyerFormulaire(event) {
  event.preventDefault(); // Empêcher la soumission du formulaire par défaut

  // Récupérer les données du formulaire
  var nom = document.getElementById("nom").value;
  var prenom = document.getElementById("prenom").value;
  var email = document.getElementById("email").value;
  var message = document.getElementById("message").value;

  // Créer un objet FormData pour envoyer les données au serveur
  var formData = new FormData();
  formData.append("nom", nom);
  formData.append("prenom", prenom);
  formData.append("email", email);
  formData.append("message", message);

  // Envoyer les données via une requête AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "formulaire.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Le serveur a répondu avec succès, vous pouvez afficher un message de confirmation ici
      alert("Le formulaire a été soumis avec succès !");
    }
  };
  xhr.send(formData);
}
