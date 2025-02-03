<?php
include 'header.view.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #141E30, #243B55);
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
            text-align: center;
        }

        .content {
            text-align: center;
            margin-bottom: 20px;
            justify-content: center;
        }
        .title, h2 {
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
            display: inline-block;
            margin: 5px;
            transition: 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        /* Quick Buttons */
        .quick-buttons {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="title">
            <h1>Bienvenido a Concesionario POP</h1>
        </div>
        
        <div class="session-status">
            <?php if (isset($_SESSION['nombre'])): ?>
                <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?>!</h2>
                <a href='usuarios/usuarios-cerrar.php' class='button'>Cerrar sesión</a>
            <?php else: ?>
                <h2>Ahora mismo estás sin iniciar sesión</h2>
            <?php endif; ?>
        </div>

        <!-- Quick Buttons -->
        <div class="quick-buttons">
            <a href='/PracticaConcesionario/coches/coches-listar.php' class='button'>📋 Listar Coches</a>
            <a href='/PracticaConcesionario/usuarios/usuarios-iniciar.php' class='button'>🔑 Iniciar Sesión</a>
        </div>
    </div>

</body>
</html>
