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
include '../db.php';

$tipo = $_SESSION['id_usuario'];

$id_coche = $_REQUEST['id_coche'];
$sql = "SELECT * FROM coches WHERE id_coche = '$id_coche'";
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
            margin-top: 20px;
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

        input[type="text"] {
            width: 80%;
            padding: 5px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            font-size: 14px;
            background-color: #f9f9f9;
            width: 50%;
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
        input[type="file"] {
            margin-top: 20px;
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
        }

        input[type="submit"]:hover, 
        .button:hover {
            background-color: #0056b3;
        }
        .model-brand-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .model-brand-container input[type="text"] {
            width: 45%;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Coches encontrados</h1>
            
            <form action="coches-modificar4.php" method="POST" enctype="multipart/form-data">
                <div class="car-container">
                    <?php 
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="car-box">
                                <input type="hidden" name="id_coche" value="<?php echo $row['id_coche']; ?>">
                                <img src="/PracticaConcesionario/coches/img/<?php echo $row["foto"]; ?>" alt="Imagen del coche">
                                <input type="file" name="foto" id="foto">
                                <h3><div class="model-brand-container">
                                        <input type="text" name="modelo" id="modelo" value="<?php echo $row['modelo']; ?>">
                                        <input type="text" name="marca" id="marca" value="<?php echo $row['marca']; ?>">
                                    </div></h3>
                                <p><strong>Precio:</strong> <input type="text" name="precio" id="precio" value="<?php echo $row['precio']; ?>"> €</p>
                                <p><strong>Color:</strong> <input type="text" name="color" id="color" value="<?php echo $row['color']; ?>"></p>
                                <?php if ($tipo == 'administrador') { ?>
                                    <p><strong>Alquilado:</strong> <input type="radio" name="alquilado" id="alquilado" <?php echo $row['alquilado'] ? 'checked' : ''; ?>></p>
                                <?php } ?>
                            </div>
                        <?php 
                        } 
                    } else { ?>
                        <p>No se encontraron coches en la base de datos.</p>
                    <?php 
                    } 
                    ?>
                </div>
                <input type="submit" value="Modificar coches">
            </form>
            <div class="button-container">
                <a href="/PracticaConcesionario/coches/coches-buscar.php" class="button">Volver atrás</a>
            </div>
        </div>
    </div>
</body>
</html>
