<?php
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'es_MX.UTF-8');

include_once "../conexionesBD.php";
$conexion = conectarBD();

$fecha_hoy = date('Y-m-d');
$dias = [
    'Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 
    'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'
];
$nombre_dia = ucfirst($dias[date('l', strtotime($fecha_hoy))]); // Obtiene el nombre del día en español
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Consultar Reporte de Ventas</title>
</head>
<body>
    <header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
            <form class="User_log" action="http://localhost/Proyecto_Integrado/logout.php" method="post">
                <button class="Btn">
                    <div class="sign">
                        <svg viewBox="0 0 512 512">
                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                        </svg>
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

    <?php

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: http://localhost/Proyecto_Integrado/index.php");
        exit();
    }

    $id_usuario = $_SESSION['id_usuario'];

    // Obtener el rol del usuario
    $query = "SELECT tipo_usuario AS rol FROM usuarios WHERE id_usuario = $id_usuario";
    $result = $conexion->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $rol = $row['rol'];
    } else {
        echo "Error al obtener el rol del usuario.";
        session_destroy();
        header("Location: http://localhost/Proyecto_Integrado/index.php");
        exit();
    }
    ?>

    <?php if ($rol == 'Administrativo') { ?>
        <form class="Fil-Rv" method="POST" action="mostrar_reporteV.php">
            <label class="cont-Rv" for="fecha_inicio">Fecha de Inicio:</label>
            <input class="cont-Rv" type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d'); ?>" required>

            <label class="cont-Rv" for="fecha_fin">Fecha de Fin:</label>
            <input class="cont-Rv" type="date" id="fecha_fin" name="fecha_fin" value="<?php echo date('Y-m-d'); ?>">

            <label class="cont-Rv" for="usuario">Usuario:</label>
            <select class="cont-Rv" name="usuario" id="usuario">
                <option value="">Todos</option>
                <?php
                $sql_Us = "SELECT id_usuario, nombre FROM usuarios WHERE status = 1";
                $resultado_Us = $conexion->query($sql_Us);

                while ($usuario = $resultado_Us->fetch_assoc()) { ?>
                    <option value="<?php echo $usuario['id_usuario']; ?>">
                        <?php echo $usuario["nombre"]; ?>
                    </option>
                <?php } ?>
            </select>
            <button class="btn-Rv" type="submit">Buscar</button>
        </form>
    <?php } ?>

    <h2 class="Tt-Rv">Ventas del Día: <?php echo $nombre_dia . ", " . $fecha_hoy; ?></h2>
    <table class="Tb-Rv">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Importe Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT v.fecha, u.nombre AS usuario, SUM(p.precio * dv.cantidad) AS total 
                    FROM ventas AS v
                    INNER JOIN usuarios AS u ON u.id_usuario = v.id_usuario
                    INNER JOIN detalle_venta AS dv ON v.id_venta = dv.id_venta
                    INNER JOIN producto AS p ON dv.id_producto = p.id_producto
                    WHERE v.status = 1 AND v.fecha = '$fecha_hoy'
                    GROUP BY v.id_venta ORDER BY v.fecha ASC";

            $resultado_hoy = $conexion->query($sql);
            $total_general = 0;

            while ($row = $resultado_hoy->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['fecha']}</td>
                        <td>{$row['usuario']}</td>
                        <td>$" . number_format($row['total'], 2) . "</td>
                    </tr>";
                $total_general += $row['total'];
            }
            ?>
        </tbody>
    </table>
    <h2 class="Tt-Rv">Total del Día: $<?php echo number_format($total_general, 2); ?></h2>

</body>
</html>

<?php
$conexion->close();
?>
