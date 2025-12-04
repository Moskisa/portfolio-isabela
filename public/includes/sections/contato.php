<section id="contact" class="py-5 text-white" style="background-color: #212529; color: #f8f9fa;">
    <div class="container text-center">
        <h2 class="mb-4">Entre em Contato</h2>
        <?php if (isset($erro_db) && $erro_db): ?>
             <div class="alert alert-danger" role="alert">
                Aviso: Falha na conexão com o Banco de Dados. Exibindo dados de configuração padrões.
            </div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <p><i class="fas fa-envelope me-2"></i> <?php echo $email; ?></p>
                <p><i class="fas fa-phone me-2"></i> <?php echo $telefone; ?></p>
                <p><i class="fas fa-map-marker-alt me-2"></i> <?php echo $localizacao; ?></p>
                <div class="social-icons mt-4">
                    <a href="<?php echo $linkedin_url; ?>" target="_blank" class="text-white me-3" style="transition: color 0.3s ease;"><i class="fab fa-linkedin fa-3x"></i></a>
                    <a href="<?php echo $instagram_url; ?>" target="_blank" class="text-white me-3" style="transition: color 0.3s ease;"><i class="fab fa-instagram fa-3x"></i></a>
                    <a href="https://www.facebook.com/isabela.moscatelli/" target="_blank" class="text-white me-3" style="transition: color 0.3s ease;"><i class="fab fa-facebook fa-3x"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>