<?php
	include_once "../conexionesBD.php";
	$conexion = conectarBD();

	$consulta = "SELECT id_tipo, nombre FROM tipo_producto WHERE status = 1";
		try{
		$resultado = mysqli_query($conexion, $consulta);
	}
		catch(mysqli_sql_exception $e){
		die("Error al eliminar el registro: " . $e->getMessage());
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Consultar Productos</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
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
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1 class="Inventario">Devoluciones</h1>
    </header>
	<h1>Consultar Productos</h1>
	<form action="resultado_producto.php" method="POST">
	    <label for="tipoProducto">Tipo de producto:</label>
	    <select name="tipoProducto" id="tipoProducto">
	        <option value="">Seleccione uno</option>
	        <?php 
	        while($pcto = mysqli_fetch_assoc($resultado)) { 
	        ?>
	        <option value="<?php echo $pcto['id_tipo']; ?>">
	        	<?php echo $pcto["nombre"]; ?>
	        </option>
	        <?php } ?>        
	    </select><br><br>
	    <input type="submit">
	    <br><br>
	</form>
	<a href="registrar_producto.php?movimiento=alta&id=NULL">Agregar un producto</a>
</body>
</html>
<?php
mysqli_close($conexion);
?>