<?php
// Inicia a session APENAS UMA VEZ no arquivo principal
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define o base path para links
define('BASE_PATH', __DIR__);

// 1. Arquivo de conexão e busca dos dados
require_once __DIR__ . '/conexao.php';

// 2. Cabeçalho
require_once __DIR__ . '/includes/header.php';

// 3. Inclui as seções
require_once __DIR__ . '/includes/sections/eu.php';
require_once __DIR__ . '/includes/sections/about.php';
require_once __DIR__ . '/includes/sections/skills.php';
require_once __DIR__ . '/includes/sections/portfolio.php';
require_once __DIR__ . '/includes/sections/experiencia.php';
require_once __DIR__ . '/includes/sections/contato.php';

// 4. Rodapé e fecha a conexão com o DB
require_once __DIR__ . '/includes/footer.php';
?>