<?php
// Inicia session apenas se não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Credenciais simples (em produção, use hash)
$usuario_admin = 'admin';
$senha_admin = '123456';

if ($_POST) {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if ($usuario === $usuario_admin && $senha === $senha_admin) {
        $_SESSION['admin_logado'] = true;
        header('Location: /admin/dashboard.php');
        exit;
    } else {
        $erro = 'Usuário ou senha incorretos!';
    }
}

if (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado']) {
    header('Location: /admin/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #A569BD;
            --primary-dark: #905C9F;
            --secondary-bg: #343a40;
            --dark-bg: #212529;
        }
        
        .admin-login {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--dark-bg), var(--secondary-bg));
            border-radius: 15px 15px 0 0 !important;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(165, 105, 189, 0.4);
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(165, 105, 189, 0.25);
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-logo i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="admin-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-logo">
                    <i class="fas fa-user-shield"></i>
                    <h3 class="text-white">Painel Administrativo</h3>
                    <p class="text-white-50">Portfolio Isabela Moscatelli</p>
                </div>
                
                <div class="card login-card">
                    <div class="card-header login-header text-white text-center py-4">
                        <h4 class="mb-0"><i class="fas fa-lock me-2"></i>Acesso Restrito</h4>
                    </div>
                    <div class="card-body p-5">
                        <?php if (isset($erro)): ?>
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $erro; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Usuário:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-user" style="color: var(--primary-color);"></i>
                                    </span>
                                    <input type="text" name="usuario" class="form-control" placeholder="Digite seu usuário" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Senha:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-key" style="color: var(--primary-color);"></i>
                                    </span>
                                    <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-login text-white w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Entrar no Painel
                            </button>
                        </form>
                        
                        <div class="text-center mt-4 p-3 rounded" style="background-color: #f8f9fa;">
                            <p class="small text-muted mb-2">Credenciais de acesso:</p>
                            <p class="small mb-1">
                                <i class="fas fa-user me-1" style="color: var(--primary-color);"></i>
                                <strong>Usuário:</strong> admin
                            </p>
                            <p class="small mb-0">
                                <i class="fas fa-key me-1" style="color: var(--primary-color);"></i>
                                <strong>Senha:</strong> 123456
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>