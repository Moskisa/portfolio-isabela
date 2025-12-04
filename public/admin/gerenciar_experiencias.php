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
    if (isset($_POST['adicionar'])) {
        $ano = mysqli_real_escape_string($link, $_POST['ano']);
        $cargo = mysqli_real_escape_string($link, $_POST['cargo']);
        $empresa = mysqli_real_escape_string($link, $_POST['empresa']);
        $descricao = mysqli_real_escape_string($link, $_POST['descricao']);
        
        // Determinar a próxima ordem
        $result = mysqli_query($link, "SELECT MAX(ordem) as max_ordem FROM experiencias");
        $row = mysqli_fetch_assoc($result);
        $nova_ordem = $row['max_ordem'] + 1;
        
        $sql = "INSERT INTO experiencias (ano, cargo, empresa, descricao, ordem) 
                VALUES ('$ano', '$cargo', '$empresa', '$descricao', '$nova_ordem')";
        if (mysqli_query($link, $sql)) {
            $sucesso = "Experiência adicionada com sucesso!";
        } else {
            $erro = "Erro ao adicionar experiência: " . mysqli_error($link);
        }
    }
    
    if (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $ano = mysqli_real_escape_string($link, $_POST['ano']);
        $cargo = mysqli_real_escape_string($link, $_POST['cargo']);
        $empresa = mysqli_real_escape_string($link, $_POST['empresa']);
        $descricao = mysqli_real_escape_string($link, $_POST['descricao']);
        
        $sql = "UPDATE experiencias SET ano = '$ano', cargo = '$cargo', empresa = '$empresa', descricao = '$descricao' WHERE id = $id";
        if (mysqli_query($link, $sql)) {
            $sucesso = "Experiência atualizada com sucesso!";
        } else {
            $erro = "Erro ao atualizar experiência: " . mysqli_error($link);
        }
    }
    
    if (isset($_POST['excluir'])) {
        $id = $_POST['id'];
        if (mysqli_query($link, "DELETE FROM experiencias WHERE id = $id")) {
            $sucesso = "Experiência excluída com sucesso!";
        } else {
            $erro = "Erro ao excluir experiência: " . mysqli_error($link);
        }
    }
}

$experiencias = buscarDados('experiencias');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Experiências</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">← Voltar</a>
            <span class="navbar-brand">Gerenciar Experiências</span>
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Adicionar Experiência</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label>Ano:</label>
                                <input type="text" name="ano" class="form-control" placeholder="Ex: 2025 - Presente" required>
                            </div>
                            <div class="mb-3">
                                <label>Cargo:</label>
                                <input type="text" name="cargo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Empresa:</label>
                                <input type="text" name="empresa" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Descrição:</label>
                                <textarea name="descricao" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" name="adicionar" class="btn btn-primary">Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Experiências Existentes</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($experiencias as $exp): ?>
                        <div class="border p-3 mb-3">
                            <h6><?php echo $exp['cargo']; ?></h6>
                            <p class="small mb-1"><strong>Empresa:</strong> <?php echo $exp['empresa']; ?></p>
                            <p class="small mb-1"><strong>Ano:</strong> <?php echo $exp['ano']; ?></p>
                            <p class="small"><?php echo substr($exp['descricao'], 0, 100); ?>...</p>
                            
                            <!-- Botão para abrir modal de edição -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $exp['id']; ?>">
                                Editar
                            </button>
                            
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $exp['id']; ?>">
                                <button type="submit" name="excluir" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                            </form>

                            <!-- Modal de Edição -->
                            <div class="modal fade" id="editarModal<?php echo $exp['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Experiência</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $exp['id']; ?>">
                                                <div class="mb-3">
                                                    <label>Ano:</label>
                                                    <input type="text" name="ano" class="form-control" value="<?php echo htmlspecialchars($exp['ano']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Cargo:</label>
                                                    <input type="text" name="cargo" class="form-control" value="<?php echo htmlspecialchars($exp['cargo']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Empresa:</label>
                                                    <input type="text" name="empresa" class="form-control" value="<?php echo htmlspecialchars($exp['empresa']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Descrição:</label>
                                                    <textarea name="descricao" class="form-control" rows="3" required><?php echo htmlspecialchars($exp['descricao']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" name="editar" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>