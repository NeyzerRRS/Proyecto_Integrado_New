<?php
	include_once "../conexionesBD.php";
	$conexion = conectarBD();

	$idProducto = $_GET['id'];

	$sql = "UPDATE producto SET status = 0 WHERE id_producto = '$idProducto'";

	try{
		$resultado = mysqli_query($conexion, $sql);
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
	<title>Eliminar Producto</title>
	<link rel="stylesheet" href="../Css/style.css">
</head>
<body>
	<header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
        	<!--QUITAR EL 8080-->
        	<form class="User_icon" action="http://localhost:8080/Proyecto_Integrado/logout.php
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
        <h1 class="Inventario">Eliminación Exitosa</h1>
    </header><br>

	<p class="No_Encontrado">Se elimino correctamente el producto</p>
	<br>
	<button class="btn-Rv" type="submit">
		<a href="Inventario.php">Volver</a>
	</button>
</body>
</html>
<?php
mysqli_close($conexion);
?>
