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
            border-radius: 8px;
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
        input[type="number"] {
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
        .saldo-container {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .saldo-container input {
            width: 140px
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Buscar usuarios</h1>
            <form action="usuarios-buscar2.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre">

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos">

                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni">

                <div class="saldo-container">
                    <div>
                        <label for="min_saldo">Saldo mínimo:</label><br>
                        <input type="text" id="min_saldo" name="min_saldo">
                    </div>
                    <div>
                        <label for="max_saldo">Saldo máximo:</label><br>
                        <input type="text" id="max_saldo" name="max_saldo">
                    </div>
                </div>
                <input type="submit" value="Buscar">
            </form>
            <a href="../index.php" class="button">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
