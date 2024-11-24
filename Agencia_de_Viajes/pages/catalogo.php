<?php 
include("../includes/header.php");
include("../includes/nav.php"); 
require '../src/Database.php'; // Asegúrate de que la conexión a la base de datos esté correcta

// Verificar si se han enviado filtros
$whereConditions = [];
$params = [];

// Filtro por destino
if (!empty($_GET['destino'])) {
    $whereConditions[] = "destino LIKE ?";
    $params[] = "%" . $_GET['destino'] . "%";
}

// Filtro por duración
if (!empty($_GET['duracion'])) {
    $whereConditions[] = "duracion LIKE ?";
    $params[] = "%" . $_GET['duracion'] . "%";
}

// Filtro por rango de precio
if (!empty($_GET['precio_min']) && is_numeric($_GET['precio_min'])) {
    $whereConditions[] = "precio >= ?";
    $params[] = $_GET['precio_min'];
}

if (!empty($_GET['precio_max']) && is_numeric($_GET['precio_max'])) {
    $whereConditions[] = "precio <= ?";
    $params[] = $_GET['precio_max'];
}

$whereSQL = '';
if (!empty($whereConditions)) {
    $whereSQL = " WHERE " . implode(" AND ", $whereConditions);
}

// Consulta para obtener los paquetes filtrados
$sql = "SELECT id, nombre, destino, descripcion, imagen, precio, duracion FROM paquetes" . $whereSQL;
$stmt = $PDO->prepare($sql);
$stmt->execute($params);
$paquetes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Viajes</title>
    <link rel="stylesheet" href="../assets/CSS/style.css">
    <style>
        .filter-section {
            background-color: #f7f7f7;
            padding: 20px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .filter-group input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-button {
           
            padding: 5px 10px;
            background-color: #009688;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filter-button:hover {
            background-color: #00796b;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="Titulo"><h2>Catálogo de paquetes</h2></div>
    
    <!-- Sección de Filtros -->
    <section class="filter-section">
        <form action="catalogo.php" method="GET" class="filter-form">
            <!-- Filtro por Destino -->
            <div class="filter-group">
                <label for="destino">Destino:</label>
                <input type="text" id="destino" name="destino" value="<?php echo htmlspecialchars($_GET['destino'] ?? ''); ?>" placeholder="Ej: París, Egipto ">
            </div>

            <!-- Filtro por Duración -->
            <div class="filter-group">
                <label for="duracion">Duración:</label>
                <input type="text" id="duracion" name="duracion" value="<?php echo htmlspecialchars($_GET['duracion'] ?? ''); ?>" placeholder="Ej: 7 días">
            </div>

            <!-- Filtro por Precio (mínimo) -->
            <div class="filter-group">
                <label for="precio_min">Precio mínimo (USD):</label>
                <input type="number" id="precio_min" name="precio_min" value="<?php echo htmlspecialchars($_GET['precio_min'] ?? ''); ?>" placeholder="Min: 2299">
            </div>

            <!-- Filtro por Precio (máximo) -->
            <div class="filter-group">
                <label for="precio_max">Precio máximo (USD):</label>
                <input type="number" id="precio_max" name="precio_max" value="<?php echo htmlspecialchars($_GET['precio_max'] ?? ''); ?>" placeholder="Max. 7400">
            </div>

            <!-- Botón para filtrar -->
            <button type="submit" class="filter-button">Filtrar</button>
        </form>
    </section>

    <!-- Sección de Paquetes Destacados -->
    <section class="featured-packages">
        <div class="container">
            <?php if (!empty($paquetes)): ?>
                <?php foreach ($paquetes as $paquete): ?>
                    <div class="package" onclick="window.location.href='../pages/detalles.php?id=<?php echo htmlspecialchars($paquete['id']); ?>';" style="cursor: pointer;">
                        <img src="../uploads/<?php echo htmlspecialchars($paquete['imagen']); ?>" alt="<?php echo htmlspecialchars($paquete['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($paquete['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($paquete['descripcion']); ?></p>
                        <p><strong>Precio:</strong> $<?php echo htmlspecialchars($paquete['precio']); ?></p>
                        <p><strong>Duración:</strong> <?php echo htmlspecialchars($paquete['duracion']); ?></p>
                        <a href="../pages/detalles.php?id=<?php echo htmlspecialchars($paquete['id']); ?>" class="cta-button">Ver más</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron paquetes que coincidan con los filtros.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
