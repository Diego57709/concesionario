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

$nombre = isset($_REQUEST['nombre']) ? htmlspecialchars(trim($_REQUEST['nombre'])) : '';
$apellidos = isset($_REQUEST['apellidos']) ? htmlspecialchars(trim($_REQUEST['apellidos'])) : '';
$dni = isset($_REQUEST['dni']) ? htmlspecialchars(trim($_REQUEST['dni'])) : '';
$min_saldo = isset($_REQUEST['min_saldo']) ? (float)$_REQUEST['min_saldo'] : 0;
$max_saldo = isset($_REQUEST['max_saldo']) ? (float)$_REQUEST['max_saldo'] : 0;

include '../db.php';
    $sql = "SELECT * FROM usuarios WHERE 1=1";
    
    if ($nombre) {
        $sql.= " AND nombre LIKE '%$nombre%'";
    }
    if ($apellidos) {
        $sql.= " AND apellidos LIKE '%$apellidos%'";
    }
    if ($dni) {
        $sql.= " AND dni LIKE '%$dni%'";
    }
    if ($min_saldo > 0 && $max_saldo > 0) {
        $sql .= " AND saldo BETWEEN $min_saldo AND $max_saldo";
    } elseif ($min_saldo > 0) {
        $sql .= " AND saldo >= $min_saldo";
    } elseif ($max_saldo > 0) {
        $sql .= " AND saldo <= $max_saldo";
    }

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
        .user-container p {
            text-align: center;
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
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Lista de usuarios</h1>
        </div>
        <div class="user-container">
            <?php
            if (mysqli_num_rows($result) > 0) {?>
            <table>
            <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Saldo</th>
                    <th>Borrar</th>
                </tr>
                <?php
                while($row = mysqli_fetch_assoc($result)) { ?>
                <form method="post" action="usuarios-borrar3.php">
                    <tr>
                    <input type="text" name="id_usuario" id="id_usuario" value="<?php echo $row['id_usuario'];?>" hidden>
                    <td><?php echo $row['id_usuario']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellidos']; ?></td>
                    <td><?php echo $row['dni']; ?></td>
                    <td><?php echo $row['saldo']; ?></td>
                    <td><input type="submit" value="Borrar"></td>
                </tr>
                </form>
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
