<?php
include 'includes/db.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$libro_id = $_GET['id'];

$stmt = $conn->prepare("INSERT INTO lista_lectura (usuario_id, libro_id) VALUES (?, ?)");
$stmt->bind_param("ii", $usuario_id, $libro_id);
$stmt->execute();
$stmt->close();

header("Location: usuario.php");
exit;
?>
