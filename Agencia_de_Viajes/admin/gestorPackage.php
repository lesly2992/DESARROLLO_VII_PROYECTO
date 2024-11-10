<?php
include("navAdmin.php");
require '../src/Database.php';

// Activar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

$errorMesage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        //verifica que todos los campos del formulario esten llenos
        if (empty($_POST["Nombre_del_Paquete"]) || 
            empty($_POST["Destino"]) || 
            empty($_POST["Precio"]) || 
            empty($_POST["Duración"]) || 
            empty($_POST["Descripcion"]) || 
            empty($_FILES["Image"]["name"])) {
            
            $errorMesage = "Por favor complete todos los campos";
        } else {
            //$variable = $_POST["name del formulario"];

            $nombre = $_POST["Nombre_del_Paquete"];
            $destino = $_POST["Destino"];
            $precio = $_POST["Precio"];
            $duracion = $_POST["Duración"];
            $descripcion = $_POST["Descripcion"];
            
            // Manejo de la imagen
            $imagen = time() . '_' . basename($_FILES["Image"]["name"]);
            $rutaImage = "../uploads/" . $imagen; //ruta donde se guardara la imagen
            
            // Verificar si la carpeta uploads existe, si no, crearla
            if (!file_exists("../uploads")) {
                mkdir("../uploads", 0777, true);
            }
            
            //se sube la imagen
            if (move_uploaded_file($_FILES["Image"]["tmp_name"], $rutaImage)) {
                // script SQL para insertar los datos del formulario
                $sql = "INSERT INTO paquetes (nombre, destino, descripcion, precio, duracion, imagen, estado) 
                        VALUES (:nombre, :destino, :descripcion, :precio, :duracion, :imagen, 'activo')";
                
                $stmt = $PDO->prepare($sql);
                
                // Vinculación de parámetros con los nombres exactos de las columnas
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':destino', $destino);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':precio', $precio);
                $stmt->bindParam(':duracion', $duracion);
                $stmt->bindParam(':imagen', $imagen);
                
                if ($stmt->execute()) {
                    echo "<script>alert('Paquete guardado exitosamente.');</script>";
                    // Opcional: redirigir después de guardar
                    // header("Location: lista_paquetes.php");
                } else {
                    $errorInfo = $stmt->errorInfo();
                    $errorMesage = "Error al guardar el paquete: " . $errorInfo[2];
                }
            } else {
                $errorMesage = "Error al subir la imagen. Ruta: " . $rutaImage;
            }
        }
    } catch (PDOException $e) {
        $errorMesage = "Error en la base de datos: " . $e->getMessage();
    } catch (Exception $e) {
        $errorMesage = "Error general: " . $e->getMessage();
    }
}

// Mostrar mensaje de error si existe
if (!empty($errorMesage)) {
    echo "<div style='color: red; padding: 10px; margin: 10px 0; border: 1px solid red;'>$errorMesage</div>";
}
?>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="formGroup">
            <label for="Nombre_del_Paquete">Nombre del Paquete: </label> 
            <input type="text" id="Nombre_del_Paquete" name="Nombre_del_Paquete" maxlength="100" required>
        </div>

        <div class="formGroup">
            <label for="Destino">Destino: </label> 
            <input type="text" id="Destino" name="Destino" maxlength="100" required>
        </div>

        <div class="formGroup">
            <label for="Precio">Precio: </label> 
            <input type="number" id="Precio" name="Precio" step="0.01" required>
        </div>

        <div class="formGroup">
            <label for="Duración">Duración: </label> 
            <input type="text" id="Duración" name="Duración" maxlength="50" required>
        </div>

        <div class="formGroup">
            <label for="Descripcion">Descripción: </label> 
            <textarea id="Descripcion" name="Descripcion" required></textarea>
        </div>

        <div class="formGroup">
            <label for="image">Imagen: </label> 
            <input type="file" id="image" name="Image" accept="image/*" required>
        </div>

        <button type="submit" class="btn-guardar">Guardar</button>
        <button type="button" class="btn-editar">Editar</button>
        <button type="button" class="btn-eliminar">Eliminar</button>
    </form>

<!-- Tabla de Registro -->
<!-- <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre del Paquete</th>
            <th>Destino</th>
            <th>Precio</th>
            <th>Duración</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($paquetes as $paquete) { ?>
        <tr>
            <td><?php echo $paquete['id']; ?></td>
            <td><?php echo $paquete['nombre']; ?></td>
            <td><?php echo $paquete['destino']; ?></td>
            <td><?php echo $paquete['precio']; ?></td>
            <td><?php echo $paquete['duracion']; ?></td>
            <td><?php echo $paquete['descripcion']; ?></td>
            <td><img src="../uploads/<?php echo $paquete['imagen']; ?>" width="50" alt="Imagen de <?php echo $paquete['nombre']; ?>"></td>
        </tr>
        <?php } ?>
    </tbody>
</table> -->

</div>