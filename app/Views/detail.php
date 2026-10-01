<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<div class="p-1">
    <h1 class="text-center">Detail závodu</h1>
    <a href="<?= base_url(); ?>">Zpět na hlavní stránku</a>
    <p class="text-center">Informace o vybraném závodu <?= $data_nice->real_name ?></p>

    <h2>Detail ročníku: <?= $data_nice->real_name ?> (<?= $data_nice->year ?>)</h2>

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

    $table->setHeading('ID', 'Etapa / Trasa', 'Datum', 'Délka (km)', 'Typ etapy', 'Vítěz', 'Pořadí v etapě', 'Pořadí po etapě');

    foreach ($stages as $stage) {
        $stageName = (!empty($stage->departure) && !empty($stage->arrival))
            ? $stage->departure . ' – ' . $stage->arrival
            : 'Etapa ' . ($stage->number ?? $stage->id);

        if (!empty($stage->winner_last)) {
            $winnerName = trim($stage->winner_first . ' ' . $stage->winner_last);
            if (!empty($stage->winner_photo)) {
                $photoUrl = base_url('img/riders/' . $stage->winner_photo);
                $winnerOutput = '<div class="d-flex align-items-center gap-2">'
                    . '<img src="' . $photoUrl . '" alt="' . $winnerName . '" style="width: 40px; height: 40px; object-fit: cover; object-position: top; border-radius: 50%; border: 1px solid #ccc;">'
                    . '<span>' . $winnerName . '</span>'
                    . '</div>';
            } else {
                $winnerOutput = $winnerName;
            }
        } else {
            $winnerOutput = 'N/A';
        }

        $linkStageResult = '<a href="' . base_url('result/stage/' . $stage->id . '/1') . '" class="btn btn-sm btn-outline-primary">'
            . 'Pořadí v etapě'
            . '</a>';

        $linkAfterStageResult = '<a href="' . base_url('result/stage/' . $stage->id . '/4') . '" class="btn btn-sm btn-outline-info">'
            . 'Pořadí po etapě'
            . '</a>';

        $table->addRow([
            $stage->id,
            $stageName,
            date('d.m.Y', strtotime($stage->date)),
            round($stage->distance) . ' km',
            $stage->parcour_name ?? 'N/A',
            $winnerOutput,
            $linkStageResult,
            $linkAfterStageResult
        ]);
    }

    echo $table->generate();
    ?>

</div>

<script>
    <?= $this->include('Layout/sortable_table.js') ?>
</script>

<?= $this->endSection(); ?>