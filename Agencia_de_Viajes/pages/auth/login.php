<?php 
session_start();
// explicarme esta pagina
include("../includes/nav.php");
require '../src/Database.php';



// Inicializamos variables para errores
$errorMessage="";

//Validacion del form
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //verificacion de campos vacios
    if(empty($_POST["email"]) || empty($_POST["password"])){
        $errorMessage ="Por favor completa todos los campos.";
    }else{
        $email= $_POST["email"];
        $password= $_POST["password"];

        //consulta de busqueda de usuario por email
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $PDO->prepare($sql);
        $stmt -> bindParam(':email', $email);
        $stmt -> execute();
        $user = $stmt -> fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])){
            //guardamos los datos del usuario en la sesion
            $_SESSION['user_id'] = $user['id']; //almacenamos el id del usuario
            $_SESSION['username'] = $user['username']; // almacenamos el nombre

            //redirigimos a la pagina de tracking del usuario
            //header("location: ../tracking.php"); esta direccion estaba mal puesta
            header("location:/Agencia_de_Viajes/pages/tracking.php");
            exit;
        }else{
            //mensaje de error
            $errorMessage = "Correo electronico o constrasena incorrecta.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/CSS/style.css"/>
</head>
<body>
    <form action="" method="POST" class="formLogin">

        <div class="title">
            <h2>Login</h2>
        </div>

        <!-- Mensaje de error -->
         <?php if(!empty($errorMessage)): ?>
         <div class="error_message" style="color: red; padding:10px 0px">
            <?php echo $errorMessage; ?>
         </div>
         <?php endif;?>
         <!-- fin de la condicion -->

        <div class="formGroup">
            <label for="email">Email: </label> 
            <input type="email" id= "email" name= "email" require>
        </div>

        <div class="formGroup password-container">
            <label for="password">Contraseña: </label>
            <input type="password" id="password" name="password">
            <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
        </div>

        <div class="btn_container">
            <button type="submit" class="btn_login">Start</button>
        </div>

        <div class="message">
            <p>Aún no estas registrado? <a href="register.php">Registrate</a></p>
        </div>

        <div class="message-recovery">
            <p>Olvidaste tu contrasena? <a href="#">Recuperar Contraseña</a></p>
        </div>

    </form>

    <script src="../assets/js/togglePassword.js"></script>
</body>
</html>
