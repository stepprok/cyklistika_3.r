<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<div class="p-1">
    <h1 class="text-center">Detail závodu</h1>
    <a href="<?= base_url(); ?>">Zpět na hlavní stránku</a>
    <p class="text-center">Informace o vybraném závodu <?= esc($data_nice->real_name) ?></p>

    <h2>Detail ročníku: <?= esc($data_nice->real_name) ?> (<?= esc($data_nice->year) ?>)</h2>

    <?php
    $table = new \CodeIgniter\View\Table();

    $template = array(
        'table_open'         => '<table class="table table-bordered table-striped" id="sortableTable">',
        'thead_open'         => '<thead>',
        'thead_close'        => '</thead>',
        'heading_row_start'  => '<tr>',
        'heading_row_end'    => '</tr>',
        'heading_cell_start' => '<th style="cursor: pointer;" class="sort-header">',
        'heading_cell_end'   => '</th>',
        'tbody_open'         => '<tbody>',
        'tbody_close'        => '</tbody>',
        'row_start'          => '<tr>',
        'row_end'            => '</tr>',
        'cell_start'         => '<td>',
        'cell_end'           => '</td>',
        'row_alt_start'      => '<tr>',
        'row_alt_end'        => '</tr>',
        'cell_alt_start'     => '<td>',
        'cell_alt_end'       => '</td>',
        'table_close'        => '</table>'
    );
    $table->setTemplate($template);

    $table->setHeading('ID', 'Etapa / Trasa', 'Datum', 'Délka (km)', 'Typ etapy', 'Vítěz');

    foreach ($stages as $stage) {
        $stageName = (!empty($stage->departure) && !empty($stage->arrival)) 
            ? $stage->departure . ' – ' . $stage->arrival 
            : 'Etapa ' . ($stage->number ?? $stage->id);

        $table->addRow([
            $stage->id,
            $stageName,
            date('d.m.Y', strtotime($stage->date)),
            round($stage->distance) . ' km',
            $stage->parcour_name ?? 'N/A',
            $stage->winner_name ?? 'N/A'
        ]);
    }

    echo $table->generate();
    ?>

</div>

<!-- Skript pro dynamické řazení tabulky po kliknutí na hlavičku -->
<script>
<?= $this->include('Layout/sortable_table.js') ?>
</script>

<?= $this->endSection(); ?>