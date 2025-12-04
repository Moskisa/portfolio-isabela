<section id="skills" class="py-5 text-white" style="background-color: #343a40; color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center mb-5">Minhas Habilidades</h2>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4 justify-content-center text-center">
            <?php foreach ($habilidades as $habilidade): ?>
            <div class="col">
                <div class="skill-item p-3 rounded" style="background-color: #212529; border: 1px solid #A569BD; transition: transform 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; align-items: center; min-height: 120px; aspect-ratio: 1/1; padding: 1rem;">
                    <img src="/assets/images/<?php echo $habilidade['imagem']; ?>" alt="<?php echo $habilidade['nome']; ?>" class="img-fluid mb-2" style="filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(285deg) brightness(118%) contrast(100%); width: 80px; height: 50px; object-fit: contain;">
                    <p><?php echo $habilidade['nome']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>