<?php
	include_once "../conexionesBD.php";
	$conexion = conectarBD();
	
	if(!$conexion)
    {
        die("Conexion Fallida: " . mysqli_connect_error());
        return -1;
    }

	$nombre = $_POST['nombre'];
	$tipo_pcto = $_POST['tipoProducto'];
	$marca = $_POST['marca'];
	$precio = $_POST['precio'];
	$existencia = $_POST['existencia'];

	$sql = "UPDATE producto SET id_tipo = '$tipo_pcto', nombre = '$nombre', precio ='$precio', existencia ='$existencia', marca ='$marca' WHERE 1";

	$resultado = mysqli_query($conexion, $sql);
	var_dump($sql);
	var_dump($resultado);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editar Producto</title>
</head>
<body>
	<?php
		if ($resultado == true){
	?>
	<b>El producto se registro correctamente</b>
	<?php
		}
		else{
	?>
	<b>Ocurrio un error al registrar el producto</b>
	<?php
		}
	?>
	<br>
	<button type="submit">
		<a href="registrar_producto.php">Volver</a>
	</button>
</body>
</html>
<?php
mysqli_close($conexion);
?>