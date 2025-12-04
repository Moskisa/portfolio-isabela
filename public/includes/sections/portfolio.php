<section id="portfolio" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Portfólio</h2>
        <div class="row justify-content-center">
            <?php foreach ($portfolio as $projeto): ?>
            <div class="col-lg-8 col-md-10 mb-4">
                <div class="card h-100 shadow-lg text-center border-0" style="border: 0; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <img src="/assets/images/<?php echo $projeto['imagem']; ?>" class="card-img-top pt-4 px-4" alt="<?php echo $projeto['titulo']; ?>" style="max-width: 300px; margin: 0 auto; object-fit: contain;">
                    <div class="card-body p-5">
                        <h3 class="card-title mb-3" style="color: #A569BD !important;"><?php echo $projeto['titulo']; ?></h3>
                        <p class="card-text lead"><?php echo $projeto['descricao']; ?></p>
                        <a href="<?php echo $projeto['link']; ?>" target="_blank" class="btn btn-primary btn-lg mt-3" style="background-color: #A569BD; border-color: #A569BD;">Ver Site</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>