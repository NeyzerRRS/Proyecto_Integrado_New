<?php  
	include_once "../conexionesBD.php";

	$conexion = conectarBD();

	$producto = $_GET['nombre'];

	$sql = "SELECT id_producto, nombre, precio FROM producto WHERE status=1 AND nombre LIKE '%$producto%' ORDER BY nombre ASC";


	$resultado = mysqli_query($conexion,$sql);

	$datos = array();

while ($row = mysqli_fetch_assoc($resultado)) {
    $datos[] = [
        'id_producto' => $row['id_producto'],
        'nombre' => $row['nombre'],
        'precio' => '$ ' . $row['precio']
    ];
}


	echo json_encode($datos);

	mysqli_close($conexion);
?>

