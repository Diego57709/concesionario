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
}
include '../header.view.php';
include '../db.php';

$id = $_SESSION['id_usuario'];
$sql = "SELECT 
    a.id_alquiler,
    u.nombre,
    u.apellidos,
    u.dni,
    c.id_coche,
    c.modelo,
    c.marca,
    c.color,
    c.precio,
    c.foto,
    a.prestado,
    a.devuelto
FROM 
    alquileres a
JOIN 
    usuarios u ON a.id_usuario = u.id_usuario
JOIN 
    coches c ON a.id_coche = c.id_coche
WHERE u.id_usuario = '$id'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
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
        .alert {
        display: block;
        width: fit-content;
        max-width: 80%;
        padding: 15px;
        margin: 20px auto;
        text-align: center;
        font-size: 16px;
        border-radius: 4px;
        }
        .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content">
        <h1>Listado de coches</h1>
        <?php
            if (isset($_GET['error'])) {
                $errorMsg = "";
                switch ($_GET['error']) {
                    case 1: $errorMsg = "Usuario no encontrado."; break;
                    case 2: $errorMsg = "Contraseña incorrecta."; break;
                    case 3: $errorMsg = "Fallo al actualizar el alquiler."; break;
                    case 4: $errorMsg = "Fallo al actualizar el coche."; break;
                    default: $errorMsg = "Error desconocido.";
                }
                echo "<div class='alert alert-danger'>$errorMsg</div>";
            }
            if (isset($_GET['msg'])) {
                echo "<div class='alert alert-warning'>Debug: " . urldecode($_GET['msg']) . "</div>";
            }
            if (isset($_GET['success'])) {
                echo "<div class='alert alert-success'>Coche devuelto con éxito.</div>";
            }
        ?>
        </div>
        <div class="alquiler-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="alquiler-box">
                <img src="/PracticaConcesionario/coches/img/<?php echo $row['foto']?>" alt="Imagen del coche">
                <p><strong>Usuario:</strong> <?php echo $row["nombre"] ?></p>
                <p><strong>Coche:</strong> <?php echo $row["marca"] . ' ' . $row["modelo"] ?></p>
                <p><strong>Fecha de prestado:</strong><br> <?php echo $row["prestado"] ?></p>
                <form action="alquiler-devolver.php" method="post">
                <input type="hidden" name="id_alquiler" value="<?php echo $row["id_alquiler"]?>">
                <input type="hidden" name="id_coche" value="<?php echo $row["id_coche"]?>">
                <!-- El botón ahora es de tipo "button" para evitar el submit inmediato -->
                <button type="button" class="button devolver-btn">Devolver</button>
                </form>
            </div>
        <?php
            }
        } else {
            echo "<p>No tienes ningún coche para alquilar.</p>";
        }
        ?>
        </div>
        <div class="button-container">
        <a href="../index.php" class="button">Volver al inicio</a>
        </div>
    </div>
    <script>
        document.querySelectorAll('.devolver-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            var password = prompt("Por favor, ingrese su contraseña para devolver el coche:");
            if (password !== null && password.trim() !== ""){
            var form = this.closest("form");
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "password";
            input.value = password;
            form.appendChild(input);
            form.submit();
            }
        });
        });
    </script>
</body>
</html>
