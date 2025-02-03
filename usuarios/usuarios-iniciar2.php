<?php
session_start();
include '../header.view.php';
include '../db.php';

if (!isset($_REQUEST['dni']) || !isset($_REQUEST['password'])) {
    header('Location:usuarios-iniciar.php?error=1');
    exit();
}

$dni = $_REQUEST['dni'];
$password = $_REQUEST['password'];


$sql = "SELECT * FROM usuarios WHERE dni = '$dni'";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['apellidos'] = $row['apellidos'];
        $_SESSION['dni'] = $row['dni'];
        $_SESSION['saldo'] = $row['saldo'];

        header('Location: ../index.php');
        exit();
    } else {
        header('Location: usuarios-iniciar.php?error=2');
        exit();
    }
} else {
    header('Location: usuarios-iniciar.php?error=2');
}
mysqli_close($conn);
?>
