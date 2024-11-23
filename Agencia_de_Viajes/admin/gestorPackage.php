<?php
include("navAdmin.php");
require '../src/Database.php';

// Activar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

$errorMesage = "";

//ACCION DEL BOTON CANCELAR
if (isset($_POST['action']) && $_POST['action'] == 'cancelar') {
    // Redirigir a la misma página para "limpiar" el formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Procesar ELIMINACION si se recibe la acción
if (isset($_POST['action']) && $_POST['action'] == 'eliminar' && isset($_POST['paquete_id'])) {
    try {
        $stmt = $PDO->prepare("DELETE FROM paquetes WHERE id = ?");
        if ($stmt->execute([$_POST['paquete_id']])) {
            echo "<script>alert('Paquete eliminado exitosamente.');</script>";
        }
    } catch (PDOException $e) {
        $errorMesage = "Error al eliminar: " . $e->getMessage();
    }
}

// Tu código original de guardar
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    try {
        //guardar el formulario en la base de datos
        //verifica que todos los campos del formulario esten llenos
        if (empty($_POST["Nombre_del_Paquete"]) || 
            empty($_POST["Destino"]) || 
            empty($_POST["Precio"]) || 
            empty($_POST["Duración"]) || 
            empty($_POST["Descripcion"]) || 
            (empty($_FILES["Image"]["name"]) && empty($_POST['paquete_id']))) {
            
            $errorMesage = "Por favor complete todos los campos";
        } else {
            //$variable = $_POST["name del formulario"];
            $nombre = $_POST["Nombre_del_Paquete"];
            $destino = $_POST["Destino"];
            $precio = $_POST["Precio"];
            $duracion = $_POST["Duración"];
            $descripcion = $_POST["Descripcion"];
            $paquete_id = $_POST["paquete_id"] ?? null;
            
            // Manejo de la imagen
            $imagen = null;
            if (!empty($_FILES["Image"]["name"])) {
                $imagen = time() . '_' . basename($_FILES["Image"]["name"]);
                $rutaImage = "../uploads/" . $imagen;
                
                if (!file_exists("../uploads")) {
                    mkdir("../uploads", 0777, true);
                }
                
                if (move_uploaded_file($_FILES["Image"]["tmp_name"], $rutaImage)) {
                    if ($paquete_id) {
                        // Si es una actualización
                        $sql = "UPDATE paquetes SET 
                                nombre = :nombre, 
                                destino = :destino, 
                                descripcion = :descripcion, 
                                precio = :precio, 
                                duracion = :duracion" . 
                                ($imagen ? ", imagen = :imagen" : "") . 
                                " WHERE id = :id";
                                
                        $stmt = $PDO->prepare($sql);
                        
                        $params = [
                            ':nombre' => $nombre,
                            ':destino' => $destino,
                            ':descripcion' => $descripcion,
                            ':precio' => $precio,
                            ':duracion' => $duracion,
                            ':id' => $paquete_id
                        ];
                        
                        if ($imagen) {
                            $params[':imagen'] = $imagen;
                        }
                        
                        if ($stmt->execute($params)) {
                            echo "<script>alert('Paquete actualizado exitosamente.');</script>";
                        }
                    } else {
                        // Tu código original para insertar
                        $sql = "INSERT INTO paquetes (nombre, destino, descripcion, precio, duracion, imagen, estado) 
                                VALUES (:nombre, :destino, :descripcion, :precio, :duracion, :imagen, 'activo')";
                        
                        $stmt = $PDO->prepare($sql);
                        $stmt->bindParam(':nombre', $nombre);
                        $stmt->bindParam(':destino', $destino);
                        $stmt->bindParam(':descripcion', $descripcion);
                        $stmt->bindParam(':precio', $precio);
                        $stmt->bindParam(':duracion', $duracion);
                        $stmt->bindParam(':imagen', $imagen);
                        
                        if ($stmt->execute()) {
                            echo "<script>alert('Paquete guardado exitosamente.');</script>";
                        }
                    }
                } else {
                    $errorMesage = "Error al subir la imagen. Ruta: " . $rutaImage;
                }
            } else if ($paquete_id) {
                // Actualización sin cambiar la imagen
                $sql = "UPDATE paquetes SET 
                        nombre = :nombre, 
                        destino = :destino, 
                        descripcion = :descripcion, 
                        precio = :precio, 
                        duracion = :duracion 
                        WHERE id = :id";
                
                $stmt = $PDO->prepare($sql);
                if ($stmt->execute([
                    ':nombre' => $nombre,
                    ':destino' => $destino,
                    ':descripcion' => $descripcion,
                    ':precio' => $precio,
                    ':duracion' => $duracion,
                    ':id' => $paquete_id
                ])) {
                    echo "<script>alert('Paquete actualizado exitosamente.');</script>";
                }
            }
        }
    } catch (PDOException $e) {
        $errorMesage = "Error en la base de datos: " . $e->getMessage();
    } catch (Exception $e) {
        $errorMesage = "Error general: " . $e->getMessage();
    }
}

// Consulta para obtener los paquetes
$sql = "SELECT * FROM paquetes";
$stmt = $PDO->query($sql);
$paquetes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mostrar mensaje de error si existe
if (!empty($errorMesage)) {
    echo "<div style='color: red; padding: 10px; margin: 10px 0; border: 1px solid red;'>$errorMesage</div>";
}
?>


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .container-form-table {
        display: flex;
        justify-content: space-between; /* Asegura que haya espacio entre los contenedores */
        gap: 20px; /* Espaciado entre los contenedores */
        width: calc(100% - 220px); /* Ajusta el ancho considerando el ancho del nav */
        margin-left: 220px; /* Mueve el contenido a la derecha del nav */
        background-color: #f4f4f4;
        padding: 20px;
       /*  border: 2px solid black; Opcional: para visualizar los bordes */
        align-items: stretch; /* Asegura que ambos contenedores tengan el mismo alto */
    }

    .form-container,
    .table-container {
        flex: 1; /* Ambos contenedores ocuparán el mismo ancho */
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        height: auto; /* Ajusta al contenido */
        min-height: 300px; /* Establece un mínimo para evitar colapsos */
    }

    .table-container {
        overflow: auto; /* Permite desplazamiento si el contenido excede */
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }

    button {
        margin-right: 10px;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        color: #fff;
    }

    .btn-guardar {
        background-color: #4caf50;
    }

    .btn-cancelar {
        background-color: #2196f3;
    }

    .btn-eliminar {
        background-color: #f44336;
    }
    .btn-seleccionar {
        background-color: grey;
    }

    .btn-guardar:hover {
        background-color: #45a049;
    }

    .btn-cancelar:hover {
        background-color: #1976d2;
    }

    .btn-eliminar:hover {
        background-color: #d32f2f;
    }
    .btn-seleccionar:hover{
        background-color: gainsboro;
    }
</style>

<div class="container-form-table">
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" id="paquete_id" name="paquete_id" value="">
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
                <input type="file" id="image" name="Image" accept="image/*">
                <div id="imagen_actual"></div>
            </div>
            <button type="submit" class="btn-guardar">Guardar</button>
            <button type="submit" name="action" value="cancelar" class="btn-cancelar">Cancelar</button>
            <button type="submit" class="btn-eliminar" name="action" value="eliminar" 
                    onclick="return confirm('¿Está seguro de eliminar este paquete?');" 
                    style="display: none;">Eliminar</button>
        </form>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Destino</th>
                    <th>Precio</th>
                    <th>Duración</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paquetes as $paquete) : ?>
                    <tr>
                        <td><?php echo $paquete['id']; ?></td>
                        <td><?php echo htmlspecialchars($paquete['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($paquete['destino']); ?></td>
                        <td><?php echo htmlspecialchars($paquete['precio']); ?></td>
                        <td><?php echo htmlspecialchars($paquete['duracion']); ?></td>
                        <td>
                            <img src="../uploads/<?php echo htmlspecialchars($paquete['imagen']); ?>" 
                                 alt="Imagen del paquete" style="max-width: 100px; height: auto;">
                        </td>
                        <td>
                            <button class="btn-seleccionar" onclick="seleccionarPaquete(<?php 
                                echo htmlspecialchars(json_encode($paquete)); 
                            ?>)">Seleccionar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function seleccionarPaquete(paquete) {
        // Asignar valores del paquete al formulario
        document.getElementById('paquete_id').value = paquete.id;
        document.getElementById('Nombre_del_Paquete').value = paquete.nombre;
        document.getElementById('Destino').value = paquete.destino;
        document.getElementById('Precio').value = paquete.precio;
        document.getElementById('Duración').value = paquete.duracion;
        document.getElementById('Descripcion').value = paquete.descripcion;
        
        // Mostrar imagen actual
        document.getElementById('imagen_actual').innerHTML = 
            '<img src="../uploads/' + paquete.imagen + 
            '" alt="Imagen actual" style="max-width: 100px; margin-top: 10px;">';
        
        // Hacer el input de imagen opcional
        document.getElementById('image').removeAttribute('required');
        
        // Mostrar botón de eliminar
        document.querySelector('.btn-eliminar').style.display = 'inline-block';
    }
</script>


