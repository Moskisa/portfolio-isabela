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
        $titulo = mysqli_real_escape_string($link, $_POST['titulo']);
        $descricao = mysqli_real_escape_string($link, $_POST['descricao']);
        $link_projeto = mysqli_real_escape_string($link, $_POST['link']);
        
        // Upload de imagem
        $imagem = '';
        if ($_FILES['imagem']['error'] == 0) {
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $imagem = 'projeto_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['imagem']['tmp_name'], '../uploads/' . $imagem);
        }
        
        $sql = "INSERT INTO portfolio (titulo, descricao, imagem, link) VALUES ('$titulo', '$descricao', '$imagem', '$link_projeto')";
        if (mysqli_query($link, $sql)) {
            $sucesso = "Projeto adicionado com sucesso!";
        } else {
            $erro = "Erro ao adicionar projeto: " . mysqli_error($link);
        }
    }
    
    if (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $titulo = mysqli_real_escape_string($link, $_POST['titulo']);
        $descricao = mysqli_real_escape_string($link, $_POST['descricao']);
        $link_projeto = mysqli_real_escape_string($link, $_POST['link']);
        
        $sql = "UPDATE portfolio SET titulo = '$titulo', descricao = '$descricao', link = '$link_projeto' WHERE id = $id";
        if (mysqli_query($link, $sql)) {
            $sucesso = "Projeto atualizado com sucesso!";
        } else {
            $erro = "Erro ao atualizar projeto: " . mysqli_error($link);
        }
    }
    
    if (isset($_POST['excluir'])) {
        $id = $_POST['id'];
        if (mysqli_query($link, "DELETE FROM portfolio WHERE id = $id")) {
            $sucesso = "Projeto excluído com sucesso!";
        } else {
            $erro = "Erro ao excluir projeto: " . mysqli_error($link);
        }
    }
}

$projetos = buscarDados('portfolio');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Portfólio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">← Voltar</a>
            <span class="navbar-brand">Gerenciar Portfólio</span>
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
                        <h5>Adicionar Projeto</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label>Título:</label>
                                <input type="text" name="titulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Descrição:</label>
                                <textarea name="descricao" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Link:</label>
                                <input type="url" name="link" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Imagem:</label>
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
                        <h5>Projetos Existentes</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($projetos as $projeto): ?>
                        <div class="border p-3 mb-3">
                            <h6><?php echo $projeto['titulo']; ?></h6>
                            <p class="small"><?php echo substr($projeto['descricao'], 0, 100); ?>...</p>
                            
                            <!-- Botão para abrir modal de edição -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $projeto['id']; ?>">
                                Editar
                            </button>
                            
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $projeto['id']; ?>">
                                <button type="submit" name="excluir" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                            </form>

                            <!-- Modal de Edição -->
                            <div class="modal fade" id="editarModal<?php echo $projeto['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Projeto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $projeto['id']; ?>">
                                                <div class="mb-3">
                                                    <label>Título:</label>
                                                    <input type="text" name="titulo" class="form-control" value="<?php echo htmlspecialchars($projeto['titulo']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Descrição:</label>
                                                    <textarea name="descricao" class="form-control" rows="3" required><?php echo htmlspecialchars($projeto['descricao']); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Link:</label>
                                                    <input type="url" name="link" class="form-control" value="<?php echo htmlspecialchars($projeto['link']); ?>" required>
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