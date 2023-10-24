<?php
/*
 *  CONFIGURE EVERYTHING HERE
 */

// smtp credentials and server
$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'bapdem2@gmail.com';
$smtpPassword = 'spelerattoe0';

// Include the PHPMailer Autoload file
require 'PHPMailer-master/src/PHPMailer.php';

$mail = new PHPMailer;

// an email address that will be in the From field of the email.
$from = 'Demo contact form <bapdem2@gmail.com>';

// an email address that will receive the email with the output of the form
$sendTo = 'Demo contact form <bapdem2@gmail.com>';

// subject of the email
$subject = 'New message from contact form';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message');

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

/*
 *  LET'S DO THE SENDING
 */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

try {
    if (count($_POST) == 0) throw new \Exception('Form is empty');

    $emailText = "You have a new message from your contact form\n=============================\n";

    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    // All the necessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $_POST['email'],
        'Return-Path: ' . $from,
    );

    // Set mailer to use SMTP
    $mail->isSMTP();

    // Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';

    // Set the hostname of the mail server
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6
    $mail->Host = gethostbyname($smtpHost);

    // Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    // Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    // Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    // Username to use for SMTP authentication - use the full email address for Gmail
    $mail->Username = $smtpUsername;

    // Password to use for SMTP authentication
    $mail->Password = $smtpPassword;

    // Set From and To
    $mail->setFrom($from);
    $mail->addAddress($sendTo);

    // Set email subject and message
    $mail->Subject = $subject;
    $mail->Body = $emailText;

    if (!$mail->send()) {
        throw new \Exception('I could not send the email. ' . $mail->ErrorInfo);
    }

    $responseArray = array('type' => 'success', 'message' => $okMessage);
} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    header('Content-Type: application/json');
    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}
?>
