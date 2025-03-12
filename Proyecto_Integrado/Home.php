<?php
include_once "conexionesBD.php";
$conexion = conectarBD();

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
    header("Location: http://localhost/Proyecto_Integrado/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Papelería UNES</title>
</head>
<body>
    <header>
    <a href="Home.php"><img src="./Imagenes/Logo-removebg-preview.png"></a>
    <div class="User">
        <form class="User_log" action="logout.php" method="post">
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
        <form class="User_help" action="Ayuda/ayuda.php" method="get">
            <button class="faq-button">
                    <svg viewBox="0 0 320 512">
                        <path d="M80 160c0-35.3 28.7-64 64-64h32c35.3 0 64 28.7 64 64v3.6c0 21.8-11.1 42.1-29.4 53.8l-42.2 27.1c-25.2 16.2-40.4 44.1-40.4 74V320c0 17.7 14.3 32 32 32s32-14.3 32-32v-1.4c0-8.2 4.2-15.8 11-20.2l42.2-27.1c36.6-23.6 58.8-64.1 58.8-107.7V160c0-70.7-57.3-128-128-128H144C73.3 32 16 89.3 16 160c0 17.7 14.3 32 32 32s32-14.3 32-32zm80 320a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"></path>
                    </svg>
            <span class="tooltip">Ayuda</span>
        </button>
        </form>
        
        <img class="User_icon" src="Imagenes/colegio.png" alt="User Icon">
    </div>
    <h1>Papelería UNES </h1>
</header>

   
        <!-- Navegación con atajos ocultos -->
<div hidden="hidden">
        <nav>
        <ul>
            <li><a href="Home.php" accesskey="h">Home</a></li>
            <li><a href="Inventario/Inventario.php" accesskey="i">Inventario</a></li>
            <li><a href="Ventas/Registrar_Venta.php" accesskey="v">Venta</a></li>
            <li><a href="Devoluciones/Devoluciones.php" accesskey="x">Devoluciones</a></li>
            <li><a href="ReportesV/consultar_reporteV.php" accesskey="r">Reportes</a></li>
            <li><a href="Vales/Registrar_Vale.php" accesskey="a">Vales</a></li>
            <li><a href="index.php" accesskey="s">Index</a></li>
            <li><a href="ayuda.php" accesskey="y">Ayuda</a></li>
        </ul>
    </nav>
</div>
<div class="MainContent">
<div class="Contenedor">
<!--Opcional: Manejo adicional según roles-->
<?php if ($rol == 'Administrativo') {?>
    <div>
        <a href="Inventario/Inventario.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/IL.png"><br><p><b>Inventario</b></p></div></a>
    </div>
    <div>
        <a href="Ventas/Registrar_Venta.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/ventas.png"><br><p><b>Venta</b></p></div></a>
    </div>
    <div>
        <a href="Devoluciones/Devoluciones.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/devoluciones.png"><br><p><b>Devoluciones</b></p></div></a>
    </div>
    <div>
        <a href="ReportesV/consultar_reporteV.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/reporte-de-negocios.png"><br><p><b>Reportes Ventas</b></p></div></a>
    </div>
        <div>
        <a href="ReportesVL/consultar_reporteVL.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/reporte-de-negocios.png"><br><p><b>Reportes Vales</b></p></div></a>
    </div>
    <div>
        <a href="Vales/Registrar_Vale.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/vales.png"><br><p><b>Vales</b></p></div></a>
    </div>

<?php } elseif ($rol == 'Encargado') {?>
    <div>
        <a href="Inventario/Inventario.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/IL.png"><br><p><b>Inventario</b></p></div></a>
    </div>
    <div>
        <a href="Ventas/Registrar_Venta.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/ventas.png"><br><p><b>Venta</b></p></div></a>
    </div>
    <div>
        <a href="Devoluciones/Devoluciones.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/devoluciones.png"><br><p><b>Devoluciones</b></p></div></a>
    </div>
    <div>
        <a href="ReportesV/consultar_reporteV.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/reporte-de-negocios.png"><br><p><b>Reportes</b></p></div></a>
    </div>
    <div>
        <a href="Vales/Registrar_Vale.php"> <div class="Cuadro1 ">  
            <img src="Imagenes/vales.png"><br><p><b>Vales</b></p></div></a>
    </div>

<?php } else {
    echo "Rol no reconocido.";
    session_destroy();
    header("Location: index.php");
    exit();
}?>
</div>
</div>
</body>
</html>
<?php
mysqli_close($conexion);
?>