<?php
include_once "../conexionesBD.php";
$conexion = conectarBD();

// Obtener el ID del producto desde el parámetro GET
$idProducto = $_GET['idProducto'];

// Consulta para obtener la cantidad disponible en inventario
$sql = "SELECT existencia FROM producto WHERE id = '$idProducto'";
$resultado = mysqli_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if ($resultado) {
    $producto = mysqli_fetch_assoc($resultado);
    echo $producto['existencia'];  // Retorna la cantidad disponible
} else {
    echo "Error al obtener cantidad disponible.";
}

mysqli_close($conexion);
?>
