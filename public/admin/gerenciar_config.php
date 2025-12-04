<?php
// Inicia session apenas se não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../conexao.php';

if (!isset($_SESSION['admin_logado']) || !$_SESSION['admin_logado']) {
    header('Location: index.php');
    exit;
}

// Processar formulário
if ($_POST) {
    if (isset($_POST['editar'])) {
        $chave = $_POST['chave'];
        $valor = mysqli_real_escape_string($link, $_POST['valor']);
        
        $sql = "UPDATE configuracoes SET valor = '$valor' WHERE chave = '$chave'";
        if (mysqli_query($link, $sql)) {
            $sucesso = "Configuração atualizada com sucesso!";
        } else {
            $erro = "Erro ao atualizar: " . mysqli_error($link);
        }
    }
}

// Buscar configurações
$configuracoes = [];
$sql = "SELECT * FROM configuracoes ORDER BY chave";
$result = mysqli_query($link, $sql);
if($result && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $configuracoes[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Configurações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">← Voltar</a>
            <span class="navbar-brand">Gerenciar Configurações</span>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (isset($sucesso)): ?>
            <div class="alert alert-success"><?php echo $sucesso; ?></div>
        <?php endif; ?>
        
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Configurações de Contato</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($configuracoes as $config): ?>
                        <form method="POST" class="mb-3 border-bottom pb-3">
                            <input type="hidden" name="chave" value="<?php echo $config['chave']; ?>">
                            <div class="mb-3">
                                <label class="form-label"><strong><?php echo ucfirst(str_replace('_', ' ', $config['chave'])); ?>:</strong></label>
                                <input type="text" name="valor" class="form-control" value="<?php echo htmlspecialchars($config['valor']); ?>" required>
                            </div>
                            <button type="submit" name="editar" class="btn btn-primary btn-sm">Atualizar</button>
                        </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>