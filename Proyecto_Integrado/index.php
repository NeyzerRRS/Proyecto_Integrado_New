<?php
session_start();
include_once "conexionesBD.php";
$conexion = conectarBD();

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'] ?? '';  // Asegura que no haya error si el campo no está definido
    $password = $_POST['password'] ?? ''; // Evita error de índice indefinido

    $sql = "SELECT id_usuario, nombre, tipo_usuario, contraseña FROM usuarios WHERE nombre = ?";
    $stmt = $conexion->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if ($password === $row['contraseña']) {  // Se mantiene la estructura, solo asegurando que la variable siempre exista
            // Verificar si el rol es válido
            if (in_array($row['tipo_usuario'], ['Administrativo','Encargado'])) { // Define los roles válidos
                $_SESSION['id_usuario'] = $row['id_usuario'];
                $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
                header("Location: /Proyecto_Integrado/Home.php");
                exit();
            } else {
                $error = "No tienes permisos para acceder al sistema.";
            }
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
    $stmt->close();
}
$conexion->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Papelería UNES</title>
    <style>
        /* Estilo general */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f8fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Contenedor principal */
        .login-container {
            background-color: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 40px 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Título principal */
        h1 {
            font-size: 30px;
            color: #005b8b;
            margin-bottom: 10px;
        }

        /* Subtítulo */
        h2 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Estilo de los campos de entrada */
        .input-field {
            width: 90%;
            padding: 14px;
            margin: 15px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #333;

        }

        .input-field:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Botón de inicio de sesión */
        .btn-submit {
            width: 50%;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #005b8b;
        }

        /* Estilo del mensaje de error */
        .error {
            color: #ff4d4d;
            background-color: #ffe6e6;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 16px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 25px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>Bienvenido a Papelería UNES</h1>
        <h2>Iniciar Sesión</h2>

        <form method="POST">
            <!-- Mostrar mensaje de error si existe -->
            <?php if (!empty($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>

            <input type="text" name="user" class="input-field" placeholder="Usuario" required>
            <input type="password" name="password" class="input-field" placeholder="Contraseña" required>
            <input type="submit" value="Iniciar sesión" class="btn-submit">
        </form>
    </div>

</body>
</html>