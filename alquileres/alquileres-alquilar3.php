<?php
session_start();
include '../db.php';

if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['tipo_usuario'])) {
    header("Location: /PracticaConcesionario/usuarios/usuarios-iniciar.php");
    exit();
}

if ($_SESSION['tipo_usuario'] === 'vendedor') {
    header("Location: /PracticaConcesionario/index.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id_coche = $_POST['id_coche'];
$password = $_POST['password'];

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

// Verificar que el coche existe y obtener su precio y vendedor
$sqlCoche = "SELECT id_coche, marca, modelo, precio, id_vendedor FROM coches WHERE id_coche = '$id_coche'";
$resultCoche = mysqli_query($conn, $sqlCoche);
$car = mysqli_fetch_assoc($resultCoche);

if (!$car) {
    header("Location: alquileres-alquilar2.php?error=3&id_coche=$id_coche");
    exit();
}

$id_vendedor = $car['id_vendedor'];
$precio_coche = (float) $car['precio'];
$saldo_actual = (float) $user['saldo'];
$saldo_restante = $saldo_actual - $precio_coche;

if ($saldo_restante < 0) {
    header("Location: alquileres-alquilar2.php?error=4&id_coche=$id_coche");
    exit();
}

// Registrar el alquiler
$sqlInsert = "INSERT INTO alquileres (id_usuario, id_coche, prestado) VALUES ('$id_usuario', '$id_coche', NOW())";
if (!mysqli_query($conn, $sqlInsert)) {
    header("Location: alquileres-alquilar2.php?error=5&id_coche=$id_coche");
    exit();
}

// Actualizar el dinero del comprador
$sqlUpdateSaldoComprador = "UPDATE usuarios SET saldo = '$saldo_restante' WHERE id_usuario = '$id_usuario'";
if (!mysqli_query($conn, $sqlUpdateSaldoComprador)) {
    header("Location: alquileres-alquilar2.php?error=6&id_coche=$id_coche");
    exit();
}

// Actualizar dinero del vendedor
$sqlUpdateSaldoVendedor = "UPDATE usuarios SET saldo = saldo + '$precio_coche' WHERE id_usuario = '$id_vendedor'";
if (!mysqli_query($conn, $sqlUpdateSaldoVendedor)) {
    header("Location: alquileres-alquilar2.php?error=7&id_coche=$id_coche");
    exit();
}

// Marcar el coche como alquilado
$sqlUpdateCoche = "UPDATE coches SET alquilado = 1 WHERE id_coche = '$id_coche'";
if (!mysqli_query($conn, $sqlUpdateCoche)) {
    header("Location: alquileres-alquilar2.php?error=8&id_coche=$id_coche");
    exit();
}

// Redirigir con éxito
header("Location: alquileres-listar.php?success=1");
exit();
?>
