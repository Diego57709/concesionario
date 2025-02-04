<?php
session_start();
include '../header.view.php';

include '../db.php';
    
$id_usuario = $_REQUEST['id_usuario'];
$usuario = $_REQUEST['nombre'];
$apellidos = $_REQUEST['apellidos'];
$dni = $_REQUEST['dni'];
$saldo = $_REQUEST['saldo'];

$sql1 = "SELECT nombre FROM usuarios WHERE id_usuario = '$id_usuario'";
$result1 = mysqli_query($conn, $sql1);
if ($result1 && mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $nombre_usuario = $row1['nombre'];
}

$sql2 = "UPDATE usuarios SET 
    nombre = '$usuario',  
    apellidos = '$apellidos', 
    dni = '$dni', 
    saldo = '$saldo'
    WHERE id_usuario = $id_usuario";

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

        .car-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .car-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 250px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            color: #333;
        }

        .car-box img {
            width: 100%;
            height: 180px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .car-box h3 {
            margin: 10px 0;
            font-size: 18px;
        }

        .car-box p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .button-container {
            text-align: center;
            margin-top: 40px;
        }
        .button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .user-container table {
            text-align: center;
            display: flex;
            justify-content: center;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid white;
        }
        th {
            background-color: #007BFF;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Usuario modificado</h1>
            <div class="user-container">            

                <?php
                if (mysqli_query($conn, $sql2)) {
                    echo "Usuario, ".$nombre_usuario." modificado correctamente";
                } else {
                    echo "Error al modificar el usuario:  ".$nombre_usuario ."";
                }
                ?>

        </div>
        <div class="button-container">
            <a href="/PracticaConcesionario/usuarios/usuarios-modificar.php" class="button">Volver atras</a>
            <a href="/PracticaConcesionario/usuarios/usuarios-listar.php" class="button">Volver al listado</a>
        </div>
    </div>
</body>
</html>
