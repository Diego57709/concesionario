<?php
session_start();
include '../header.view.php';

include '../db.php';
    $id_alquiler = $_REQUEST['id_alquiler'];
    $sql1 = "SELECT 
    a.id_alquiler,
    u.nombre,
    u.apellidos,
    c.modelo,
    c.marca
FROM 
    alquileres a
JOIN 
    usuarios u ON a.id_usuario = u.id_usuario
JOIN 
    coches c ON a.id_coche = c.id_coche
WHERE 
    a.id_alquiler = $id_alquiler;
";
    $result1 = mysqli_query($conn, $sql1);
    if ($result1 && mysqli_num_rows($result1) > 0) {
        $row = mysqli_fetch_assoc($result1);
        $marca_coche = $row['marca'];
        $modelo_coche = $row['modelo'];
    }
    $sql2 = "DELETE FROM alquileres WHERE id_alquiler = $id_alquiler";

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
            <h1>Alquiler borrado</h1>
            <div class="user-container">            

                <?php
                if (mysqli_query($conn, $sql2)) {
                    echo 'Alquiler de '. $row['nombre'].' eliminado correctamente';
                } else {
                    echo "Error al eliminar el alquiler";
                }
                ?>

        </div>
        <div class="button-container">
            <a href="/PracticaConcesionario/usuarios/usuarios-borrar.php" class="button">Volver atras</a>
            <a href="/PracticaConcesionario/usuarios/usuarios-listar.php" class="button">Volver al listado</a>
        </div>
    </div>
</body>
</html>

