<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Adresse e-mail de destination
    $destinataire = "bapdem2@gmail.com";

    // Sujet de l'e-mail
    $sujet = "Nouveau message de formulaire de contact";

    // Corps de l'e-mail
    $contenu = "Nom: $nom\n";
    $contenu .= "Prénom: $prenom\n";
    $contenu .= "E-mail: $email\n";
    $contenu .= "Message:\n$message";

    // En-têtes de l'e-mail
    $headers = "De: $email\r\n";

    // Envoyer l'e-mail
    mail($destinataire, $sujet, $contenu, $headers);

    // Rediriger l'utilisateur vers une page de confirmation
    header("Location: confirmation.html");
}
?>
