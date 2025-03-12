<?php
include_once "../conexionesBD.php";
$conexion = conectarBD();

if (isset($_GET['id'])) {
    $idProducto = intval($_GET['id']); // Validar y convertir a entero


    $sql = "UPDATE producto SET status = 1 WHERE id_producto = $idProducto";

    try {
        if (mysqli_query($conexion, $sql)) {
            header("Location:Alerta_reactivado.php?mensaje=reactivado"); // Redirecciona después de reactivar
            exit();
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($conexion);
        }
    } catch (mysqli_sql_exception $e) {
        die("Error al actualizar la información: " . $e->getMessage());
    }
} else {
    echo "ID de producto no válido.";
}

mysqli_close($conexion);
?>
