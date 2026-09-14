<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<h1>Dobrý den</h1>

<?php foreach ($data_nice as $row){
    echo anchor($row->link, $row->default_name);
 }?>

<?= $this->endSection(); ?>