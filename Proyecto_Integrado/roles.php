<?php
session_start();
// Recuperar el ID del usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'];

// Obtener el rol del usuario desde la base de datos
$query = "SELECT tipo_usuario AS rol FROM usuarios WHERE id_usuario = $id_usuario";
$result = $conexion->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $rol = $row['rol'];
} else {
    echo "Error al obtener el rol del usuario.";
    session_destroy(); // Cerrar sesión en caso de error crítico
    //Aqui solo borra el 8080 para que furule
    header("Location: http://localhost:8080/Proyecto_Integrado/index.php");
    exit();
}
/*
<!--Opcional: Manejo adicional según roles-->
<?php if ($rol == 'Administrativo') {?>

<?php } elseif ($rol == 'Encargado') {?>
    // Código específico para encargados
<?php } else {
    echo "Rol no reconocido.";
    session_destroy();
    header("Location: index.php");
    exit();
}?>
*/
?>
