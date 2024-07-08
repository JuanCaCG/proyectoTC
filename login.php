<?php
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = $conn->query("SELECT * FROM usuarios WHERE email='$email' AND password='$password'");

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['rol'] = $usuario['rol'];
        header("Location: index.php");
        exit(); // Asegúrate de detener la ejecución del script después de la redirección
    } else {
        echo "<p>Email o contraseña incorrectos.</p>";
    }
}
?>

<main>
    <h2>Iniciar Sesión</h2>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
</main>
</body>
</html>
