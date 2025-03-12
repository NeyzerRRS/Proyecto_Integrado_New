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
    header("Location: http://localhost/Proyecto_Integrado/index.php"); // Eliminado el puerto 8080
    exit();
}
?>

<!-- Load font awesome icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const links = document.querySelectorAll(".navbar a");
        const currentPath = window.location.pathname;
        
        links.forEach(link => {
            if (link.href.includes(currentPath)) {
                link.classList.add("active");
            }
        });
    });
</script>

<!-- The navigation menu -->
<?php if ($rol == 'Administrativo') {?>
<div class="navbar">
    <a href="../Home.php">Inicio</a>
    <a href="../Inventario/Inventario.php">Inventario</a>
    <a href="../Ventas/Registrar_Venta.php">Ventas</a>
    <a href="http://localhost/Proyecto_Integrado/Vales/Registrar_Vale.php">Vales</a>
    <a href="../Devoluciones/Devoluciones.php">Devoluciones</a>
    <a href="../ReportesV/consultar_reporteV.php">Reporte de Ventas</a>
    <a href="../ReportesVL/consultar_reporteVL.php">Reporte de Vales</a>
    <a href="../Ayuda/ayuda.php">Ayuda</a>
</div>
<?php } elseif ($rol == 'Encargado') {?>
<div class="navbar">
    <a href="../Home.php">Inicio</a>
    <a href="../Inventario/Inventario.php">Inventario</a>
    <a href="../Ventas/Registrar_Venta.php">Ventas</a>
    <a href="../Vales/Registrar_Vale.php">Vales</a>
    <a href="../Devoluciones/Devoluciones.php">Devoluciones</a>
    <a href="../ReportesV/consultar_reporteV.php">Reporte de Ventas</a>
    <a href="../ayuda.php">Ayuda</a>
</div>
<?php } else {
    echo "Rol no reconocido.";
    session_destroy();
    header("Location: index.php");
    exit();
}?>
<!-- CSS para resaltar y marcar el botón seleccionado -->
<style>
    .navbar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        background-color: #003772;
        padding: 10px;
    }
    .navbar a {
        transition: background-color 0.3s, transform 0.2s;
        padding: 10px 15px;
        text-decoration: none;
        color: white;
        font-size: 18px;
        border-radius: 5px;
    }
    .navbar a:hover {
        transform: scale(1.1);
    }
    .navbar a.active {
        background-color: #0056b3;
        border-bottom: 3px solid #ffffff;
    }
    
    /* Estilos para hacerlo responsivo */
    @media screen and (max-width: 768px) {
        .navbar {
            flex-direction: column;
            align-items: center;
        }
        .navbar a {
            width: 100%;
            text-align: center;
        }
    }
</style>