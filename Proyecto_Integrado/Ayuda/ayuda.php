<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Papelería UNES</title>
</head>
<body>
    <header>
        <a href="Home.php" accesskey="h"><img src="../Imagenes/Logo-removebg-preview.png" alt="Logo"></a>
        <div class="User">
            <form class="User_log" action="logout.php" method="post">
                <button class="Btn" accesskey="l">
                    <div class="sign">
                        <svg viewBox="0 0 512 512">
                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                        </svg>
                    </div>
                    <div class="text">Cerrar sesión</div>
                </button>
            </form>
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>

        <h1>Ayuda</h1>
    </header>
    <?php include "../Menu.php"; ?>
        <!-- Navegación con atajos ocultos -->
<div hidden="hidden">
    <nav>
        <ul>
            <li><a href="Home.php" accesskey="h">Home</a></li>
            <li><a href="Inventario/Inventario.php" accesskey="i">Inventario</a></li>
            <li><a href="Ventas/Registrar_Venta.php" accesskey="v">Venta</a></li>
            <li><a href="Devoluciones/Devoluciones.php" accesskey="x">Devoluciones</a></li>
            <li><a href="ReportesV/consultar_reporteV.php" accesskey="r">Reportes</a></li>
            <li><a href="Vales/Registrar_Vale.php" accesskey="a">Vales</a></li>
            <li><a href="logout.php" accesskey="s">Index</a></li>
            <li><a href="ayuda.php" accesskey="y">Ayuda</a></li>
        </ul>
    </nav>
</div>
</body>
</html>
    <main>
        <h2>Atajos de Teclado</h2>
        <p>Los siguientes atajos de teclado están disponibles en el sistema:</p>
        <ul>
            <li><b>Alt + h</b>: Ir a la página de inicio.</li>
            <li><b>Alt + i</b>: Acceder al Inventario.</li>
            <li><b>Alt + v</b>: Acceder a la sección de Ventas.</li>
            <li><b>Alt + x</b>: Acceder a las Devoluciones.</li>
            <li><b>Alt + r</b>: Generar Reportes.</li>
            <li><b>Alt + a</b>: Gestionar Vales.</li>
            <li><b>Alt + y</b>: Acceder a la Ayuda.</li>
            <li><b>Alt + s</b>: Cerrar sesión.</li>
        </ul>

    </main>

	    <a href="Home.php">
        <button class="btn-Rv">Volver al inicio</button><br><br>
    </a>
        <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0e0e0;
            margin: 0;
            padding: 0;
            color: #444;
        }

        main {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 15px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: #f7f7f7;
            margin: 12px 0;
            padding: 12px 18px;
            border-left: 5px solid #3498db;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
        }

        b {
            color: #2c3e50;
        }
    </style>
</body>
</html>