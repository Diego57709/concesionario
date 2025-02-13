<?php
session_start();
include '../header.view.php';
include '../db.php';

$tipo = $_SESSION['tipo_usuario'] ?? '';

// Aplicar filtro si el usuario es vendedor
if ($tipo == 'vendedor' && isset($_GET['mostrar']) && $_GET['mostrar'] == 'tuyos') {
    $id_vendedor = $_SESSION['id_usuario'];
    $sql = "SELECT * FROM coches WHERE id_vendedor = '$id_vendedor'";
} else {
    $sql = "SELECT * FROM coches";
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
        .filtro-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filtro-container label {
            color: white;
            font-size: 16px;
        }

        .filtro-container select {
            background: #333;
            color: white;
            border: 1px solid #555;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .filtro-container .button {
            background: #007BFF;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            transition: 0.2s;
        }

        .filtro-container .button:hover {
            background: #0056b3;
        }

    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Listado de coches</h1>
            <?php if ($tipo == 'vendedor') { ?>
                <form method="GET">
                    <div class="filtro-container">
                        <label for="mostrar">Filtrar coches:</label>
                        <select name="mostrar" id="mostrar">
                            <option value="todos" <?= (!isset($_GET['mostrar']) || $_GET['mostrar'] == 'todos') ? 'selected' : '' ?>>Todos</option>
                            <option value="tuyos" <?= (isset($_GET['mostrar']) && $_GET['mostrar'] == 'tuyos') ? 'selected' : '' ?>>Tuyos</option>
                        </select>
                        <button type="submit" class="button">Filtrar</button>
                    </div>
                </form>
            <?php } ?>
        </div>

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
                echo "<p>No se encontraron coches.</p>";
            }
            ?>
        </div>

        <div class="button-container">
            <a href="../index.php" class="button">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
