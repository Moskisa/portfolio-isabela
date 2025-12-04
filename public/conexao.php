<?php
// Configurações do Banco de Dados - Adaptado para PDO/PostgreSQL (Supabase)
// Usaremos variáveis de ambiente simples para o Vercel

// As variáveis de ambiente esperadas são: DB_HOST, DB_USER, DB_PASS, DB_NAME

// 1. Definir as constantes de conexão
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'portfolio_isabela');

// 2. Conexão PDO
$pdo = null;
$erro_db = false;

try {
    // A porta padrão do PostgreSQL é 5432. Se o Supabase usar outra, você pode adicionar DB_PORT nas VAs.
    $dsn = "pgsql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";user=" . DB_USER . ";password=" . DB_PASS;
    
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'"); // Define o charset
    
} catch (PDOException $e) {
    $erro_db = true;
    error_log("Erro de conexão com o banco (PDO): " . $e->getMessage());
    // Em produção, você pode querer exibir uma mensagem de erro mais amigável
}

// 3. Função para buscar dados do banco (Adaptada para PDO)
function buscarDados($tabela, $ordenacao = "") {
    global $pdo;
    
    if (!$pdo) {
        return [];
    }
    
    // PostgreSQL usa aspas duplas para nomes de tabelas/colunas com letras maiúsculas ou caracteres especiais.
    // Como os nomes das tabelas são minúsculos, não deve haver problema, mas vamos manter a segurança.
    $sql = "SELECT * FROM " . $tabela;
    
    // Ordenação específica para cada tabela
    switch($tabela) {
        case 'sobre':
            $sql .= " ORDER BY ordem ASC, id ASC";
            break;
        case 'habilidades':
            $sql .= " ORDER BY ordem ASC, id ASC";
            break;
        case 'portfolio':
            $sql .= " ORDER BY data_criacao DESC, id DESC";
            break;
        case 'experiencias':
            $sql .= " ORDER BY ordem ASC, id ASC";
            break;
        default:
            $sql .= " ORDER BY id ASC";
    }
    
    if ($ordenacao) {
        $sql .= " " . $ordenacao;
    }
    
    try {
        $stmt = $pdo->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
    } catch (PDOException $e) {
        error_log("Erro ao buscar dados na tabela $tabela: " . $e->getMessage());
        return [];
    }
}

// 4. Buscar configurações (Adaptada para PDO)
$config_data = [];
if (!$erro_db) {
    $sql = "SELECT chave, valor FROM configuracoes";
    try {
        $stmt = $pdo->query($sql);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $config_data[$row['chave']] = $row['valor'];
        }
    } catch (PDOException $e) {
        error_log("Erro ao buscar configurações: " . $e->getMessage());
    }
}

// 5. Dados padrão
$dados_padrao = [
    'email' => 'isabelamoscatelli@outlook.com',
    'telefone' => '(11) 98349-6498',
    'localizacao' => 'São Sebastião, SP, Brasil',
    'linkedin_url' => 'https://www.linkedin.com/in/isabela-moscatelli-nogueira/',
    'instagram_url' => 'https://www.instagram.com/isabelamoscatelli/'
];

$config_data = array_merge($dados_padrao, $config_data);

// 6. Buscar outras seções
$sobre = buscarDados('sobre');
$habilidades = buscarDados('habilidades');
$portfolio = buscarDados('portfolio');
$experiencias = buscarDados('experiencias');

// 7. Variáveis individuais para facilitar o uso
$email = $config_data['email'];
$telefone = $config_data['telefone'];
$localizacao = $config_data['localizacao'];
$linkedin_url = $config_data['linkedin_url'];
$instagram_url = $config_data['instagram_url'];
?>
