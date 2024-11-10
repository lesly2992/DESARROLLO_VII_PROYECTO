<?php 
include("navAdmin.php");
require '../src/Database.php';

$errorMesage="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["Nombre_del_paquete"]) || empty($_POST["Destino"]) || empty ($_POST["Precio"]) || empty($_POST["Duracion"]) || empty($_POST["Image"]) || empty($_POST["Descripcion"])){
        $errorMesage= "Por favor complete todos los campos";
    }else{
        $nombrePaquete= $_POST["Nombre_del_Paquete"];
        $destinoPaquete= $_POST["Destino"];
        $precioPaquete= $_POST["Precio"];
        $duracionPaquete= $_POST["Duracion"];
        $descripcionPaquete= $_POST["Descripcion"];
        $imagenPaquete= basename($_FILES["Image"]["name"]); //asignamos la imagen
        $rutaImage="../uploads/" . $imagenPaquete;//asignamos la direccion de la imagen

        if(move_uploaded_file($_FILES["Image"]["tmp_name"], $rutaImage)){
            $sql="INSERT INTO paquetes (nombre, destino, descripcion, precio, duracion, imagen, estado, fecha_de_creacion) VALUES (:nombrePaquete, :destinoPaquete, :descripcionPaquete, :precioPaquete, :duracionPaquete, :imagenPaquete, 'admin')";

            $stmt= $PDO->prepare($sql);

            $stmt->bindParam(':nombre', $nombrePaquete);
            $stmt->bindParam(':destino', $destinoPaquete);
            $stmt->bindParam(':precio', $precioPaquete);
            $stmt->bindParam(':duracion', $duracionPaquete);
            $stmt->bindParam(':descripcion', $descripcionPaquete);
            $stmt->bindParam(':imagen', $imagenPaquete);

            if($stmt->execute()){
                echo "Paquete guardado exitosamente.";
            }else{
                $errorInfo = $stmt->errorInfo();
                echo "Hubo un error al guardar el paquete." . $errorInfo[2];
            }

        }else{
            $errorMesage ="Hubo un error al subir la imagen";
        }


    }
}

?>


    <div class="form-container">
        <form action="" method="post" enctype= "multipart/form-data">

            <!-- <div class="formGroup">
                <label for="id">id: </label> 
                <input type="id" id="id" name="id" required>
            </div> -->

            <div class="formGroup">
                <label for="Nombre_del_Paquete">Nombre del Paquete: </label> 
                <input type="text" id="Nombre_del_Paquete" name="Nombre_del_Paquete" required>
            </div>

            <div class="formGroup">
                <label for="Destino">Destino: </label> 
                <input type="text" id="Destino" name="Destino" required>
            </div>

            <div class="formGroup">
                <label for="Precio">Precio: </label> 
                <input type="text" id="Precio" name="Precio" step= "0.01" required>
            </div>

            <div class="formGroup">
                <label for="Duración">Duración: </label> 
                <input type="text" id="Duración" name="Duración" required>
            </div>

            <div class="formGroup">
                <label for="Descripcion">Descripción: </label> 
                <input type="text" id="Descripcion" name="Descripcion" required>
            </div>

            <div class="formGroup">
                <label for="Image ">Imagen : </label> 
                <input type="file" id="Image" name="Image" required>
            </div>

            <button class="btn-editar">Editar</button>
            <button class="btn-eliminar">Eliminar</button>
            <button type="submit" class="btn-guardar">Guardar</button>

        </form>
    </div>

