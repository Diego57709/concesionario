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

$id_coche = $_GET['id_coche'];
$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT c.id_coche, c.marca, c.modelo, c.precio, c.foto
FROM coches c
WHERE c.id_coche = '$id_coche'";

$sqlUser = "SELECT u.id_usuario, u.saldo FROM usuarios u WHERE u.id_usuario = '$id_usuario'";

$result = mysqli_query($conn, $sql);
$resultUser = mysqli_query($conn, $sqlUser);

$row = mysqli_fetch_assoc($result);
$rowUser = mysqli_fetch_assoc($resultUser);

$saldo_actual = $rowUser['saldo'];
$precio_coche = $row['precio'];
$saldo_restante = $saldo_actual - $precio_coche;

// Determinar si el saldo es insuficiente
$saldo_insuficiente = $saldo_restante < 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar alquiler</title>
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

        .alquiler-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .car-details {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            color: #333;
        }

        .car-details img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .car-details p {
            font-size: 18px;
            margin: 5px 0;
        }

        .form-container {
            background-color: #444;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-container h2 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .form-container form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-container form input[type="password"] {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
            width: 90%;
        }

        .saldo-info {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }

        .error-msg {
            color: red;
            font-weight: bold;
        }

        .form-container form .button {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: 0.3s;
        }

        .form-container form .button:hover {
            background-color: #0056b3;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container a {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
        }

        .button-container a:hover {
            background-color: #0056b3;
        }

        .disabled-button {
            background-color: grey !important;
            cursor: not-allowed;
        }
        .alert {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
            width: auto;
            margin: 10px auto;
            padding: 15px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

    <script>
        function verificarSaldo() {
            var saldoInsuficiente = <?php echo ($saldo_insuficiente); ?>;
            var boton = document.getElementById("confirmButton");
            var errorMsg = document.getElementById("errorSaldo");

            if (saldoInsuficiente) {
                boton.disabled = true;
                boton.classList.add("disabled-button");
                errorMsg.style.display = "block";
            } else {
                boton.disabled = false;
                boton.classList.remove("disabled-button");
                errorMsg.style.display = "none";
            }
        }

        window.onload = verificarSaldo;
    </script>
</head>
<body>
    <div class="main-container">
        <div class="content">
            <h1>Solicitar alquiler</h1>
        </div>
        <div class="alquiler-container">
            <!-- Detalles del coche -->
            <div class="car-details">
                <img src="/PracticaConcesionario/coches/img/<?php echo $row['foto']; ?>" alt="Imagen del coche">
                <p><strong><?php echo $row["marca"] . ' ' . $row["modelo"]; ?></strong></p>
                <p><strong>Precio: </strong><?php echo $row["precio"]; ?>€</p>
            </div>
            <!-- Formulario para contraseña y saldo -->
            <div class="form-container">
            <?php
                if (isset($_GET['error'])) {
                    $errorMsg = "";
                    switch ($_GET['error']) {
                        case 1: $errorMsg = "Usuario no encontrado."; break;
                        case 2: $errorMsg = "Contraseña incorrecta."; break;
                        case 3: $errorMsg = "Coche no encontrado."; break;
                        case 4: $errorMsg = "Saldo insuficiente."; break;
                        case 5: $errorMsg = "Error al registrar el alquiler."; break;
                        case 6: $errorMsg = "Error al actualizar el saldo."; break;
                        case 7: $errorMsg = "Error al marcar el coche como alquilado."; break;
                        default: $errorMsg = "Error desconocido.";
                    }
                    echo "<div class='alert alert-danger'>$errorMsg</div>";
                }
                ?>
                <h2>Reingresar contraseña</h2>
                <form action="alquileres-alquilar3.php" method="POST">
                    <input type="password" name="password" placeholder="Ingrese su contraseña" required>
                    <div class="saldo-info">
                        <p>Saldo actual: <strong><?php echo $saldo_actual; ?>€</strong></p>
                        <p>Precio: <strong>- <?php echo $precio_coche; ?>€</strong></p>
                        <hr style="border: 1px dashed white; margin: 10px 0;">
                        <p>Saldo restante: <strong><?php echo $saldo_restante; ?>€</strong></p>
                        <div id="errorSaldo" class="alert alert-danger" style="display: none;">
                            Saldo insuficiente para alquilar este coche.
                        </div>
                    </div>
                    <!-- Inputs ocultos y botón -->
                    <input type="hidden" name="id_coche" value="<?php echo $id_coche; ?>">
                    <button type="submit" id="confirmButton" class="button">Confirmar alquiler</button>
                </form>
            </div>
        </div>
        <!-- Botón para volver al inicio -->
        <div class="button-container">
            <a href="../index.php">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
