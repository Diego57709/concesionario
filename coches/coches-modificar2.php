<?php
session_start();
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['tipo_usuario'])) {
    header("Location: /PracticaConcesionario/usuarios/usuarios-iniciar.php");
    exit();
}
switch ($_SESSION['tipo_usuario']) {
    case 'comprador':
        header("Location: /PracticaConcesionario/index.php");
        exit();
}
include '../header.view.php';
$modelo = $_REQUEST['modelo'];
$marca = $_REQUEST['marca'];
$color = $_REQUEST['color'];
$min_precio = isset($_REQUEST['min_precio']) ? $_REQUEST['min_precio'] : 0;
$max_precio = isset($_REQUEST['max_precio']) ? $_REQUEST['max_precio'] : 0;
$id_usuario = $_SESSION['id_usuario'];

$alquilado = isset($_REQUEST['alquilado']) ? 1 : 0;

include '../db.php';
    $sql = "SELECT * FROM coches WHERE 1=1 AND id_vendedor = '$id_usuario'";
    
    if ($modelo) {
        $sql.= " AND modelo LIKE '%$modelo%'";
    }
    if ($marca) {
        $sql.= " AND marca LIKE '%$marca%'";
    }
    if ($color) {
        $sql.= " AND color LIKE '%$color%'";
    }
    if ($min_precio && $max_precio) {
        $sql .= " AND precio BETWEEN '$min_precio' AND '$max_precio'";
    } elseif ($min_precio) {
        $sql .= " AND precio >= '$min_precio'";
    } elseif ($max_precio) {
        $sql .= " AND precio <= '$max_precio'";
    }
    if ($alquilado) {
        $sql.= " AND alquilado = '1'";
    } else {
        $sql.= " AND alquilado = '0'";
    }
    $result = mysqli_query($conn, $sql);

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

        input[type="checkbox"] {
            transform: scale(1.5);
            margin-right: 10px;
        }

        input[type="submit"]{
            margin-top: 40px;
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
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
        <h1>Coches modificables</h1>
        <div class="car-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if (!empty($row)) {
                        ?>
                        <div class="car-box">
                            <img src="/PracticaConcesionario/coches/img/<?php echo $row["foto"]; ?>" alt="Imagen del coche">
                            <h3><?php echo $row["marca"] . ' ' . $row["modelo"]; ?></h3>
                            <p><strong>Precio:</strong> <?php echo $row["precio"]; ?> € </p>
                            <p><strong>Color:</strong> <?php echo $row["color"]; ?></p>
                            <p><strong>Alquilado:</strong> <?php echo $row["alquilado"] ? 'Sí' : 'No'; ?></p>
                            <a href="coches-modificar3.php?id_coche=<?php echo $row['id_coche'];?>" class="button">Modificar</a>
                        </div>
                        <?php
                    }
                }
            } else {
                echo "<p>No se encontraron coches en la base de datos.</p>";
            }
            ?>
        </div>

        <div class="button-container">
            <a href="/PracticaConcesionario/coches/coches-modificar.php" class="button">Volver atras</a>
        </div>
    </div>
</body>
</html>

<?php


