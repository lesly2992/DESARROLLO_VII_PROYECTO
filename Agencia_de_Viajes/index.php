<?php include("includes/header.php");
include("includes/nav.php"); 
require 'src/Database.php'; // Asegúrate de que la conexión a la base de datos esté correcta

// Consulta para obtener los paquetes destacados
$sql = "SELECT nombre, destino, descripcion, imagen FROM paquetes";
$stmt = $PDO->prepare($sql);
$stmt->execute();
$paquetes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Viajes</title>
    <link rel="stylesheet" href="assets/CSS/style.css">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Explora el Mundo con Nuestra Agencia</h1>
            <p>Encuentra los mejores destinos y paquetes de viajes.</p>
            <a href="pages/packages.php" class="cta-button">Ver Paquetes</a>
        </div>
    </section>

     <!-- Sección de Paquetes Destacados -->
     <section class="featured-packages">
        <div class="container">
            <h2>Paquetes Destacados</h2>
            <?php foreach ($paquetes as $paquete): ?>
                <div class="package">
                    <img src="uploads/<?php echo htmlspecialchars($paquete['imagen']); ?>" alt="<?php echo htmlspecialchars($paquete['nombre']); ?>">
                    <h3><?php echo htmlspecialchars($paquete['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($paquete['descripcion']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

     <!-- Sección de Paquetes De Viajes -->
     <section class="featured-packages">
        <div class="container">
            <h2>Paquetes Destacados</h2>
            <div class="package">
                <img src="assets/images/destino1.jpg" alt="Destino 1">
                <h3>Paquete a París</h3>
                <p>Disfruta de la ciudad del amor con un tour completo de 7 días.</p>
            </div>
            <div class="package">
                <img src="assets/images/destino2.jpg" alt="Destino 2">
                <h3>Paquete a Nueva York</h3>
                <p>Explora la gran manzana con los mejores guías turísticos.</p>
            </div>
            <div class="package">
                <img src="assets/images/destino3.jpg" alt="Destino 3">
                <h3>Paquete a Tokio</h3>
                <p>Descubre la cultura japonesa con un viaje inolvidable.</p>
            </div>
        </div>
    </section>

    <!-- Sección de Contacto -->
    <section class="contact">
        <div class="container">
            <h2>Contáctanos</h2>
            <form action="pages/contact.php" method="post">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Mensaje:</label>
                <textarea id="message" name="message" required></textarea>

                <input type="submit" value="Enviar">
            </form>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>
</body>
</html>
