<?php
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $rol = 'usuario';

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $password, $rol);
    $stmt->execute();
    $stmt->close();

    header("Location: login.php");
}
?>

<main>
    <h2>Registrarse</h2>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Registrarse</button>
    </form>
</main>
</body>
</html>
