<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar el autoload de Composer
require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'tu_correo@gmail.com'; // Tu correo
        $mail->Password = 'tu_contraseña'; // Contraseña del correo o contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encriptación segura
        $mail->Port = 587; // Puerto SMTP para TLS

        // Configuración del correo
        $mail->setFrom($email, $name); // Remitente (correo ingresado por el usuario)
        $mail->addAddress('destinatario@tudominio.com'); // Correo destino donde recibirás los mensajes
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body = "
            <h2>Nuevo Mensaje de Contacto</h2>
            <p><strong>Nombre:</strong> $name</p>
            <p><strong>Correo Electrónico:</strong> $email</p>
            <p><strong>Mensaje:</strong></p>
            <p>$message</p>
        ";

        $mail->send();
        echo "<p>Gracias por tu mensaje, $name. Nos pondremos en contacto contigo pronto.</p>";
    } catch (Exception $e) {
        echo "<p>Error al enviar el mensaje: {$mail->ErrorInfo}</p>";
    }
} else {
    echo "<p>Acceso no válido al formulario.</p>";
}
?>
