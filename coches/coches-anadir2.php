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
$error = "";
$id_vendedor = $_SESSION['id_usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['foto'])) {
    // Obtener datos del formulario
    $modelo = $_REQUEST['modelo'];
    $marca = $_REQUEST['marca'];
    $color = $_REQUEST['color'];
    $precio = $_REQUEST['precio'];
    $alquilado = isset($_REQUEST['alquilado']) ? 1 : 0;

    // Manejar subida de imagen
    $uploadDir = "img/";
    $file = $_FILES['foto'];
    $foto = basename($file['name']);
    $uploadPath = $uploadDir . $foto;

    // Validar que sea una imagen
    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        die("El archivo no es una imagen.");
    }

    // Comprobar si el archivo ya existe
    if (file_exists($uploadPath)) {
        $error = "El archivo ya existe.";
    } else {
        // Mover el archivo al directorio de destino
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Insertar en la base de datos
            $conn = mysqli_connect('localhost', 'root', 'rootroot', 'concesionario') 
                or die("Error al conectar a la base de datos: " . mysqli_connect_error());

            $sql = "INSERT INTO coches(modelo, marca, color, precio, alquilado, foto, id_vendedor) 
                    VALUES ('$modelo', '$marca', '$color', '$precio', '$alquilado', '$foto', $id_vendedor)";

            if (mysqli_query($conn, $sql)) {
                echo "Coche añadido correctamente.";
            } else {
                echo "Error al insertar los datos: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        } else {
            $error = "Error al subir el archivo.";
        }
    }
} else {
    $error = "No se ha recibido ningún dato.";
}
?>

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
        <?php if (!empty($error)) { ?>
            <h3><?php echo $error; ?></h3>
        <?php } elseif (!empty($modelo) && !empty($marca)) { ?>
            <h3><?php echo "$modelo $marca añadido correctamente"; ?></h3>
        <?php } ?>
    </div>
    </div>
</body>
</html>

<?php
?>

