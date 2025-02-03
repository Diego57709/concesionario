<?php
include '../header.view.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style type="text/css">
        body {
            background: linear-gradient(to right, #141E30, #243B55);
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .main-container {
            margin: 20px auto;
            padding: 20px;
            width: 90%;
            max-width: 1200px;
            background-color: #333;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .content {
            text-align: center;
            margin-bottom: 20px;
            justify-content: center;
        }

        .title {
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 300px;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        input[type="submit"], 
        .button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        .alert {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
            width: auto;
            margin: 10px auto;
            padding: 15px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

    </style>
</head>
<body>
    <div class="main-container">
        <div class="title">
            <h1>Bienvenido a Concesionario POP</h1>
        </div>

        <?php if (!isset($_SESSION['id']) && !isset($_SESSION['nombre'])) { ?>
            <div class="content">
                <h1>Inicia sesión</h1>

                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger">
                        <?php
                        if ($_GET['error'] == 1) {
                            echo "⚠️ Faltan datos por completar.";
                        } elseif ($_GET['error'] == 2) {
                            echo "❌ Usuario o contraseña incorrectos.";
                        }
                        ?>
                    </div>
                <?php } ?>

                <div class="login-container text-center">
                    <form action="usuarios-iniciar2.php" method="post" class="mt-3">
                        <div class="mb-3">
                            <input type="text" name="dni" id="usuario" placeholder="DNI" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" id="password" placeholder="Contraseña" required>
                        </div>
                        <a href="usuarios/usuarios-anadir.php" style="color:#dc3545;">¿No tienes cuenta?</a><br><br>
                        <input type="submit" value="Iniciar sesión" class="button">
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="content">
                <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?>!</h1>
                <a href="usuarios-cerrar.php" class="button" style="background-color: #dc3545;">Cerrar sesión</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>
