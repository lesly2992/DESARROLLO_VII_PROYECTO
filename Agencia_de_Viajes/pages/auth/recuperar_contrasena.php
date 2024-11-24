<?php
require '../src/Database.php';

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Verificar si el correo está registrado
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generar token único
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // El token expira en 1 hora

        // Guardar el token en la base de datos
        $sql = "UPDATE usuarios SET reset_token = :token, token_expiry = :expiry WHERE email = :email";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiry', $expiry);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Enviar correo con enlace de recuperación
        $resetLink = "http://yourdomain.com/pages/reset_password.php?token=" . $token;
        $subject = "Recuperación de contraseña";
        $message = "Hola, has solicitado recuperar tu contraseña. Haz clic en el siguiente enlace para restablecerla:\n\n" . $resetLink . "\n\nEste enlace expira en 1 hora.";
        $headers = "From: no-reply@yourdomain.com";

        if (mail($email, $subject, $message, $headers)) {
            $successMessage = "Un correo con el enlace de recuperación ha sido enviado.";
        } else {
            $errorMessage = "Hubo un error al enviar el correo. Por favor, intenta nuevamente.";
        }
    } else {
        $errorMessage = "El correo electrónico no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../assets/CSS/style.css">
</head>
<body>
    <form action="" method="POST" class="formLogin">

        <div class="title">
            <h2>Recuperar Contraseña</h2>
        </div>

        <?php if (!empty($errorMessage)): ?>
        <div class="error_message" style="color: red; padding:10px 0px">
            <?php echo $errorMessage; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
        <div class="success_message" style="color: green; padding:10px 0px">
            <?php echo $successMessage; ?>
        </div>
        <?php endif; ?>

        <div class="formGroup">
            <label for="email">Correo Electrónico: </label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="btn_container">
            <button type="submit" class="btn_login">Enviar</button>
        </div>

        <div class="message">
            <p><a href="login.php">Volver al login</a></p>
        </div>

    </form>
</body>
</html>
