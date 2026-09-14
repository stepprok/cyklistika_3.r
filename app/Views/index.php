<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<div class="p-1">
    <h1 class="text-center">Dobrý den</h1>
    <p class="text-center">Vítejte na mojí stránce o cyklistice</p>
</div>

<?= $table_html; ?>

<!-- Responzivní a stylovaný obrázek -->
<div class="text-center my-4">
    <img src="https://www.thetrainline.com/content/vul/hero-images/city/nice/1x.jpg" 
         class="img-fluid rounded-3 shadow mb-3" 
         style="max-width: 600px; height: auto;" 
         alt="Nice">
</div>

<?= $this->endSection(); ?>