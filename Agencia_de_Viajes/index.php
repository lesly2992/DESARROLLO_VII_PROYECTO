<?php include("includes/header.php");
include("includes/nav.php"); 
require 'src/Database.php'; // Asegúrate de que la conexión a la base de datos esté correcta

// Consulta para obtener los paquetes destacados
$sql = "SELECT id, nombre, destino, descripcion, imagen FROM paquetes";
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
            <a href="pages/catalogo.php" class="cta-button">Ver Paquetes</a>
        </div>
    </section>

    <div class="Titulo"><h2>Paquetes Destacados</h2></div>

   <!-- Sección de Paquetes Destacados -->
   <section class="featured-packages">
   
   <div class="container">
    <?php 
    // Selección de los paquetes específicos por ID
    $paquetes_a_mostrar = array_filter($paquetes, function($paquete) {
        return in_array($paquete['id'], [1, 2, 4, 5, 10, 7, 13, 9]);
    });

    // Recorrer los paquetes seleccionados
    foreach ($paquetes_a_mostrar as $paquete): ?>
        <div class="package" onclick="window.location.href='pages/detalles.php?id=<?php echo htmlspecialchars($paquete['id']); ?>';" style="cursor: pointer;">
            <img src="uploads/<?php echo htmlspecialchars($paquete['imagen']); ?>" alt="<?php echo htmlspecialchars($paquete['nombre']); ?>">
            <h3><?php echo htmlspecialchars($paquete['nombre']); ?></h3>
            <p><?php echo htmlspecialchars($paquete['descripcion']); ?></p>
            <p><br></p>
            <a href="pages/detalles.php?id=<?php echo htmlspecialchars($paquete['id']); ?>" class="cta-button">Ver más</a>
        </div>
    <?php endforeach; ?>
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
