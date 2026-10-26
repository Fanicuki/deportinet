<?php
session_start();
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../includes/catalogo_ui.php';

function deportinet_volver(string $message, string $type = 'error'): void
{
    $_SESSION['flash'] = $message;
    $_SESSION['flash_type'] = $type;
    header('Location: catalogo-jefe.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: catalogo-jefe.php');
    exit;
}

$nombre = trim((string) ($_POST['nombre'] ?? ''));
$descripcion = trim((string) ($_POST['descripcion'] ?? ''));
$precioRaw = $_POST['precio'] ?? '';
$stockRaw = $_POST['stock'] ?? '';
$idCategoria = (int) ($_POST['id_categoria'] ?? 0);
$img = trim((string) ($_POST['img'] ?? ''));

if (function_exists('mb_substr')) {
    $nombre = mb_substr($nombre, 0, 100, 'UTF-8');
    $descripcion = mb_substr($descripcion, 0, 2000, 'UTF-8');
} else {
    $nombre = substr($nombre, 0, 100);
    $descripcion = substr($descripcion, 0, 2000);
}
$img = substr($img, 0, 200);
if ($img !== '' && deportinet_safe_img($img) === '') {
    $img = '';
}

if ($nombre === '' || $descripcion === '' || !is_numeric($precioRaw) || !is_numeric($stockRaw) || $idCategoria <= 0) {
    deportinet_volver('Revisá los datos del producto.');
}

$precio = (float) $precioRaw;
$stock = (int) $stockRaw;
if ($precio < 0 || $stock < 0) {
    deportinet_volver('El precio y el stock tienen que ser válidos.');
}

$table = deportinet_resolve_table($conn, ['Productos', 'productos']);
if ($table === null) {
    deportinet_volver('No se encontró la tabla de productos.');
}

$sql = "INSERT INTO `$table` (nombre, descripcion, precio, stock, id_categoria, img) VALUES (?, ?, ?, ?, ?, ?)";
try {
    $stmt = $conn->prepare($sql);
} catch (Throwable $e) {
    $stmt = false;
}
if (!$stmt) {
    deportinet_volver('No se pudo publicar el producto.');
}

$stmt->bind_param('ssdiis', $nombre, $descripcion, $precio, $stock, $idCategoria, $img);
$ok = false;
try {
    $ok = $stmt->execute();
} catch (Throwable $e) {
    $ok = false;
}
$stmt->close();

if ($ok) {
    deportinet_volver('Producto publicado en el catálogo.', 'ok');
}

deportinet_volver('No se pudo publicar el producto.');
