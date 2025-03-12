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
            <form class="User_log" action="http://localhost/Proyecto_Integrado/logout.php" method="post">
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
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Devoluciones</h1>
    </header>
    
    <?php include "../Menu.php"; ?>
    
    <br>
    <div class="buscador2">
        <i class="fas fa-search"></i>
        <form action="Devoluciones.php" method="GET">
            <input type="text" class="search_bar" name="tipoProducto" placeholder="Buscar Devolución por Usuario">
        </form>
    </div>
    <a href="registrar_devolucion.php?movimiento=alta&id=NULL"><input type="submit" class="AgregarP" value="Agregar Devolución Nueva"></a>
    <?php
    require_once "../conexionesBD.php";
    $conexion = conectarBD();

    // Verificar si la sesión contiene el ID del usuario
    if (!isset($_SESSION['id_usuario'])) {
        echo "Error: No hay sesión activa.";
        header("Location: ../index.php");
        exit();
    }

    $id_usuario = $_SESSION['id_usuario'];
    $query = "SELECT tipo_usuario AS rol FROM usuarios WHERE id_usuario = $id_usuario";
    $result = $conexion->query($query);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $rol = $row['rol'];
    } else {
        echo "Error al obtener el rol del usuario.";
        session_destroy();
        header("Location: ../index.php");
        exit();
    }

    $tpProducto = isset($_GET['tipoProducto']) ? mysqli_real_escape_string($conexion, $_GET['tipoProducto']) : '';
    $consulta = "SELECT dv.fecha, dv.id_usuario, u.nombre AS nUsuario, dv.id_motivo, dv.cantidad, p.id_producto, p.nombre, dv.importe, m.motivo ";
    $consulta .= "FROM producto AS p "; 
    $consulta .= "INNER JOIN tipo_producto AS tp ON p.id_tipo = tp.id_tipo ";
    $consulta .= "INNER JOIN devolucion_cliente AS dv ON dv.id_producto = p.id_producto ";
    $consulta .= "INNER JOIN Motivo AS m ON m.id_Motivo=dv.id_Motivo ";
    $consulta .= "INNER JOIN usuarios AS u ON u.id_usuario = dv.id_usuario ";
    $consulta .= "WHERE dv.status=1";
    if (!empty($tpProducto)) {
        $consulta .= " AND u.nombre LIKE '%$tpProducto%'";
    }
    $consulta .= " ORDER BY dv.fecha DESC";
    $resultado = mysqli_query($conexion, $consulta);
    ?>
    <?php if ($rol == 'Administrativo' || $rol == 'Encargado') {?>
    <?php } else {
        echo "Rol no reconocido.";
        session_destroy();
        header("Location: ../index.php");
        exit();
    }?>
    <?php if (mysqli_num_rows($resultado) > 0) { ?>
        <br><br><br>
        <table class="Devoluciones">
            <tr class="Devoluciones">
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Importe</th>
                <th>Fecha y Hora </th>
                <th>Usuario</th>
                <th>Motivo</th>
            </tr>
            <?php while ($pcto = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $pcto["nombre"]; ?></td>
                <td><?php echo $pcto["cantidad"]; ?></td>
                <td> $<?php echo $pcto["importe"]; ?></td>
                <td><?php echo $pcto["fecha"]; ?></td>
                <td><?php echo $pcto["nUsuario"]; ?></td>
                <td><?php echo $pcto["motivo"]; ?></td>
            </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="No_Encontrado">Devolución no encontrada</p>
    <?php } ?>
    <br>
    <a href="../Home.php" class="button">
        <button class="btn-Rv">Volver al Inicio</button>
    </a>
</body>
</html>
<?php
mysqli_close($conexion);
?>