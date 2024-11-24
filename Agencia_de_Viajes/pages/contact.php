<?php

include("../includes/nav.php"); 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Emails to send the form data to
    $recipients = ["allandr46@gmail.com"];
    $subject = "Haz recibido una sugerencia";
    $headers = "From: $email\r\n" .
               "Reply-To: $email\r\n" .
               "Content-Type: text/html; charset=UTF-8\r\n";

    // Email content
    $body = "
        <h2>Nuevo Mensaje de Contacto</h2>
        <p><strong>Nombre:</strong> $name</p>
        <p><strong>Correo Electrónico:</strong> $email</p>
        <p><strong>Mensaje:</strong></p>
        <p>$message</p>
    ";

    // Send emails
    $mailSent = true;
    foreach ($recipients as $recipient) {
        if (!mail($recipient, $subject, $body, $headers)) {
            $mailSent = false;
        }
    }

    if ($mailSent) {
        echo "<p>Gracias por contactarnos, $name. Hemos recibido tu mensaje y te responderemos pronto.</p>";
    } else {
        echo "<p>Lo sentimos, hubo un problema al enviar tu mensaje. Inténtalo más tarde.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="../assets/CSS/style.css">
</head>
<body>
    <section class="contact">
        <div class="container">
            <h2>Contáctanos</h2>
            <form action="/path/to/contact_process.php" method="POST">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>

    <label for="message">Mensaje:</label>
    <textarea id="message" name="message" required></textarea>

    <button type="submit">Enviar</button>
</form>
        </div>
    </section>
</body>
</html>
