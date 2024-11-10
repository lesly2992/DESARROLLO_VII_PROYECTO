<?php 
include("../includes/nav.php"); 
require '../src/Database.php';

$errorMessage="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["username"]) || empty($_POST["email"]) || empty ($_POST["password"])){
        $errorMessage= "Por favor completa todos los campos";
    }else {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"]; 

        //encriptacion de contrasena
        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

        //verificamos el correo electronico, que no haya uno igual previamente registrado
        $verifyEmailSql= "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $verifyEmailStmt= $PDO -> prepare($verifyEmailSql);
        $verifyEmailStmt->bindParam(':email', $email);
        $verifyEmailStmt->execute();
        $emailExist= $verifyEmailStmt->fetchColumn();

        if($emailExist > 0 ){
            $errorMessage ="El correo electronico ya esta registrado. Por favor, usa otro diferente";
        }else{
            //preparamos la base de datos
            $sql= "INSERT INTO usuarios (username, email, password, rol) VALUES (:username, :email, :password, 'usuario')";
            $stmt= $PDO -> prepare($sql);

            //stmt= statement
            //vinculamos los valores a los statement
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            //ejecutamos la consulta
            if($stmt->execute()){
                $successMessage = "Registro exitoso. Ahora puedes iniciar sesion.";
            }else{
                $errorMessage = "Hubo un error al registrar al usuario. Itentato de nuevo.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../assets/CSS/style.css"/>
</head>
<body>
    <form action="" method="POST" class="formLogin">
        
        <div class="title">
            <h2>Registrate</h2>
        </div>
        <!-- Mensaje de exitoso registro -->
         <?php if(!empty ($successMessage)): ?>
            <div class="success_message" style= "color: green; padding: 10px 0px">
                <?php echo $successMessage?>
            </div>
        <?php endif?>
        <!-- fin de la condicion -->

        <!-- Mensaje de error -->
         <?php if(!empty($errorMessage)): ?>
            <div class="error_message" style = "color: white; padding: 10px 0px">
                <?php echo $errorMessage; ?>
            </div>
         <?php endif?>
        <!-- fin de la condicion -->

        <div class="formGroup">
            <label for="username">Nombre de Usuario: </label>
            <input type="text" id= "username" name= "username">
        </div>
        <div class="formGroup">
            <label for="email">Email: </label>
            <input type="text" id= "email" name= "email">
        </div>
        <div class="formGroup password-container">
            <label for="password">Contraseña: </label>
            <input type="password" id= "password" name= "password">
            <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
        </div>
        <!-- <div class="formGroup password-container">
            <label for="passwordConfirm">Confirma Contraseña : </label>
            <input type="password" id= "passwordConfirm" name= "passwordConfirm">
            <span class="toggle-passwordRegister" onclick="togglePasswordVisibility()">👁️</span>
        </div> -->

        <div class="btn_container">
            <button type="submit" class="btn_login">Registrarse</button>
        </div>

        <div class="message">
            <p>Ya tienes tienes una cuenta? <a href="login.php"> Entrar</a></p>
        </div>

    </form>

    <script src="../assets/js/togglePassword.js"></script>
</body>
</html>
