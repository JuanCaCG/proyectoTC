<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Digital</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="img/logo.png" alt="Logo Biblioteca Digital">
    </div>
    <h1>Biblioteca Digital</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <?php if(isset($_SESSION['usuario_id'])): ?>
                <li><a href="usuario.php">Mi Lista de Lectura</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
                <li><a href="register.php">Registrarse</a></li>
            <?php endif; ?>
            <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'administrador'): ?>
                <li><a href="administrador.php">Administrar Libros</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
