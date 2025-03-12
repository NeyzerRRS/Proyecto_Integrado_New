<?php
    include "../conexionesBD.php";
    $conexion = conectarBD();

    // Verificar si cada campo existe antes de procesarlo
    $nomPcto = isset($_POST['nombre']) ? mysqli_real_escape_string($conexion, $_POST['nombre']) : null;
    $cantidadPcto = isset($_POST['cantidad']) ? mysqli_real_escape_string($conexion, $_POST['cantidad']) : null;
    $motivoPcto = isset($_POST['motivo']) ? mysqli_real_escape_string($conexion, $_POST['motivo']) : null;
    $importePcto = isset($_POST['importe']) ? mysqli_real_escape_string($conexion, $_POST['importe']) : null;
    $fecha = isset($_POST['fecha']) ? mysqli_real_escape_string($conexion, $_POST['fecha']) : null;
    $user = isset($_POST['nUsuario']) ? mysqli_real_escape_string($conexion, $_POST['nUsuario']) : null;

    // Verificar que todos los campos requeridos tengan valores válidos
    if (!$nomPcto || !$cantidadPcto || !$motivoPcto || !$importePcto || !$fecha || !$user) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Asegurar que la fecha esté en el formato adecuado
    $fechaFormateada = date('Y-m-d H:i:s', strtotime($fecha));

    // Verificar stock disponible antes de la inserción
    $consultaStock = mysqli_query($conexion, "SELECT existencia FROM producto WHERE id_producto = '$nomPcto'");
    $producto = mysqli_fetch_assoc($consultaStock);

    if (!$producto) {
        die("Error: Producto no encontrado en la base de datos.");
    }

    if ($producto['existencia'] < $cantidadPcto) {
        die("Error: No hay suficiente stock disponible para realizar la devolución.");
    }

    // Inserción de la devolución
    $sql = "INSERT INTO devolucion_cliente (id_producto, cantidad, id_motivo, importe, fecha, id_usuario) 
            VALUES ('$nomPcto', '$cantidadPcto', '$motivoPcto', '$importePcto', '$fechaFormateada', '$user')";

    try {
        $resultado = mysqli_query($conexion, $sql);
        if (!$resultado) {
            throw new Exception("Error al guardar la información de la devolución: " . mysqli_error($conexion));
        }

        // Si la inserción fue exitosa, actualizar la existencia del producto
        $sqlUpdate = "UPDATE producto SET existencia = existencia - $cantidadPcto WHERE id_producto = '$nomPcto'";
        $resultadoUpdate = mysqli_query($conexion, $sqlUpdate);
        
        if (!$resultadoUpdate) {
            throw new Exception("Error al actualizar la existencia del producto: " . mysqli_error($conexion));
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }

    mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guardar Devolución</title>
</head>
<body>
    <header>
        <div class="User">
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Devolución Registrada</h1>
    </header>
    <br>
    <?php include "../Menu.php"; ?>
    <br><br>
    <button type="submit" class="btn-Rv">
        <a href="registrar_devolucion.php?movimiento=alta&id=NULL">Volver a Registrar</a>
    </button><br><br>
    <button type="submit" class="btn-Rv">
        <a href="Devoluciones.php">Volver a Devoluciones</a>
    </button>
</body>
</html>

