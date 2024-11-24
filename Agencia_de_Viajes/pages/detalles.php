<?php
include("../includes/header.php");
include("../includes/nav.php");
require '../src/Database.php';

try {
    // Verificar si se pasó el ID en la URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $package_id = intval($_GET['id']); // Asegurarse de que es un número

        // Preparar y ejecutar la consulta para obtener el paquete específico
        $sql = "SELECT id, nombre, destino, descripcion, precio, duracion, detalle, imagen FROM paquetes WHERE id = ?";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(1, $package_id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el resultado
        $paquete = $stmt->fetch(PDO::FETCH_ASSOC);

        
    } else {
        echo "<h1>ID del paquete no especificado o inválido.</h1>";
    }
} catch (PDOException $e) {
    echo "Error al consultar la base de datos: " . $e->getMessage();
}

if (isset($_GET['reserva']) && $_GET['reserva'] === 'success') {
    echo '<p class="success-message">Reserva realizada con éxito. Nos pondremos en contacto contigo pronto.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Paquete</title>
    <link rel="stylesheet" href="../assets/CSS/style.css"/>
</head>
<body>
    <div class="container-detalles">
        <header>
        <a style="padding-left: 30px;"><h1><?php echo htmlspecialchars($paquete['nombre']); ?></h1></a>
        </header>

        <div class="package-details">
    <!-- Image section on the left -->
    <div class="package-image">
        <img src="../uploads/<?php echo htmlspecialchars($paquete['imagen']); ?>" alt="<?php echo htmlspecialchars($paquete['nombre']); ?>">
    </div>

    <!-- Information section on the right -->
    <div class="package-info">
         <h2> Destino: <?php echo htmlspecialchars($paquete['destino']); ?></h2>
        <p> <b>Descripcion: </b> <?php echo htmlspecialchars($paquete['descripcion']); ?><br></p>
        <p> <b>Detalles de viaje: </b> <?php echo htmlspecialchars($paquete['detalle']); ?><br></p>
        <p> <b>Precio: </b> <?php echo htmlspecialchars($paquete['precio']); ?><br></p>
        <p> <b>Duracion: </b> <?php echo htmlspecialchars($paquete['duracion']); ?></p>
        <div class="reservation-container">
            <button id="reservarBtn" onclick="showReservationForm()">Reservar</button>
            <div id="reservationForm" class="formLogin" style="display: none; margin-top: 20px;">
                <h3>Formulario de Reserva</h3>
                <form action="process_reservation.php" method="POST">
                     <!-- Paquete ID (hidden) -->
                 <input type="hidden" name="paquete_id" value="<?php echo htmlspecialchars($paquete['id']); ?>">
        
                     <!-- Fecha de Reserva -->
                     <div class="formGroup">
                         <label for="nombre_cliente">Nombre:</label>
                             <input type="text" name="nombre_cliente" id="nombre_cliente" placeholder="Tu nombre" required>
                        </div>

                    <div class="formGroup">
                        <label for="email_cliente">Correo Electrónico:</label>
                            <input type="email" name="email_cliente" id="email_cliente" placeholder="Tu correo electrónico" required>
                        </div>

                    <div class="formGroup">
                        <label for="telefono_cliente">Teléfono:</label>
                             <input type="tel" name="telefono_cliente" id="telefono_cliente" placeholder="Tu teléfono" required>
                    </div>

                    <div class="formGroup">
                        <label for="fecha_reserva">Fecha de Reserva:</label>
                            <input type="date" name="fecha_reserva" id="fecha_reserva" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="formGroup">
                        <label for="hora_reserva">Hora de Reserva:</label>
                            <input type="time" name="hora_reserva" id="hora_reserva" required>
                        </div>

                    <div class="formGroup">
                        <label for="comentario">Comentario:</label>
                            <textarea name="comentario" id="comentario" rows="4" placeholder="Escribe algún comentario (opcional)"></textarea>
                    </div>

                   
                     <!-- Estado de la Reserva -->
                     <div class="formGroup">
                          <label for="estado">Estado:</label>
                             <select name="estado" id="estado" required>
                             <option value="pendiente" selected>Pendiente</option>
                            <option value="confirmada">Confirmada</option>
                            <option value="cancelada">Cancelada</option>
                             </select>
                             </div>
        
                     <!-- Submit Button -->
                     <div class="btn_container">
                     <button type="submit">Enviar Reserva</button>
                     </div>
                 </form>
        
            </div>
    

    </div>
              

      
</div>

<script>
    // Show/hide the reservation form
    function showReservationForm() {
        const form = document.getElementById('reservationForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function handleFormSubmit(event) {
        event.target.style.display = "none"; // Ocultar el formulario
    } 
    window.onload = function() {
        const form = document.getElementById('reservationForm');
        if (form) {
            form.style.display = 'none'; // Siempre inicia cerrado
        }
    };
</script>
</div>

        



        <footer>
            <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>