<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container my-4" style="max-width: 600px;">
    <div class="mb-3">
        <a href="<?= base_url(); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Zpět na přehled
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Přidat nový ročník závodu</h2>
        </div>
        <div class="card-body">

            <form action="<?= base_url('race-year/store'); ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="real_name" class="form-label font-weight-bold">Název ročníku:</label>
                     <p>Pro uložení musí název obsahovat Paris - Nice</p>
                    <input type="text" class="form-control" id="real_name" name="real_name" 
                           value="<?= old('real_name') ?>" placeholder="Např. Paris - Nice 2024" required>
                </div>

                <div class="mb-3">
                    <label for="id_race" class="form-label font-weight-bold">Závod (race_id):</label>
                    <select class="form-select" id="id_race" name="id_race" required>
                        <option value="" disabled selected>-- Vyberte závod (Muži, Kat. E) --</option>
                        <?php foreach ($races as $race): ?>
                            <option value="<?= $race->id ?>" <?= old('id_race') == $race->id ? 'selected' : '' ?>>
                                <?= $race->real_name . ' (' . $race->id . ')'?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Zobrazeny jsou pouze mužské závody kategorie E.</div>
                </div>

                <div class="mb-3">
                    <label for="year" class="form-label font-weight-bold">Rok ročníku:</label>
                    <input type="number" class="form-control" id="year" name="year" 
                           value="<?= old('year', date('Y')) ?>" min="1900" max="2099" required>
                </div>

                <div class="mb-4">
                    <label for="logo" class="form-label font-weight-bold">Logo závodu:</label>
                    <input class="form-control" type="file" id="logo" name="logo" accept="image/*" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-plus me-1"></i> Uložit ročník
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>