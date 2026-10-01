<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<div class="p-3">
    <div class="mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary btn-sm">&laquo; Zpět na detail závodu</a>
    </div>

    <h1>
        <?= ($typeResult == 1) ? 'Pořadí v etapě' : 'Pořadí po etapě' ?>
        (<?= !empty($stage->departure) ? $stage->departure . ' – ' . $stage->arrival : 'Etapa ' . ($stage->number ?? $stage->id) ?>)
    </h1>

    <?php if (!empty($results)): ?>
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

        $table->setHeading('Pozice', 'Jezdec', 'Čas / Odstup', 'Bonifikace');

        $position = 1;

        foreach ($results as $row) {
            $riderName = trim($row->first_name . ' ' . $row->last_name);

            if (!empty($row->photo)) {
                $photoUrl = base_url('img/riders/' . $row->photo);
                $riderOutput = '<div class="d-flex align-items-center gap-2">'
                    . '<img src="' . $photoUrl . '" alt="' . $riderName . '" style="width: 40px; height: 40px; object-fit: cover; object-position: top; border-radius: 50%; border: 1px solid #ccc;">'
                    . '<span>' . $riderName . '</span>'
                    . '</div>';
            } else {
                $riderOutput = $riderName;
            }

            $table->addRow([
                $position++ . '.', // Zobrazí 1., 2., 3... a zvýší hodnotu o +1
                $riderOutput,
                !empty($row->time) ? $row->time : '-',
                (!empty($row->bonification) && $row->bonification > 0) ? $row->bonification . ' s' : '-'
            ]);
        }

        echo $table->generate();
        ?>
    <?php else: ?>
        <div class="alert alert-warning mt-3">
            Pro tuto etapu a typ výsledku (<?= $typeResult ?>) nebyly nalezeny žádné záznamy.
        </div>
    <?php endif; ?>
</div>

<script>
    <?= $this->include('Layout/sortable_table.js') ?>
</script>

<?= $this->endSection(); ?>