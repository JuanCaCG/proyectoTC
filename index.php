<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$search_query = '';
$search_results = [];

// Procesar búsqueda si se ha enviado una solicitud GET con el parámetro 'search'
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $stmt = $conn->prepare("SELECT * FROM libros WHERE titulo LIKE ? OR autor LIKE ?");
    $search_term = '%' . $search_query . '%';
    $stmt->bind_param('ss', $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }
    $stmt->close();
} else {
    // Mostrar todos los libros si el campo de búsqueda está en blanco
    $result = $conn->query("SELECT * FROM libros");
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_list'])) {
    $libro_id = $_POST['libro_id'];
    $usuario_id = $_SESSION['usuario_id'];
    // Agregar libro a la lista de lectura
    $stmt = $conn->prepare("INSERT INTO lista_lectura (usuario_id, libro_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $usuario_id, $libro_id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}
?>

<main>
    <h2>Libros Disponibles</h2>
    <form method="GET" action="index.php">
        <label for="search">Buscar libros:</label>
        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit">Buscar</button>
    </form>

    <div class="libros">
        <?php if (!empty($search_results)): ?>
            <?php foreach ($search_results as $libro): ?>
                <div class="libro">
                    <h3><?php echo htmlspecialchars($libro['titulo']); ?></h3>
                    <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
                    <p><strong>Año:</strong> <?php echo htmlspecialchars($libro['anio']); ?></p>
                    <p><strong>Género:</strong> <?php echo htmlspecialchars($libro['genero']); ?></p>
                    <?php if(isset($_SESSION['usuario_id'])): ?>
                        <form method="POST" action="index.php">
                            <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
                            <button type="submit" name="add_to_list">Agregar a Lista de Lectura</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se encontraron resultados para "<?php echo htmlspecialchars($search_query); ?>".</p>
        <?php endif; ?>
    </div>
</main>

<style>
.libros {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.libro {
    border: 1px solid #ddd;
    padding: 20px;
    width: 200px;
}
.libro h3 {
    margin: 0;
}
.libro p {
    margin: 5px 0;
}
.libro form {
    margin-top: 10px;
}
</style>

</body>
</html>
