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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../db.php';
    
    $nombre = isset($_REQUEST['nombre']) ? htmlspecialchars(trim($_REQUEST['nombre'])) : '';
    $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
    $apellidos = isset($_REQUEST['apellidos']) ? htmlspecialchars(trim($_REQUEST['apellidos'])) : '';
    $dni = isset($_REQUEST['dni']) ? htmlspecialchars(trim($_REQUEST['dni'])) : '';
    $saldo = isset($_REQUEST['saldo']) ? (float)$_REQUEST['saldo'] : 0.0;
    $accion = isset($_REQUEST['accion']) ? htmlspecialchars(trim($_REQUEST['accion'])) : '';
    
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (password, nombre, apellidos, dni, saldo, tipo_usuario) VALUES ('$hash', '$nombre', '$apellidos', '$dni', $saldo, '$accion')";
    }
?>

<?php
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
        input[type="number"],
        input[type="password"] {
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
            <h1>Página de registro</h1>
            <?php
            if (mysqli_query($conn, $sql)) { ?>
                <h3>Registro exitoso!<h3>
                <h3>Puede volver a la página de inicio<h3>
                <a href="/PracticaConcesionario/index.php" class="button">Volver al inicio</a>
                <a href="../" class="button">Volver atrás</a>
            <?php } else { ?>
                <h3>Fallo en el registro</h3><h3>Por favor, vuelva a intentarlo</h3>
                <?php
                ?>
                <a href="/PracticaConcesionario/index.php" class="button">Volver al inicio</a>
                <a href="/PracticaConcesionario/usuarios/usuarios-anadir.php" class="button">Volver atrás</a>
            <?php } ?>
        
        </div>
    </div>
</body>
</html>


