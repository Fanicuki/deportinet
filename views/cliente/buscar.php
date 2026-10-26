<?php
session_start();
$q = trim((string) ($_GET['q'] ?? ''));
$target = 'catalogo-cliente.php';
if ($q !== '') {
    $target .= '?q=' . urlencode($q);
}
header('Location: ' . $target);
exit;
