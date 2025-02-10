<?php
session_start(); // Iniciar sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menú Principal</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      background: #f4f4f4;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
      background: linear-gradient(45deg, #333, #222);
      color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    nav {
      display: flex;
      gap: 50px;
    }

    .dropdown {
      position: relative;
      font-size: 16px;
      font-weight: bold;
    }

    .dropdown a {
      color: white;
      text-decoration: none;
      transition: 0.3s;
      padding: 10px;
      display: inline-block;
    }

    .dropdown a:hover {
      color: #00d2ff;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: #444;
      padding: 10px 0;
      border-radius: 5px;
      min-width: 180px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      transition: 0.3s ease-in-out;
      opacity: 0;
      visibility: hidden;
    }

    .dropdown-content a {
      display: block;
      padding: 10px;
      text-decoration: none;
      color: white;
      font-size: 14px;
      transition: 0.3s;
    }

    .dropdown-content a:hover {
      background-color: #555;
      padding-left: 15px;
    }

    .dropdown:hover .dropdown-content {
      display: block;
      opacity: 1;
      visibility: visible;
    }

    /* Botón de sesión */
    .session-button {
      background: linear-gradient(45deg, #007BFF, #00d2ff);
      color: white;
      padding: 8px 15px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
      box-shadow: 0 2px 5px rgba(0, 123, 255, 0.4);
    }

    .session-button:hover {
      transform: scale(1.05);
      background: linear-gradient(45deg, #00d2ff, #007BFF);
      box-shadow: 0 4px 8px rgba(0, 123, 255, 0.6);
    }
  </style>
</head>
<body>
  <header>
    <h1>Hola, <?php echo $nombre = $_SESSION['nombre'] ? $_SESSION['nombre'] : "Invitado";?>!</h1>
    <nav>
      <div class="dropdown">
        <a href="#">Coches</a>
        <div class="dropdown-content">
          <?php 
          // Si no hay sesión iniciada, mostrar opciones básicas
          if (!isset($_SESSION['tipo_usuario'])) { 
          ?>
            <a href="/PracticaConcesionario/index.php">Inicio</a>
            <a href="/PracticaConcesionario/coches/coches-listar.php">Listar</a>
            <a href="/PracticaConcesionario/coches/coches-buscar.php">Buscar</a>
          <?php 
          } else {
            $tipo = $_SESSION['tipo_usuario'];
            if ($tipo == 'administrador') { ?>
              <a href="/PracticaConcesionario/index.php">Inicio</a>
              <a href="/PracticaConcesionario/coches/coches-anadir.php">Añadir</a>
              <a href="/PracticaConcesionario/coches/coches-listar.php">Listar</a>
              <a href="/PracticaConcesionario/coches/coches-buscar.php">Buscar</a>
              <a href="/PracticaConcesionario/coches/coches-modificar.php">Modificar</a>
              <a href="/PracticaConcesionario/coches/coches-borrar.php">Borrar</a>
            <?php 
            } elseif ($tipo == 'vendedor') { ?>
              <a href="/PracticaConcesionario/index.php">Inicio</a>
              <a href="/PracticaConcesionario/coches/coches-anadir.php">Añadir</a>
              <a href="/PracticaConcesionario/coches/coches-listar.php">Listar</a>
              <a href="/PracticaConcesionario/coches/coches-buscar.php">Buscar</a>
              <a href="/PracticaConcesionario/coches/coches-modificar.php">Modificar</a>
            <?php 
            } elseif ($tipo == 'comprador') { ?>
              <a href="/PracticaConcesionario/index.php">Inicio</a>
              <a href="/PracticaConcesionario/coches/coches-listar.php">Listar</a>
              <a href="/PracticaConcesionario/coches/coches-buscar.php">Buscar</a>
            <?php 
            }
          } 
          ?>
        </div>
      </div>
      
      <!-- Dropdown "Usuarios" -->
      <div class="dropdown">
        <a href="#">Usuarios</a>
        <div class="dropdown-content">
          <a href="/PracticaConcesionario/index.php">Inicio</a>
          <?php 
          if (!isset($_SESSION['tipo_usuario'])) { 
          ?>
            <a href="/PracticaConcesionario/usuarios/usuarios-iniciar.php" class="session-button">Iniciar sesión</a>
          <?php 
          } else {
            $tipo = $_SESSION['tipo_usuario'];
            // Solo el administrador puede gestionar usuarios
            if ($tipo == 'administrador') { ?>
              <a href="/PracticaConcesionario/usuarios/usuarios-anadir.php">Añadir</a>
              <a href="/PracticaConcesionario/usuarios/usuarios-listar.php">Listar</a>
              <a href="/PracticaConcesionario/usuarios/usuarios-buscar.php">Buscar</a>
              <a href="/PracticaConcesionario/usuarios/usuarios-modificar.php">Modificar</a>
              <a href="/PracticaConcesionario/usuarios/usuarios-borrar.php">Borrar</a>
            <?php 
            } elseif ($tipo == 'vendedor') { ?>
              <a href="/PracticaConcesionario/usuarios/usuarios-modificar3.php">Modificar</a>
            <?php 
            } elseif ($tipo == 'comprador') { ?>
              <a href="/PracticaConcesionario/usuarios/usuarios-modificar3.php">Modificar</a>
            <?php 
            } 
            ?>
            <?php } ?>
            <a href="/PracticaConcesionario/usuarios/usuarios-cerrar.php" class="session-button">Cerrar sesión</a>
          <?php 
          ?>
        </div>
      </div>
      
      <!-- Dropdown "Alquileres" (sólo se muestra si hay sesión iniciada) -->
      <?php if (isset($_SESSION['tipo_usuario'])) { ?>
        <div class="dropdown">
          <a href="#">Alquileres</a>
          <div class="dropdown-content">
            <?php 
            $tipo = $_SESSION['tipo_usuario'];
            if ($tipo == 'administrador') { ?>
              <a href="/PracticaConcesionario/index.php">Inicio</a>
              <a href="/PracticaConcesionario/alquileres/alquileres-listar.php">Listar</a>
              <a href="/PracticaConcesionario/alquileres/alquileres-borrar.php">Borrar</a>
            <?php 
            } elseif ($tipo == 'vendedor') { ?>
              <a href="/PracticaConcesionario/index.php">Inicio</a>
              <a href="/PracticaConcesionario/alquileres/alquileres-listar.php">Listar</a>
              <a href="/PracticaConcesionario/alquileres/alquileres-anadir.php">Añadir</a>
            <?php 
            } elseif ($tipo == 'comprador') { ?>
              <a href="/PracticaConcesionario/index.php">Inicio</a>
              <a href="/PracticaConcesionario/alquileres/alquileres-listar.php">Listar</a>
              <a href="/PracticaConcesionario/alquileres/alquileres-alquilar.php">Alquilar</a>
            <?php 
            } 
            ?>
          </div>
        </div>
      <?php } ?>
      
    </nav>
  </header>
</body>
</html>
