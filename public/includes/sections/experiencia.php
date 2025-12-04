<section id="experience" class="py-5 text-white" style="background-color: #212529; color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center mb-5">Experiência</h2>
        <div class="timeline">
            <?php 
            $count = 0;
            foreach ($experiencias as $exp): 
                $count++;
                // Alterna entre left e right
                $tipo = ($count % 2 == 1) ? 'left' : 'right';
            ?>
            <div class="timeline-item <?php echo $tipo; ?>">
                <div class="timeline-content card bg-secondary text-white p-4 mb-4" style="background-color: #343a40 !important;">
                    <div class="card-header" style="color: #AAAAAA !important;"><?php echo $exp['ano']; ?></div>
                    <h4 class="card-title mt-2" style="color: #D7BDE2;"><?php echo $exp['cargo']; ?></h4>
                    <p class="card-subtitle mb-2" style="color: #A569BD !important;"><?php echo $exp['empresa']; ?></p>
                    <p class="card-text" style="color: #AAAAAA !important;"><?php echo $exp['descricao']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>