<?php
require '../src/Database.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recuperar campos del formulario
        $paquete_id = intval($_POST['paquete_id']);
        $usuario_id = 1; // Usuario predeterminado (actualízalo cuando implementes autenticación)
        $nombre_cliente = htmlspecialchars($_POST['nombre_cliente']);
        $email_cliente = htmlspecialchars($_POST['email_cliente']);
        $telefono_cliente = htmlspecialchars($_POST['telefono_cliente']);
        $fecha_reserva = htmlspecialchars($_POST['fecha_reserva']);
        $hora_reserva = htmlspecialchars($_POST['hora_reserva']);
        $comentario = htmlspecialchars($_POST['comentario']);

        // Validar campos requeridos
        if (empty($nombre_cliente) || empty($email_cliente) || empty($telefono_cliente) || empty($fecha_reserva) || empty($hora_reserva)) {
            throw new Exception('Todos los campos obligatorios deben completarse.');
        }

        // Insertar datos en la tabla `reservas`
        $sql = "INSERT INTO reservas (nombre_cliente, email_cliente, telefono_cliente, usuario_id, paquete_id, fecha_reserva, hora_reserva, estado, comentario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'pendiente', ?)";
        $stmt = $PDO->prepare($sql);
        $stmt->execute([$nombre_cliente, $email_cliente, $telefono_cliente, $usuario_id, $paquete_id, $fecha_reserva, $hora_reserva, $comentario]);

        // Mensaje de agradecimiento
        $message = "<h1>¡Gracias por tu reserva, $nombre_cliente!</h1>
                    <p>Hemos recibido tu información correctamente. Nos pondremos en contacto contigo pronto.</p>";

         // Redirigir a detalles.php con un mensaje de éxito
         header("Location: detalles.php?id=$paquete_id&reserva=success");
         exit(); 
                    
    } else {
        throw new Exception('Acceso no válido al formulario.');
    }
} catch (Exception $e) {
    $message = "<h1>Error</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agradecimiento</title>
    <link rel="stylesheet" href="../assets/CSS/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .thank-you-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            margin: auto;
        }
        .thank-you-container h1 {
            color: #00796b;
            margin-bottom: 20px;
        }
        .thank-you-container p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        .thank-you-container .back-button {
            display: inline-block;
            background-color: #009688;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .thank-you-container .back-button:hover {
            background-color: #00796b;
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <?php echo $message; ?>
        <a href="javascript:history.back()" class="back-button">Volver</a>
    </div>