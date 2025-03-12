<?php
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'es_MX.UTF-8');

include_once "../conexionesBD.php";
$conexion = conectarBD();

$fecha_hoy = date('Y-m-d');
$nombre_dia =  utf8_encode(strftime('%A', strtotime($fecha_hoy)));
$nombre_dia = ucfirst($nombre_dia);

if (isset($_GET['id_venta'])) {
    $id_venta = $_GET['id_venta'];

    // Consulta para obtener los productos de la venta
    $sql = "SELECT p.nombre, dv.cantidad, p.precio, (dv.cantidad * p.precio) AS subtotal
            FROM detalle_venta AS dv
            INNER JOIN producto AS p ON dv.id_producto = p.id_producto
            WHERE dv.id_venta = $id_venta";


    $resultado = mysqli_query($conexion, $sql);
} else {
    echo "No se ha proporcionado un ID de venta válido.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Reporte Detallado de Venta</title>
</head>
<body>
    <header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
              <!--QUITAR EL 8080-->
            <form class="User_icon" action="http://localhost:8080/Proyecto_Integrado/logout.php" method="post">
            <button class="Btn">
                <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path><svg>
                </div>
            <div class="text">Cerrar sesión</div>
            </button>
        </form>
            <img class="User_icon" src="../Imagenes/IL.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Reporte Detallado de Venta</h1>
    </header>
    <?php include "../Menu.php"; ?><br>
    <?php
    $id_usuario = $_SESSION['id_usuario'];
    ?>
    <body>
        <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td><?php echo number_format($row['precio'], 2); ?></td>
                <td><?php echo number_format($row['subtotal'], 2); ?></td>
            </tr>
        <?php } ?>
    </table><br><br>
    <a href="consultar_reporteV.php">
        <button class="btn-Rv">Volver</button><br><br>
    </a>

</body>
</html>
