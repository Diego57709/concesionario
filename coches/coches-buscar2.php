<?php
session_start();
include '../header.view.php';
include '../db.php';

$modelo    = isset($_REQUEST['modelo']) ? mysqli_real_escape_string($conn, $_REQUEST['modelo']) : '';
$marca     = isset($_REQUEST['marca']) ? mysqli_real_escape_string($conn, $_REQUEST['marca']) : '';
$color     = isset($_REQUEST['color']) ? mysqli_real_escape_string($conn, $_REQUEST['color']) : '';
$min_precio = isset($_REQUEST['min_precio']) ? intval($_REQUEST['min_precio']) : 0;
$max_precio = isset($_REQUEST['max_precio']) ? intval($_REQUEST['max_precio']) : 0;
$alquilado  = isset($_REQUEST['alquilado']) ? 1 : 0;

$sql = "SELECT * FROM coches WHERE 1=1";

if (!empty($modelo)) {
    $sql .= " AND modelo LIKE '%$modelo%'";
}
if (!empty($marca)) {
    $sql .= " AND marca LIKE '%$marca%'";
}
if (!empty($color)) {
    $sql .= " AND color LIKE '%$color%'";
}
if ($min_precio > 0 && $max_precio > 0) {
    $sql .= " AND precio BETWEEN $min_precio AND $max_precio";
} elseif ($min_precio > 0) {
    $sql .= " AND precio >= $min_precio";
} elseif ($max_precio > 0) {
    $sql .= " AND precio <= $max_precio";
}
$sql .= " AND alquilado = $alquilado";


$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coches Encontrados</title>
    <style>
        body {
            background: linear-gradient(to right, #141E30, #243B55);
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }
        .main-container {
            margin: 20px auto;
            padding: 20px;
            width: 90%;
            max-width: 1200px;
            background-color: #333;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .content {
            text-align: center;
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
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
    </head>
    <body>
    <div class="main-container">
        <div class="content">
            <h1>Coches encontrados</h1>
            <div class="car-container">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="car-box">';
                        echo '<img src="/PracticaConcesionario/coches/img/' . $row["foto"] . '" alt="Imagen del coche">';
                        echo '<h3>' . $row["marca"] . ' ' . $row["modelo"] . '</h3>';
                        echo '<p><strong>Precio:</strong> $' . $row["precio"] . '</p>';
                        echo '<p><strong>Color:</strong> ' . $row["color"] . '</p>';
                        echo '<p><strong>Alquilado:</strong> ' . ($row["alquilado"] ? 'Sí' : 'No') . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No se encontraron coches en la base de datos.</p>";
                }
                ?>
            </div>
            <div class="button-container">
                <a href="/PracticaConcesionario/coches/coches-buscar.php" class="button">Volver atrás</a>
            </div>
        </div>
    </div>
</body>
</html>
