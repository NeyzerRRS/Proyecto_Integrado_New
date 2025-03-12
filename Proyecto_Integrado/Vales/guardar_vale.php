<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Papelería UNES</title>
</head>
<body>
    <header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
            <!--QUITAR EL 8080-->
            <form class="User_icon" action="http://localhost:/Proyecto_Integrado/logout.php
" method="post">
            <button class="Btn">
                <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path><svg>
                </div>
            <div class="text">Cerrar sesión</div>
            </button>
        </form>
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Registrar Vale</h1>
    </header>
    
    <?php include "../Menu.php"; ?><br><br>


<?php
include_once "../conexionesBD.php";
$conexion = conectarBD();

$id_usuario = $_SESSION['id_usuario'];  // Obtener el ID del usuario desde la sesión
$fecha = date("Y-m-d");  // Obtener la fecha actual
$status = 1;  // Estado del vale

// Capturar los valores del primer producto
$coordinacion = isset($_POST['coordinacion_1']) ? $_POST['coordinacion_1'] : null;
$recibio = isset($_POST['recibio_1']) ? $_POST['recibio_1'] : null;

// Manejar la evidencia del primer producto (si existe)
$evidencia = null;
if (isset($_FILES['evidencia_1']) && $_FILES['evidencia_1']['error'] === UPLOAD_ERR_OK) {
    $ruta_destino = '../uploads/' . basename($_FILES['evidencia_1']['name']);
    move_uploaded_file($_FILES['evidencia_1']['tmp_name'], $ruta_destino);
    $evidencia = $ruta_destino;
}

// Insertar el vale en la base de datos
$sql_vale = "INSERT INTO vales (id_usuario, coordinacion, recibio, fecha, evidencia, status) 
             VALUES ('$id_usuario','$coordinacion','$recibio', '$fecha', '$evidencia', '$status')";

if ($conexion->query($sql_vale) === TRUE) {
    // Obtener el ID del vale insertado
    $id_vale = $conexion->insert_id;

    // Obtener el número de productos
    $numProductos = $_POST['numProductos'];

    // Procesar cada producto
    for ($i = 1; $i <= $numProductos; $i++) {
        $id_producto = $_POST["idProducto_$i"];
        $cantidad = $_POST["cantidad_$i"];

        $sql_pctosVl = "INSERT INTO pctos_vale (id_vale, id_producto, cantidad, status) 
                        VALUES ('$id_vale', '$id_producto', '$cantidad', '$status')";
        
        if ($conexion->query($sql_pctosVl) === TRUE)
        {
            $sql_actualizar = "UPDATE producto SET existencia = existencia - $cantidad WHERE id_producto = '$id_producto'";
            if (!$conexion->query($sql_actualizar)) {
                die("Error al actualizar la existencia: " . $conexion->error);
            }
        } else 
        {
            die("Error al registrar el detalle: " . $conexion->error);
        }
    }?>
     <h1>El vale se registro correctamente</b></h1>
    <br><br>
<?php
} 
else {?>
     <h1>Huvo un error al registrar el vale</b></h1>
    <br><br>
<?php
}
?>
    <a href="Registrar_Vale.php">
        <button class="btn-Rv" type="submit">Volver a Registrar</button>
    </a>
</body>
</html>
<?php
$conexion->close();
?>
