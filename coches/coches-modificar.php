<?php
session_start();
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['tipo_usuario'])) {
    header("Location: /PracticaConcesionario/usuarios/usuarios-iniciar.php");
    exit();
}
switch ($_SESSION['tipo_usuario']) {
    case 'vendedor':
        header("Location: /PracticaConcesionario/index.php");
        exit();
    case 'comprador':
        header("Location: /PracticaConcesionario/index.php");
        exit();
}
include '../header.view.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
        .precio-container {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .precio-container input {
            width: 140px
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Modificar coche</h1>
            <form action="coches-modificar2.php" method="POST">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo">

                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca">

                <label for="color">Color:</label>
                <input type="text" id="color" name="color">

                <div class="precio-container">
                    <div>
                        <label for="min_precio">Precio mínimo:</label><br>
                        <input type="text" id="min_precio" name="min_precio">
                    </div>
                    <div>
                        <label for="max_precio">Precio máximo:</label><br>
                        <input type="text" id="max_precio" name="max_precio">
                    </div>
                </div>

                <div>
                    <label for="alquilado">Alquilado</label><br><br>
                    <input type="checkbox" id="alquilado" name="alquilado">
                </div>
                <input type="submit" value="Buscar">
            </form>
            <a href="../index.php" class="button">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
