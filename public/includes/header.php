<!DOCTYPE html>
<html lang="pt-br" style="font-family: 'Montserrat', sans-serif; background-color: #f8f9fa; color: #212529;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfólio - Isabela Moscatelli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #212529 !important; opacity: 0.5; padding-top: 0.01px !important; padding-bottom: 0.01px !important; box-shadow: none; transition: none;">
        <div class="container">
            <a class="navbar-brand" href="/">
  <img src="/assets/images/logo_isabela.png" alt="Logo Isabela" width="60" height="60" class="d-inline-block align-text-top" style="width: 50px !important; height: 50px !important; border-radius: 0;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#about">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#skills">Habilidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfólio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#experience">Experiência</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contato</a>
                    </li>
                    <?php if(isset($_SESSION['admin_logado']) && $_SESSION['admin_logado']): ?>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="/admin/">Admin</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>
    <main>