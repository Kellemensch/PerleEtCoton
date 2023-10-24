/*function envoyerFormulaire(event) {
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
*/

$(function () {

    // init the validator
    // validator files are included in the download package
    // otherwise download from http://1000hz.github.io/bootstrap-validator

    $('#contact-form').validator();


    // when the form is submitted
    $('#contact-form').on('submit', function (e) {

        // if the validator does not prevent form submit
        if (!e.isDefaultPrevented()) {
            var url = "contact.php";

            // POST values in the background the the script URL
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data)
                {
                    // data = JSON object that contact.php returns

                    // we recieve the type of the message: success x danger and apply it to the 
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    // let's compose Bootstrap alert box HTML
                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
                    
                    // If we have messageAlert and messageText
                    if (messageAlert && messageText) {
                        // inject the alert to .messages div in our form
                        $('#contact-form').find('.messages').html(alertBox);
                        // empty the form
                        $('#contact-form')[0].reset();
                    }
                }
            });
            return false;
        }
    })
});