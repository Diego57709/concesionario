<?php
session_start();
include '../header.view.php';

include '../db.php';

$sql = "SELECT * FROM usuarios";
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
            border-collapse: collapse;
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
            <h1>Lista de usuarios</h1>
        </div>
        <div class="user-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Saldo</th>
                </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                    <td><?php echo $row['id_usuario']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellidos']; ?></td>
                    <td><?php echo $row['dni']; ?></td>
                    <td><?php echo $row['saldo']; ?></td>
                </tr>
                <?php }
            } else {
                echo "<p>No se encontraron usuarios</p>";
            }
            ?>
            </table>
        </div>
        <div class="button-container">
            <a href="../index.php" class="button">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
