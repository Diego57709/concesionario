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
include '../db.php';

$password = $_REQUEST['password'];
$id_coche = $_REQUEST['id_coche'];
$id_usuario = $_SESSION['id_usuario'];


$sqlUser = "SELECT id_usuario, nombre, apellidos, dni, saldo, tipo_usuario, password FROM usuarios WHERE id_usuario = '$id_usuario'";
$resultUser = mysqli_query($conn, $sqlUser);
$user = mysqli_fetch_assoc($resultUser);

if (!$user) {
    header("Location: alquileres-alquilar2.php?error=1&id_coche=$id_coche");
    exit();
}

if (!password_verify($password, $user['password'])) {
    header("Location: alquileres-alquilar2.php?error=2&id_coche=$id_coche");
    exit();
}

$sqlCoche = "SELECT id_coche, marca, modelo, precio FROM coches WHERE id_coche = '$id_coche'";
$resultCoche = mysqli_query($conn, $sqlCoche);
$car = mysqli_fetch_assoc($resultCoche);

if (!$car) {
    header("Location: alquileres-alquilar2.php?error=3&id_coche=$id_coche");
    exit();
}

$saldo_actual = (float) $user['saldo'];
$precio_coche = (float) $car['precio'];
$saldo_restante = $saldo_actual - $precio_coche;

if ($saldo_restante < 0) {
    header("Location: alquileres-alquilar2.php?error=4&id_coche=$id_coche");
    exit();
}

$sqlInsert = "INSERT INTO alquileres (id_usuario, id_coche, prestado) VALUES ('$id_usuario', '$id_coche', NOW())";
if (!mysqli_query($conn, $sqlInsert)) {
    header("Location: alquileres-alquilar2.php?error=5&id_coche=$id_coche");
    exit();
}

$sqlUpdateSaldo = "UPDATE usuarios SET saldo = '$saldo_restante' WHERE id_usuario = '$id_usuario'";
if (!mysqli_query($conn, $sqlUpdateSaldo)) {
    header("Location: alquileres-alquilar2.php?error=6&id_coche=$id_coche");
    exit();
}

$sqlUpdateCoche = "UPDATE coches SET alquilado = '1' WHERE id_coche = '$id_coche'";
if (!mysqli_query($conn, $sqlUpdateCoche)) {
    header("Location: alquileres-alquilar2.php?error=7&id_coche=$id_coche");
    exit();
}

header("Location: alquileres-listar.php?success=1");
exit();

?>
