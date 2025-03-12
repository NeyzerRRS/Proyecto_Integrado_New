<?php
	include_once "../conexionesBD.php";
	$conexion = conectarBD();

	$idProducto = $_POST['idProducto'];
	$nombre = $_POST['nombre'];
	$tipo_pcto = $_POST['tipoProducto'];
	$marca = $_POST['marca'];
	$precio = $_POST['precio'];
	$existencia = $_POST['existencia'];

	$sql = "UPDATE producto SET id_tipo = '$tipo_pcto', nombre = '$nombre', precio ='$precio', existencia ='$existencia', marca ='$marca' WHERE id_producto = '$idProducto'";

	try{
		$resultado = mysqli_query($conexion, $sql);
	}
		catch(mysqli_sql_exception $e){
		die("Error al actualizar la informacio: " . $e->getMessage());
	}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../Css/style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modificar Producto</title>
</head>
<body>
	<h1>Modificacion Exitosa</h1>
	<br>
	<button type="submit">
		<a href="Inventario.php">Volver</a>
	</button>
</body>
</html>
<?php
mysqli_close($conexion);
?>