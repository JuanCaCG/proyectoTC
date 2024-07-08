<?php
include 'includes/db.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $libro_id = $_POST['libro_id'];
    $accion = $_POST['accion'];

    if ($accion == 'eliminar') {
        $conn->query("DELETE FROM lista_lectura WHERE usuario_id = $usuario_id AND libro_id = $libro_id");
    } elseif ($accion == 'favorito') {
        $favorito = $conn->query("SELECT favorito FROM lista_lectura WHERE usuario_id = $usuario_id AND libro_id = $libro_id")->fetch_assoc()['favorito'];
        $conn->query("UPDATE lista_lectura SET favorito = !favorito WHERE usuario_id = $usuario_id AND libro_id = $libro_id");
    }
    
    header("Location: usuario.php");
    exit;
}

if ($_GET['id']) {
    $libro_id = $_GET['id'];
    $conn->query("INSERT INTO lista_lectura (usuario_id, libro_id) VALUES ($usuario_id, $libro_id)");
    header("Location: usuario.php");
    exit;
}
?>
