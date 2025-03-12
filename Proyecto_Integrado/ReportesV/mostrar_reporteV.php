<?php
include_once "../conexionesBD.php";
$conexion = conectarBD();

/*if (isset($_POST['fecha_inicio'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
}else{
    $fecha_inicio = $_POST["fecha_inicio'"];
}*/

$fecha_inicio = $_POST['fecha_inicio'] ?? date('Y-m-d');
$fecha_fin = $_POST['fecha_fin'] ?? date('Y-m-d');
$usuario = $_POST['usuario'] ?? '';

$sql = "SELECT v.id_venta, v.fecha, u.nombre AS usuario, SUM(p.precio * dv.cantidad) AS total ";
$sql .= "FROM usuarios AS u ";
$sql .= "INNER JOIN ventas AS v ON u.id_usuario = v.id_usuario ";
$sql .= "INNER JOIN detalle_venta AS dv ON v.id_venta = dv.id_venta ";
$sql .= "INNER JOIN producto AS p ON dv.id_producto = p.id_producto ";
$sql .= "WHERE v.status = 1 AND dv.status = 1";

if (!empty($fecha_inicio) && empty($fecha_fin)) {
    $sql .= " AND v.fecha = '$fecha_inicio'";
}
if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $sql .= " AND v.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
}
if (!empty($usuario)) {
    $sql .= " AND u.id_usuario = '$usuario'";
}

$sql .= " GROUP BY v.id_venta ORDER BY v.fecha ASC";
$resultado = mysqli_query($conexion, $sql);

$total_general = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Reporte de Ventas</title>
</head>
<body>
    <header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
            <!--QUITAR EL 8080-->
            <form class="User_log" action="http://localhost:/Proyecto_Integrado/logout.php" method="post">
            <button class="Btn">
                <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path><svg>
                </div>
            <div class="text">Cerrar sesión</div>
            </button>
        </form>
          <!-- Botón de ayuda -->
        <form class="User_help" action="../Ayuda/ayuda.php" method="get">
            <button class="faq-button">
                    <svg viewBox="0 0 320 512">
                        <path d="M80 160c0-35.3 28.7-64 64-64h32c35.3 0 64 28.7 64 64v3.6c0 21.8-11.1 42.1-29.4 53.8l-42.2 27.1c-25.2 16.2-40.4 44.1-40.4 74V320c0 17.7 14.3 32 32 32s32-14.3 32-32v-1.4c0-8.2 4.2-15.8 11-20.2l42.2-27.1c36.6-23.6 58.8-64.1 58.8-107.7V160c0-70.7-57.3-128-128-128H144C73.3 32 16 89.3 16 160c0 17.7 14.3 32 32 32s32-14.3 32-32zm80 320a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"></path>
                    </svg>
            <span class="tooltip">Ayuda</span>
        </button>
        </form>
            <img class="User_icon" src="../Imagenes/Colegio.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Reporte de Ventas</h1>
    </header>
        <?php include "../Menu.php"; ?><br>
    <?php if ($resultado && $resultado->num_rows > 0){?>
    <table class="Tb-Rv">
        <thead>
            <tr>
                <th style="display: none;">ID Venta</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Importe Total</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($repV = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td style="display: none;"><?php echo $repV['id_venta']; ?></td>
                <td><?php echo $repV['fecha']; ?></td>
                <td><?php echo $repV['usuario']; ?></td>
                <td><?php echo number_format($repV['total'], 2); ?></td>
                <td class='icono'>
                    <a href='reporteDT.php?id_venta= <?php echo $repV['id_venta'];?>'>
                        <img class='icono1' src='../Imagenes/RPD.png'>
                    </a>
                </td>
            </tr>
            <?php $total_general += $repV['total']; ?>
            <?php } ?>   
        </tbody>
    </table>
        <h2 class="Tt-Rv">Total de Ventas: $<?php echo number_format($total_general, 2); ?></h2>
    <?php }
        else{ ?>
            <div class="No_Encontrado">No se encontaron Ventas</div>
    <?php }?>
    <a href="consultar_reporteV.php">
        <button class="btn-Rv" type="submit">Volver</button>
    </a>
</body>
</html>
<?php
mysqli_close($conexion);
?>
