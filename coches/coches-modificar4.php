<?php
session_start();
include '../header.view.php';

include '../db.php';    
$id_coche = $_REQUEST['id_coche'];

$sql1 = "SELECT * FROM coches WHERE id_coche = '$id_coche'";
$result1 = mysqli_query($conn, $sql1);
if ($result1 && mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $nombre_modelo = $row1['modelo'];
    $foto = $row1['foto'];
}

$modelo = $_REQUEST['modelo'] ?? '';
$marca = $_REQUEST['marca'] ?? '';
$color = $_REQUEST['color'] ?? '';
$precio = $_REQUEST['precio'] ?? '';
$alquilado = $_REQUEST['alquilado'] ?? '';
$foto = $row1['foto'];
if (isset($_FILES['foto'])){
    $file = $_FILES['foto'];
    $foto = basename($file['name']);
    $uploadPath = "img/$foto";
    move_uploaded_file($file['tmp_name'], $uploadPath);
}

$sql2 = "UPDATE coches SET 
    modelo = '$modelo',  
    marca = '$marca', 
    color = '$color',   
    precio = '$precio',
    alquilado = '$alquilado',
    foto = '$foto'
    WHERE id_coche = $id_coche";

?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
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
            <h1>Coche modificado</h1>
            <div class="car-container">            

                <?php
                if (mysqli_query($conn, $sql2)) {
                    echo "Coche, ".$nombre_modelo." modificado correctamente";
                    ?><div class="button-container">
                    <a href="/PracticaConcesionario/coches/coches-modificar.php" class="button">Volver atras</a>
                </div><?php
                } else {
                    echo "Error al modificar el coche:  ".$nombre_modelo ."";
                }
                ?>

        </div>
    </div>
</body>
</html>
