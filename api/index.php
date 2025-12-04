<?php
// Arquivo de entrada para a Vercel - Roteador principal
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Remove a barra inicial
$path = ltrim($path, '/');

// Se for acessando admin, redireciona para o arquivo correto
if (strpos($path, 'admin/') === 0) {
    $admin_path = substr($path, 6); // Remove 'admin/'
    if ($admin_path === '' || $admin_path === 'index.php') {
        require_once __DIR__ . '/../public/admin/index.php';
    } else {
        require_once __DIR__ . '/../public/admin/' . $admin_path;
    }
} else {
    // Página principal
    require_once __DIR__ . '/../public/index.php';
}
?>