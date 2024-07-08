<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'administrador') {
    header("Location: index.php");
    exit();
}

$libro_id = $_GET['id'];

// Eliminar libro de la base de datos
$stmt = $conn->prepare("DELETE FROM libros WHERE id = ?");
$stmt->bind_param('i', $libro_id);
$stmt->execute();
$stmt->close();

header("Location: administrador.php");
exit();
?>
