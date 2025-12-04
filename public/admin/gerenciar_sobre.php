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
        $id = $_POST['id'];
        $titulo = mysqli_real_escape_string($link, $_POST['titulo']);
        $descricao = mysqli_real_escape_string($link, $_POST['descricao']);
        
        $sql = "UPDATE sobre SET titulo = '$titulo', descricao = '$descricao' WHERE id = $id";
        if (mysqli_query($link, $sql)) {
            $sucesso = "Texto atualizado com sucesso!";
        } else {
            $erro = "Erro ao atualizar: " . mysqli_error($link);
        }
    }
}

$sobre = buscarDados('sobre');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Sobre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">← Voltar</a>
            <span class="navbar-brand">Gerenciar Sobre</span>
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
            <?php foreach ($sobre as $item): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Editar: <?php echo $item['titulo']; ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <div class="mb-3">
                                <label>Título:</label>
                                <input type="text" name="titulo" class="form-control" value="<?php echo htmlspecialchars($item['titulo']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Descrição:</label>
                                <textarea name="descricao" class="form-control" rows="5" required><?php echo htmlspecialchars($item['descricao']); ?></textarea>
                            </div>
                            <button type="submit" name="editar" class="btn btn-primary">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>