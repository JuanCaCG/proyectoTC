<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'administrador') {
    header("Location: index.php");
    exit();
}

$libro_id = $_GET['id'];

// Obtener detalles del libro a editar
$stmt = $conn->prepare("SELECT * FROM libros WHERE id = ?");
$stmt->bind_param('i', $libro_id);
$stmt->execute();
$result = $stmt->get_result();
$libro = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $anio = $_POST['anio'];
    $genero = $_POST['genero'];

    // Actualizar datos del libro
    $stmt = $conn->prepare("UPDATE libros SET titulo = ?, autor = ?, anio = ?, genero = ? WHERE id = ?");
    $stmt->bind_param('sssii', $titulo, $autor, $anio, $genero, $libro_id);
    $stmt->execute();
    $stmt->close();

    header("Location: administrador.php");
    exit();
}
?>

<main>
    <h2>Editar Libro</h2>
    <form method="POST" action="editar_libro.php?id=<?php echo $libro_id; ?>">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
        
        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>
        
        <label for="anio">Año:</label>
        <input type="number" id="anio" name="anio" value="<?php echo htmlspecialchars($libro['anio']); ?>" required>
        
        <label for="genero">Género:</label>
        <input type="text" id="genero" name="genero" value="<?php echo htmlspecialchars($libro['genero']); ?>" required>
        
        <button type="submit">Actualizar</button>
    </form>
</main>

</body>
</html>
