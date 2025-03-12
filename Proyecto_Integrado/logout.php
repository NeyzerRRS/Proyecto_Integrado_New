<?php
session_start(); // Iniciar sesión para acceder a los datos actuales

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
//Aqui solo borra el 8080 para que furule
header("Location: http://localhost:/Proyecto_Integrado/index.php");
exit();
?>
