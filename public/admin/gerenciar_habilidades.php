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
        $nome = mysqli_real_escape_string($link, $_POST['nome']);
        
        // Upload de imagem
        $imagem = '';
        if ($_FILES['imagem']['error'] == 0) {
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $imagem = 'habilidade_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['imagem']['tmp_name'], '../assets/images/' . $imagem);
        }
        
        // Determinar a próxima ordem
        $result = mysqli_query($link, "SELECT MAX(ordem) as max_ordem FROM habilidades");
        $row = mysqli_fetch_assoc($result);
        $nova_ordem = $row['max_ordem'] + 1;
        
        $sql = "INSERT INTO habilidades (nome, imagem, ordem) VALUES ('$nome', '$imagem', '$nova_ordem')";
        if (mysqli_query($link, $sql)) {
            $sucesso = "Habilidade adicionada com sucesso!";
        } else {
            $erro = "Erro ao adicionar habilidade: " . mysqli_error($link);
        }
    }
    
    if (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $nome = mysqli_real_escape_string($link, $_POST['nome']);
        
        $sql = "UPDATE habilidades SET nome = '$nome' WHERE id = $id";
        if (mysqli_query($link, $sql)) {
            $sucesso = "Habilidade atualizada com sucesso!";
        } else {
            $erro = "Erro ao atualizar habilidade: " . mysqli_error($link);
        }
    }
    
    if (isset($_POST['excluir'])) {
        $id = $_POST['id'];
        if (mysqli_query($link, "DELETE FROM habilidades WHERE id = $id")) {
            $sucesso = "Habilidade excluída com sucesso!";
        } else {
            $erro = "Erro ao excluir habilidade: " . mysqli_error($link);
        }
    }
}

$habilidades = buscarDados('habilidades');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Habilidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">← Voltar</a>
            <span class="navbar-brand">Gerenciar Habilidades</span>
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
                        <h5>Adicionar Habilidade</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label>Nome:</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Ícone/Imagem:</label>
                                <input type="file" name="imagem" class="form-control" accept="image/*" required>
                            </div>
                            <button type="submit" name="adicionar" class="btn btn-primary">Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Habilidades Existentes</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($habilidades as $habilidade): ?>
                        <div class="border p-3 mb-3">
                            <h6><?php echo $habilidade['nome']; ?></h6>
                            <img src="../assets/images/<?php echo $habilidade['imagem']; ?>" width="50" class="me-2">
                            
                            <!-- Botão para abrir modal de edição -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $habilidade['id']; ?>">
                                Editar
                            </button>
                            
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $habilidade['id']; ?>">
                                <button type="submit" name="excluir" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                            </form>

                            <!-- Modal de Edição -->
                            <div class="modal fade" id="editarModal<?php echo $habilidade['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Habilidade</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $habilidade['id']; ?>">
                                                <div class="mb-3">
                                                    <label>Nome:</label>
                                                    <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($habilidade['nome']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Imagem atual:</label><br>
                                                    <img src="../assets/images/<?php echo $habilidade['imagem']; ?>" width="50">
                                                    <p class="small text-muted">Para alterar a imagem, exclua e adicione novamente.</p>
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