<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $libro_id = $_POST['libro_id'];

    $stmt = $conn->prepare("DELETE FROM lista_lectura WHERE usuario_id = ? AND libro_id = ?");
    $stmt->bind_param("ii", $usuario_id, $libro_id);
    $stmt->execute();
    $stmt->close();

    header("Location: usuario.php");
    exit;
}

$result = $conn->query("SELECT libros.* FROM libros JOIN lista_lectura ON libros.id = lista_lectura.libro_id WHERE lista_lectura.usuario_id = $usuario_id");
?>

<main>
    <h2>Mi Lista de Lectura</h2>
    <div class="libros">
        <?php while($libro = $result->fetch_assoc()): ?>
            <div class="libro">
                <h3><?php echo $libro['titulo']; ?></h3>
                <p>Autor: <?php echo $libro['autor']; ?></p>
                <p>Año: <?php echo $libro['anio']; ?></p>
                <p>Género: <?php echo $libro['genero']; ?></p>
                <form method="POST" action="usuario.php">
                    <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <button type="submit">Eliminar</button>
                </form>
                <form method="POST" action="usuario.php">
                    <input type="checkbox" name="leido" value="1"> Marcar como leído
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</main>
</body>
</html>
