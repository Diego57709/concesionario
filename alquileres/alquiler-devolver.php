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

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id_usuario  = $_SESSION['id_usuario'];
$id_alquiler = $_POST['id_alquiler'];
$id_coche    = $_POST['id_coche'];
$password    = $_POST['password'];

// Verificar usuario y contraseña
$sqlUser = "SELECT password FROM usuarios WHERE id_usuario = '$id_usuario'";
$resultUser = mysqli_query($conn, $sqlUser);
if (!$resultUser || mysqli_num_rows($resultUser) == 0) {
    header("Location: alquileres-listar.php?error=1"); // Error 1: Usuario no encontrado
    exit();
}

$user = mysqli_fetch_assoc($resultUser);
if (!password_verify($password, $user['password'])) {
    header("Location: alquileres-listar.php?error=2"); // Error 2: Contraseña incorrecta
    exit();
}

// Marcar el alquiler como devuelto (esto activará el trigger)
$sqlUpdateAlquiler = "UPDATE alquileres SET devuelto = NOW() WHERE id_alquiler = '$id_alquiler' AND id_usuario = '$id_usuario'";
if (!mysqli_query($conn, $sqlUpdateAlquiler)) {
    header("Location: alquileres-listar.php?error=3&msg=" . urlencode(mysqli_error($conn))); // Error 3: Fallo al actualizar alquiler
    exit();
}

// Eliminar el alquiler (el trigger ya lo registra en `log_alquileres`)
$sqlDeleteAlquiler = "DELETE FROM alquileres WHERE id_alquiler = '$id_alquiler'";
if (!mysqli_query($conn, $sqlDeleteAlquiler)) {
    header("Location: alquileres-listar.php?error=4&msg=" . urlencode(mysqli_error($conn))); // Error 4: Fallo al eliminar alquiler
    exit();
}

// Actualizar estado del coche para que esté disponible
$sqlUpdateCoche = "UPDATE coches SET alquilado = 0 WHERE id_coche = '$id_coche'";
if (!mysqli_query($conn, $sqlUpdateCoche)) {
    header("Location: alquileres-listar.php?error=5&msg=" . urlencode(mysqli_error($conn))); // Error 5: Fallo al actualizar coche
    exit();
}

// Redirigir con éxito
header("Location: alquileres-listar.php?success=1");
exit();
?>
