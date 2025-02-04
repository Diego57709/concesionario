<?php
session_start();
include '../header.view.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background: linear-gradient(to right, #141E30, #243B55);
        }
        .main-container {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            margin: 20px auto;
            padding: 20px;
            background-color: #333;
            width: 80%;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .content {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="password"] {
            width: 300px;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="checkbox"] {
            transform: scale(1.5);
            margin-right: 10px;
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

        input[type="submit"]:hover, 
        .button:hover {
            background-color: #0056b3;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
        }
        .radio-group {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
            }

            .radio-item {
            display: flex;
            align-items: center;
            gap: 5px;
            }

    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Página de registro</h1>
            <form action="usuarios-anadir2.php" method="POST">
                <label for="nombre">Nombre: </label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="password">Contraseña: </label>
                <input type="password" id="password" name="password" required>
                <label for="apellidos">Apellido: </label>
                <input type="text" id="apellidos" name="apellidos" required>
                <label for="DNI">DNI: </label>
                <input type="text" id="dni" name="dni" required>
                <label for="saldo">Saldo: </label>
                <input type="text" id="saldo" name="saldo" required>
                <label for="accion">¿En qué estás interesado?</label>
                <div class="radio-group">
                    <div class="radio-item">
                        <input type="radio" id="vender" name="accion" value="vendedor" required>
                        <label for="vender">Vender</label>
                    </div>
                    <div class="radio-item">
                        <input type="radio" id="comprar" name="accion" value="comprador" required>
                        <label for="comprar">Comprar</label>
                    </div>
                </div>
                <input type="submit" value="Registrarse">
            </form>
            <a href="index.php" class="button">Volver al inicio</a>
        </div>
    </div>
</body>
</html>


