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
}
include '../header.view.php';

include '../db.php';

$sql = 
"SELECT c.id_coche, c.modelo, c.marca, c.precio, c.alquilado, c.foto, c.id_vendedor, u.nombre
FROM coches c
JOIN usuarios u
ON c.id_vendedor = u.id_usuario";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de coches</title>
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
        }

        .alquiler-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .alquiler-box {
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

        .alquiler-box img {
            width: 100%;
            height: 180px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .alquiler-box h3 {
            margin: 10px 0;
            font-size: 18px;
        }

        .alquiler-box p {
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
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Coches disponibles para alquilar</h1>
        </div>
        <div class="alquiler-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) { 
                    if($row["alquilado"] == 0) { ?>
                    <div class="alquiler-box">
                    <img src="/PracticaConcesionario/coches/img/<?php echo $row['foto']?>" alt="Imagen del coche">
                    <p style="font-size:20px; color:black; text-decoration:underline;"><strong><?php echo $row["marca"] . ' ' . $row["modelo"] ?></strong></p>
                    <p><strong>Precio: </strong><?php echo $row["precio"] ?>€</p>
                    <p><strong>De: </strong><?php echo $row["nombre"] ?></p>
                    <a href="alquileres-alquilar2.php?id_coche=<?php echo $row['id_coche'];?>" class="button">Alquilar</a>
                    </div>
                <?php
                    }}
            } else {
                echo "<p>No se encontraron coches en la base de datos.</p>";
            }
            ?>
        </div>
        <div class="button-container">
            <a href="../index.php" class="button">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
