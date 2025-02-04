<?php
session_start();
include '../header.view.php';
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
        }
        .main-container {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            margin: 20px auto;
            padding: 20px;
            background-color: #333;
            width: 80%;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .content {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 300px;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="checkbox"] {
            transform: scale(1.5);
            margin-right: 10px;
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

        .button {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Añadir coches</h1>
            <form action="coches-anadir2.php" method="POST" enctype="multipart/form-data" >
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" required>

                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required>

                <label for="color">Color:</label>
                <input type="text" id="color" name="color" required>

                <label for="precio">Precio:</label>
                <input type="text" id="precio" name="precio" required>

                <div>
                    <label for="alquilado">Alquilado</label><br><br>
                    <input type="checkbox" id="alquilado" name="alquilado">
                </div>

                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>

                <input type="submit" value="Añadir">
            </form>
            <a href="../index.php" class="button">Volver al inicio</a>
        </div>
    </div>
</body>
</html>

<?php
/*
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
        $modelo = $_REQUEST['modelo'];
        $marca = $_REQUEST['marca'];
        $color = $_REQUEST['color'];
        $precio = $_REQUEST['precio'];
        $precio = $_REQUEST['precio'];
        $alquilado = isset($_REQUEST['alquilado']) ? 1 : 0;
        $foto = $_REQUEST['foto'];

        $conn = mysqli_connect('localhost', 'root', 'rootroot', 'concesionario') 
            or die ("Fallo accediendo:" . mysqli_connect_error());

        $sql = "INSERT INTO coches(modelo, marca, color, precio, alquilado, foto) VALUES ('$modelo', '$marca', '$color', '$precio', '$alquilado', '$foto')";

        mysqli_query($conn, $sql)
            or die ("Error al insertar los datos". mysqli_error($conn));
        


        mysqli_close($conn);
}*/
?>

