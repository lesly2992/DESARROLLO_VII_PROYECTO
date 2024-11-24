<?php
require '../../src/Database.php';

$errorMessage = "";
$successMessage = "";

// Verificar si el token está presente en la URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Buscar el token en la base de datos y verificar si aún es válido
    $sql = "SELECT * FROM usuarios WHERE reset_token = :token AND token_expiry > NOW()";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $errorMessage = "El enlace de recuperación es inválido o ha expirado.";
    }
} else {
    $errorMessage = "Token no proporcionado.";
}

// Procesar el formulario para restablecer contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($user)) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($newPassword) || empty($confirmPassword)) {
        $errorMessage = "Por favor, completa todos los campos.";
    } elseif ($newPassword !== $confirmPassword) {
        $errorMessage = "Las contraseñas no coinciden.";
    } else {
        // Encriptar la nueva contraseña
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos y eliminar el token
        $sql = "UPDATE usuarios SET password = :password, reset_token = NULL, token_expiry = NULL WHERE id = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $user['id']);
        $stmt->execute();

        $successMessage = "Contraseña restablecida con éxito. Ahora puedes iniciar sesión.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../../assets/CSS/style.css">
</head>
<body>
    <form action="" method="POST" class="formLogin">
        <div class="title">
            <h2>Restablecer Contraseña</h2>
        </div>

        <?php if (!empty($errorMessage)): ?>
        <div class="error_message" style="color: red; padding:10px 0px">
            <?php echo $errorMessage; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
        <div class="success_message" style="color: green; padding:10px 0px">
            <?php echo $successMessage; ?>
            <div class="message">
                <p><a href="login.php">Volver al login</a></p>
            </div>
        </div>
        <?php else: ?>
        <div class="formGroup">
            <label for="new_password">Nueva Contraseña: </label>
            <input type="password" id="new_password" name="new_password" required>
        </div>

        <div class="formGroup">
            <label for="confirm_password">Confirmar Contraseña: </label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <div class="btn_container">
            <button type="submit" class="btn_login">Restablecer</button>
        </div>
        <?php endif; ?>
    </form>
</body>
</html>
