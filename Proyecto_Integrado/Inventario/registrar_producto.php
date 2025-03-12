<?php
	include_once "../conexionesBD.php";
	$conexion = conectarBD();

	
	$movimiento = $_GET['movimiento'];
	$idProducto = $_GET['id'];
	if ($movimiento == "cambio") {
		$tituloPag = "Modificar Producto";
		$action = "modificar_producto.php";
		$form = "Formulario de Modificar Producto";
	}elseif ($movimiento == "alta"){
		$tituloPag = "Registrar Producto";
		$action = "guardar_producto.php";
		$form = "Formulario de Registrar Producto";
	}
	

    $consultaSQL = "SELECT id_tipo, nombre FROM tipo_producto WHERE status = 1";
    $resultado = mysqli_query($conexion, $consultaSQL);

    $consultaSQLpcto = "SELECT id_producto, nombre, existencia, precio, marca, id_tipo FROM producto WHERE id_producto = ". $idProducto;
    $resultadoSQLpcto = mysqli_query($conexion, $consultaSQLpcto);

    $infoProducto = mysqli_fetch_assoc($resultadoSQLpcto);

    if ($infoProducto == NULL){
    	$nomPcto = "";
    	$marcaPcto = "";
    	$tipoPcto = "";
    	$existenciaPcto = "";
    	$precioPcto = "";

    }
    else{
    	$nomPcto = $infoProducto['nombre'];
    	$marcaPcto = $infoProducto['marca'];
    	$tipoPcto = $infoProducto['id_tipo'];
    	$existenciaPcto = $infoProducto['existencia'];
    	$precioPcto = $infoProducto['precio'];
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $tituloPag; ?></title>
	<link rel="stylesheet" href="../Css/style.css">
</head>

<body>
	<header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
        	  <!--QUITAR EL 8080-->
        	<form class="User_log" action="http://localhost:8080/Proyecto_Integrado/logout.php" method="post">
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
        <h1><?php echo $tituloPag; ?></h1>
    </header>
	<?php include "../Menu.php"; ?> <br>
	<form class="registrarP" action="<?php echo $action ?>" method="post">

		 <h2 class="Titulo_Form" ><?php echo $form; ?></h2>

		<input type="hidden" name="idProducto" value="<?php echo $idProducto; ?>">
		<label class="Subtitulo_Form">Nombre:</label><br>
		<input class="formLabel" placeholder=" Añade el Nombre del Producto" type="text" name="nombre" id="nombre" value="<?php echo $nomPcto; ?>" required><br><br>

		<label class="Subtitulo_Form">Marca:</label><br>
		<input class="formLabel" placeholder=" Añade la Marca del Producto" type="text" name="marca" id="marca" value="<?php echo $marcaPcto; ?>"required><br><br>

		<legend class="Subtitulo_Form">Tipo de producto:</legend>
		<?php
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$valorChecked = "";
			if ($fila['id_tipo'] == $tipoPcto){
				$valorChecked = "checked";
			}
			?>
			<input type="radio" name="tipoProducto" id="tipo-<?php echo $fila['id_tipo']; ?>" value="<?php echo $fila['id_tipo'];?>" <?php echo $valorChecked; ?>>
			<label for="tipo-<?php echo $fila['id_tipo']; ?>"><?php echo $fila['nombre']; ?></label><br><br>
		<?php
		}
		?>
		<br>
		<label class="Subtitulo_Form">Precio:</label><br>
		<input class="formLabel" placeholder=" Añade el Precio del Producto" type="text" name="precio" id="precio" value="<?php echo $precioPcto; ?>"required><br><br>

		<label class="Subtitulo_Form">Existencia:</label><br>
		<input class="formLabel" type="text"placeholder=" Añade una cantidad" name="existencia" id="existencia" value="<?php echo $existenciaPcto; ?>"required><br><br>
<br>
		<input class="btn-form" type="submit" name="Continuar"><br><br>
	</form>
		<a href="Inventario.php">
			<button class="btn-Rv" type="submit">Volver</button>
		</a>
	
</body>
</html>
<?php
mysqli_close($conexion);
?>