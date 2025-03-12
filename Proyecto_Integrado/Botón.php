<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animación Cuadros</title>
    <style>
        .MainContent {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px
        }

        .Cuadro1 {
            width: 200px;
            height: 200px;
            text-align: center;
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 10px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .Cuadro1 img {
            width: 80px;
            height: 80px;
        }

        /* Efecto al pasar el cursor */
        .Cuadro1:hover {
            transform: translateY(-5px); /* Levanta el cuadro */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3); /* Sombra más intensa */
        }

        /* Efecto al presionar */
        .Cuadro1:active {
            transform: translateY(2px); /* Se presiona hacia abajo */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra más suave */
        }

        /* Estilo para los enlaces */
        a {
            text-decoration: none;
            color: black;
        }

        .Contenedor {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

    </style>
</head>
<body>

<div class="MainContent">
    <div class="Contenedor">
        <div>
            <a href="Inventario.html">
                <div class="Cuadro1">  
                    <img src="Imagenes/IL.png"><br><p><b>Inventario</b></p>
                </div>
            </a>
        </div>
        <div>
            <a href="">
                <div class="Cuadro1">  
                    <img src="Imagenes/ventas.png"><br><p><b>Venta</b></p>
                </div>
            </a>
        </div>
        <div>
            <a href="">
                <div class="Cuadro1">  
                    <img src="Imagenes/devoluciones.png"><br><p><
