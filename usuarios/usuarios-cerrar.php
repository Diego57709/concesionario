<?php
session_start();
session_destroy();
header("Location: /PracticaConcesionario/usuarios/usuarios-iniciar.php");
exit;
?>
