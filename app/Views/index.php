<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<div class="p-1">
    <h1 class="text-center">Dobrý den</h1>
    <p class="text-center">Vítejte na mojí stránce o cyklistice</p>
</div>

<?php

$table = new \CodeIgniter\View\Table();

$template = [
    'table_open'         => '<table class="table table-bordered table-striped table-hover">',
    'thead_open'         => '<thead>',
    'thead_close'        => '</thead>',
    'heading_row_start'  => '<tr>',
    'heading_row_end'    => '</tr>',
    'heading_cell_start' => '<th>',
    'heading_cell_end'   => '</th>',
    'tbody_open'         => '<tbody>',
    'tbody_close'        => '</tbody>',
    'row_start'          => '<tr style="position: relative; cursor: pointer;">',
    'row_end'            => '</tr>',
    'cell_start'         => '<td>',
    'cell_end'           => '</td>',
    'row_alt_start'      => '<tr style="position: relative; cursor: pointer;">',
    'row_alt_end'        => '</tr>',
    'cell_alt_start'     => '<td>',
    'cell_alt_end'       => '</td>',
    'table_close'        => '</table>'
];

$table->setTemplate($template);

$table->setHeading('ID', 'Název závodu', 'Datum začátku', 'Datum ukončení', 'Délka (km)');

foreach ($data_nice as $row) {
    $table->addRow([
        $row->id,
        anchor('zavod/' . $row->id, $row->real_name, ['class' => 'stretched-link text-decoration-none']),
        $row->start_date,
        $row->end_date,
        round($row->total_distance) . ' km'
    ]);
}

echo $table->generate();
?>

<div class="text-center my-4">
    <img src="https://www.thetrainline.com/content/vul/hero-images/city/nice/1x.jpg"
        class="img-fluid rounded-3 shadow mb-3"
        style="max-width: 600px; height: auto;"
        alt="Nice">
</div>

<?= $this->endSection(); ?>