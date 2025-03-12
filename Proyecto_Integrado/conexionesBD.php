<?php
	
	function conectarBD()
	{
	    	$servername = "localhost";
	        $database = "Papeleria";
	        $username = "root";
	        $password = "";

			try
			{
	        $conexion = mysqli_connect($servername, $username, $password, $database);
			}
			catch(mysqli_sql_exception $e)
			{
				die("Error en la conexion: " . $e->getMessage());
			}
		return $conexion;
	    }
?>