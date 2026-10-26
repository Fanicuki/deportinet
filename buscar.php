<?php
$q = trim((string) ($_GET['q'] ?? ''));
$target = 'catalogo.php';
if ($q !== '') {
    $target .= '?q=' . urlencode($q);
}
header('Location: ' . $target);
exit;
