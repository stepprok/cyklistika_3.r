<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<div class="p-1">
    <h1 class="text-center">Detail závodu</h1>
    <p class="text-center">Informace o vybraném závodu <?= $data_nice->real_name ?></p>

    <h3>Závod: <?= $data_nice->id ?></h3>
</div>

<?= $this->endSection(); ?>