<?php
session_start();//inicia o reanuda una session existente

session_unset();//destruye todas las variables de la sesion

session_destroy();//destruye toda la data registrada en la sesion

header("location: login.php"); //redirige al login

exit;

?>