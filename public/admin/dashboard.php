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

// Estatísticas
$total_projetos = mysqli_num_rows(mysqli_query($link, "SELECT id FROM portfolio"));
$total_habilidades = mysqli_num_rows(mysqli_query($link, "SELECT id FROM habilidades"));
$total_experiencias = mysqli_num_rows(mysqli_query($link, "SELECT id FROM experiencias"));
$total_config = mysqli_num_rows(mysqli_query($link, "SELECT id FROM configuracoes"));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Painel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #A569BD;
            --primary-dark: #905C9F;
            --secondary-bg: #343a40;
            --dark-bg: #212529;
            --text-color-light: #f8f9fa;
        }
        
        .bg-portfolio-primary {
            background-color: var(--primary-color) !important;
        }
        
        .bg-portfolio-dark {
            background-color: var(--dark-bg) !important;
        }
        
        .bg-portfolio-secondary {
            background-color: var(--secondary-bg) !important;
        }
        
        .btn-portfolio-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .btn-portfolio-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .nav-admin {
            background-color: var(--dark-bg) !important;
            border-bottom: 3px solid var(--primary-color);
        }
        
        .card-stat {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        
        .card-stat:hover {
            transform: translateY(-5px);
        }
        
        .quick-action-btn {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .quick-action-btn:hover {
            background-color: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">
    <nav class="navbar navbar-dark nav-admin">
        <div class="container">
            <span class="navbar-brand">
                <i class="fas fa-cog me-2"></i>Painel Administrativo
            </span>
            <div>
                <a href="../index.php" target="_blank" class="btn btn-outline-info w-100">
    <i class="fas fa-eye"></i> Ver Site
</a>
                <a href="index.php?logout=1" class="btn btn-portfolio-primary btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i>Sair
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" style="color: var(--primary-color);">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </h2>
            <span class="text-muted">Bem-vindo ao painel de controle</span>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="card card-stat text-white bg-portfolio-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-briefcase me-2"></i>Projetos</h5>
                                <h2 class="mb-0"><?php echo $total_projetos; ?></h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                        <a href="gerenciar_portfolio.php" class="text-white text-decoration-none small mt-2 d-block">
                            <i class="fas fa-arrow-right me-1"></i>Gerenciar Projetos
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card card-stat text-white bg-portfolio-secondary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-code me-2"></i>Habilidades</h5>
                                <h2 class="mb-0"><?php echo $total_habilidades; ?></h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-code"></i>
                            </div>
                        </div>
                        <a href="gerenciar_habilidades.php" class="text-white text-decoration-none small mt-2 d-block">
                            <i class="fas fa-arrow-right me-1"></i>Gerenciar Habilidades
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card card-stat text-white bg-portfolio-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-history me-2"></i>Experiências</h5>
                                <h2 class="mb-0"><?php echo $total_experiencias; ?></h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                        <a href="gerenciar_experiencias.php" class="text-white text-decoration-none small mt-2 d-block">
                            <i class="fas fa-arrow-right me-1"></i>Gerenciar Experiências
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card card-stat text-white" style="background: linear-gradient(135deg, #A569BD, #905C9F);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><i class="fas fa-cog me-2"></i>Configurações</h5>
                                <h2 class="mb-0"><?php echo $total_config; ?></h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-cogs"></i>
                            </div>
                        </div>
                        <a href="gerenciar_config.php" class="text-white text-decoration-none small mt-2 d-block">
                            <i class="fas fa-arrow-right me-1"></i>Gerenciar Configurações
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0" style="color: var(--primary-color);">
                            <i class="fas fa-bolt me-2"></i>Ações Rápidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="gerenciar_portfolio.php?acao=adicionar" class="btn quick-action-btn w-100 py-3 d-flex flex-column align-items-center">
                                    <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                    <span>Novo Projeto</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="gerenciar_sobre.php" class="btn quick-action-btn w-100 py-3 d-flex flex-column align-items-center">
                                    <i class="fas fa-edit fa-2x mb-2"></i>
                                    <span>Editar Sobre</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="gerenciar_habilidades.php" class="btn quick-action-btn w-100 py-3 d-flex flex-column align-items-center">
                                    <i class="fas fa-code fa-2x mb-2"></i>
                                    <span>Nova Habilidade</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="gerenciar_experiencias.php" class="btn quick-action-btn w-100 py-3 d-flex flex-column align-items-center">
                                    <i class="fas fa-briefcase fa-2x mb-2"></i>
                                    <span>Nova Experiência</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h6 class="mb-0" style="color: var(--primary-color);">
                            <i class="fas fa-info-circle me-2"></i>Informações do Sistema
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="p-3 rounded" style="background-color: #f8f9fa;">
                                    <i class="fas fa-database fa-2x mb-2" style="color: var(--primary-color);"></i>
                                    <h6 class="mb-1">PHP</h6>
                                    <small class="text-muted"><?php echo phpversion(); ?></small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="p-3 rounded" style="background-color: #f8f9fa;">
                                    <i class="fas fa-server fa-2x mb-2" style="color: var(--primary-color);"></i>
                                    <h6 class="mb-1">MySQL</h6>
                                    <small class="text-muted">Conectado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h6 class="mb-0" style="color: var(--primary-color);">
                            <i class="fas fa-clock me-2"></i>Atividade Recente
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <div>
                                    <i class="fas fa-briefcase me-2" style="color: var(--primary-color);"></i>
                                    <span>Projetos no portfólio</span>
                                </div>
                                <span class="badge bg-portfolio-primary rounded-pill"><?php echo $total_projetos; ?></span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <div>
                                    <i class="fas fa-code me-2" style="color: var(--primary-color);"></i>
                                    <span>Habilidades cadastradas</span>
                                </div>
                                <span class="badge bg-portfolio-secondary rounded-pill"><?php echo $total_habilidades; ?></span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <div>
                                    <i class="fas fa-history me-2" style="color: var(--primary-color);"></i>
                                    <span>Experiências profissionais</span>
                                </div>
                                <span class="badge bg-portfolio-dark rounded-pill"><?php echo $total_experiencias; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-3 text-center" style="background-color: var(--dark-bg); color: var(--text-color-light);">
        <div class="container">
            <p class="mb-0">&copy; 2025 Painel Administrativo - Portfolio Isabela</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>