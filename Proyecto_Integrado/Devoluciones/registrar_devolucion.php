<?php
// Verificar si la sesión ya ha sido iniciada antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Asegurar que la sesión esté iniciada
}

include_once "../conexionesBD.php";
$conexion = conectarBD();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Asegurar variables GET
$movimiento = isset($_GET['movimiento']) ? mysqli_real_escape_string($conexion, $_GET['movimiento']) : '';
$idProducto = isset($_GET['id']) ? mysqli_real_escape_string($conexion, $_GET['id']) : '';

$tituloPag = "Agregar Devolución";

// Consultas a la base de datos
$consultaMotivoSQL = "SELECT M.id_motivo, M.motivo FROM Motivo AS M WHERE M.status = 1;";
$resultadoMotivo = mysqli_query($conexion, $consultaMotivoSQL);
if (!$resultadoMotivo) {
    die('Error en la consulta de motivos: ' . mysqli_error($conexion));
}

$consultaProductoSQL = "SELECT p.id_producto, p.nombre, p.precio FROM producto AS p  WHERE p.status = 1 ORDER BY p.nombre ASC ;";
$resultadoProducto = mysqli_query($conexion, $consultaProductoSQL);
if (!$resultadoProducto) {
    die('Error en la consulta de productos: ' . mysqli_error($conexion));
}

// Recuperar datos del usuario
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario = '';

$query = "SELECT nombre FROM usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->bind_result($nombre_usuario);
$stmt->fetch();
$stmt->close();

// Inicializar valores vacíos
$nomPcto = $cantidadPcto = $motivoPcto = $importePcto = $fecha = "";

$action = "guardar_devolucion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Agregar Devolución - <?php echo htmlspecialchars($tituloPag); ?></title>
</head>
<body>
    <header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
            <form class="User_log" action="../logout.php" method="post">
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
        <h1 class="Inventario"><?php echo htmlspecialchars($tituloPag); ?></h1>
    </header>
    <?php include "../Menu.php"; ?> <br>

   <form class="registrarP" action="<?php echo htmlspecialchars($action); ?>" method="POST">
        <input type="hidden" name="idProducto" value="<?php echo htmlspecialchars($idProducto); ?>">

        <h2 class="Titulo_Form">Formulario De Devolución</h2>

        <label class="Subtitulo_Form">Producto:</label><br>
        <select class="formLabel" name="nombre" id="nombre" required>
            <option value="">Selecciona un producto</option>
            <?php while ($producto = mysqli_fetch_assoc($resultadoProducto)) { ?>
                <option value="<?php echo $producto['id_producto']; ?>" data-precio="<?php echo $producto['precio']; ?>" <?php echo ($producto['id_producto'] == $idProducto) ? "selected" : ""; ?>>
                    <?php echo htmlspecialchars($producto['nombre']); ?>
                </option>
            <?php } ?>
        </select><br><br>

        <label class="Subtitulo_Form">Cantidad:</label><br>
        <input class="formLabel" type="number" name="cantidad" id="cantidad" placeholder=" Añade una cantidad" value="<?php echo htmlspecialchars($cantidadPcto); ?>" required><br><br>

        <legend class="Subtitulo_Form">Motivo:</legend>
        <?php while ($fila = mysqli_fetch_assoc($resultadoMotivo)) { ?>
            <input type="radio" name="motivo" id="tipo-<?php echo $fila['id_motivo']; ?>" value="<?php echo $fila['id_motivo'];?>" <?php echo ($fila['id_motivo'] == $motivoPcto) ? "checked" : ""; ?>>
            <label class=""for="tipo-<?php echo $fila['id_motivo']; ?>"><?php echo htmlspecialchars($fila['motivo']); ?></label>
        <?php } ?>
        <br><br>

        <label class="Subtitulo_Form">Importe:</label><br>
        <input class="formLabel" type="number" name="importe" id="importe" placeholder=" Añade el Importe" value="<?php echo htmlspecialchars($importePcto); ?>" required readonly><br><br>

        <?php date_default_timezone_set('America/Mexico_City'); ?>
        <label class="Subtitulo_Form">Fecha:</label>
        <input class="formLabel" type="datetime-local" name="fecha" id="fecha" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly><br><br>

        <legend class="Subtitulo_Form">Usuario:</legend> <br>
        <input  type="hidden" name="nUsuario" id="usuario-<?php echo $id_usuario; ?>" value="<?php echo $id_usuario; ?>">
        <label class="formLabel" for="usuario-<?php echo $id_usuario; ?>"><?php echo htmlspecialchars($nombre_usuario); ?></label>
        <br><br><br><br>

        <input class="btn-form" type="submit" name="Continuar"><br><br>
    </form>

    <a href="Devoluciones.php">
        <button class="btn-Rv">Volver</button>
    </a>

    <script>
        // Función para calcular el importe
        function calcularImporte() {
            var cantidad = document.getElementById('cantidad').value;
            var productoSelect = document.getElementById('nombre');
            var precio = parseFloat(productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio'));

            if (!isNaN(cantidad) && cantidad > 0 && !isNaN(precio)) {
                var importe = cantidad * precio;
                document.getElementById('importe').value = importe.toFixed(2);
            }
        }

        // Asociar el cálculo del importe cuando se cambie la cantidad o el producto
        document.getElementById('cantidad').addEventListener('input', calcularImporte);
        document.getElementById('nombre').addEventListener('change', calcularImporte);

        // Ejecutar al cargar la página por si ya hay valores
        window.onload = calcularImporte;
    </script>

</body>
</html>

<?php
mysqli_close($conexion);
?>
