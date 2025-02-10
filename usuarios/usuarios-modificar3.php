<?php
session_start();
include '../header.view.php';

include '../db.php';

if (isset($_REQUEST['id_usuario'])) {
    $id_usuario = $_REQUEST['id_usuario'];
} else {
    $id_usuario = $_SESSION['id_usuario'];
}
$sql = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <style>
        body {
            background: linear-gradient(to right, #141E30, #243B55);
            font-family: Arial, sans-serif;
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

        .user-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }

        .user-container table {
            text-align: center;
            width: 80%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
        }

        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        input[type="text"]:focus {
            border-color: #007BFF;
            outline: none;
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
            display: inline-block;
            margin-top: 20px;
        }

        input[type="submit"]:hover, 
        .button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            input[type="text"] {
                width: 100%;
            }

            .user-container table {
                width: 100%;
            }
        }

    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <form action="usuarios-modificar4.php" method="POST">
                <h1>Datos a Modificar</h1>
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
                            $row = mysqli_fetch_assoc($result); ?>
                            <tr>
                                <input type="hidden" name="id_usuario" value="<?php echo $row['id_usuario']; ?>">
                                <td><?php echo $row['id_usuario']; ?></td>
                                <td><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"></td>
                                <td><input type="text" name="apellidos" value="<?php echo $row['apellidos']; ?>"></td>
                                <td><input type="text" name="dni" value="<?php echo $row['dni']; ?>"></td>
                                <td><input type="text" name="saldo" value="<?php echo $row['saldo']; ?>"></td>
                            </tr>
                        <?php 
                        } else {
                            echo "<p>No se encontraron usuarios</p>";
                        }
                        ?>
                    </table>
                    <input type="submit" value="Modificar">
                </form>
            </div>
            <div class="button-container">
                <a href="/PracticaConcesionario/usuarios/usuarios-modificar.php" class="button">Volver atrás</a>
            </div>
        </div>
    </div>
</body>
</html>