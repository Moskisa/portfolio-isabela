<?php if (!empty($sobre)): ?>
<section id="about" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4"><?php echo $sobre[0]['titulo']; ?></h2>
        <p class="lead text-center"><?php echo $sobre[0]['descricao']; ?></p>
        <?php if (isset($sobre[1])): ?>
        <p class="text-secondary-custom text-center" style="color: #6c757d !important;">
            <?php echo $sobre[1]['descricao']; ?>
        </p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>