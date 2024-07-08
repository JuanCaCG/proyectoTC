<?php
include 'includes/db.php';

session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'administrador') {
    header("Location: login.php");
    exit;
}

// Añadir libro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'añadir') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $anio = $_POST['anio'];
    $genero = $_POST['genero'];

    $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, anio, genero) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $titulo, $autor, $anio, $genero);
    $stmt->execute();
    $stmt->close();

    header("Location: administrador.php");
    exit;
}

// Eliminar libro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $libro_id = $_POST['libro_id'];

    $stmt = $conn->prepare("DELETE FROM libros WHERE id = ?");
    $stmt->bind_param("i", $libro_id);
    $stmt->execute();
    $stmt->close();

    header("Location: administrador.php");
    exit;
}

// Editar libro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'editar') {
    $libro_id = $_POST['libro_id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $anio = $_POST['anio'];
    $genero = $_POST['genero'];

    $stmt = $conn->prepare("UPDATE libros SET titulo = ?, autor = ?, anio = ?, genero = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $titulo, $autor, $anio, $genero, $libro_id);
    $stmt->execute();
    $stmt->close();

    header("Location: administrador.php");
    exit;
}

// Obtener libros
$result = $conn->query("SELECT * FROM libros");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Biblioteca</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header>
    <?php include 'includes/header.php'; ?>
</header>
<main>
    <h2>Administrar Biblioteca</h2>

    <h3>Añadir Libro</h3>
    <form method="POST" action="administrador.php">
        <input type="hidden" name="accion" value="añadir">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required>
        <label for="autor">Autor:</label>
        <input type="text" name="autor" required>
        <label for="anio">Año:</label>
        <input type="number" name="anio" required>
        <label for="genero">Género:</label>
        <input type="text" name="genero" required>
        <button type="submit">Añadir Libro</button>
    </form>

    <h3>Libros en la Biblioteca</h3>
    <div class="libros">
        <?php while($libro = $result->fetch_assoc()): ?>
            <div class="libro">
                <h3><?php echo $libro['titulo']; ?></h3>
                <p>Autor: <?php echo $libro['autor']; ?></p>
                <p>Año: <?php echo $libro['anio']; ?></p>
                <p>Género: <?php echo $libro['genero']; ?></p>
                <form method="POST" action="administrador.php" style="display:inline-block;">
                    <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <button type="submit">Eliminar</button>
                </form>
                <form method="POST" action="administrador.php" style="display:inline-block;">
                    <input type="hidden" name="accion" value="editar">
                    <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" value="<?php echo $libro['titulo']; ?>" required>
                    <label for="autor">Autor:</label>
                    <input type="text" name="autor" value="<?php echo $libro['autor']; ?>" required>
                    <label for="anio">Año:</label>
                    <input type="number" name="anio" value="<?php echo $libro['anio']; ?>" required>
                    <label for="genero">Género:</label>
                    <input type="text" name="genero" value="<?php echo $libro['genero']; ?>" required>
                    <button type="submit">Guardar Cambios</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</main>
</body>
</html>
