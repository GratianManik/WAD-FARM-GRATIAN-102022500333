<?php

?>
<form method="POST" novalidate>
    <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
    <?php if (!empty($id)): ?>
        <input type="hidden" name="id" value="<?= (int) $id ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="nama_bengkel" class="form-label">Nama bengkel *</label>
        <input type="text" id="nama_bengkel" name="nama_bengkel" maxlength="100" required
               class="form-control <?= isset($error["nama_bengkel"]) ? "is-invalid" : "" ?>"
               value="<?= h($data["nama_bengkel"]) ?>">
        <div class="invalid-feedback"><?= h($error["nama_bengkel"] ?? "") ?></div>
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat *</label>
        <textarea id="alamat" name="alamat" rows="3" required
                  class="form-control <?= isset($error["alamat"]) ? "is-invalid" : "" ?>"><?= h($data["alamat"]) ?></textarea>
        <div class="invalid-feedback"><?= h($error["alamat"] ?? "") ?></div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="kota" class="form-label">Kota *</label>
            <input type="text" id="kota" name="kota" maxlength="100" required
                   class="form-control <?= isset($error["kota"]) ? "is-invalid" : "" ?>"
                   value="<?= h($data["kota"]) ?>">
            <div class="invalid-feedback"><?= h($error["kota"] ?? "") ?></div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="nomor_telepon" class="form-label">Nomor telepon *</label>
            <input type="tel" id="nomor_telepon" name="nomor_telepon" maxlength="20" required
                   pattern="[0-9+\-\s]{8,20}"
                   class="form-control <?= isset($error["nomor_telepon"]) ? "is-invalid" : "" ?>"
                   value="<?= h($data["nomor_telepon"]) ?>">
            <div class="invalid-feedback"><?= h($error["nomor_telepon"] ?? "") ?></div>
        </div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" maxlength="100"
               class="form-control <?= isset($error["email"]) ? "is-invalid" : "" ?>"
               value="<?= h($data["email"]) ?>">
        <div class="invalid-feedback"><?= h($error["email"] ?? "") ?></div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="jenis_layanan" class="form-label">Jenis layanan *</label>
            <select id="jenis_layanan" name="jenis_layanan" required
                    class="form-select <?= isset($error["jenis_layanan"]) ? "is-invalid" : "" ?>">
                <option value="">Pilih layanan</option>
                <?php foreach (DAFTAR_LAYANAN as $layanan): ?>
                    <option value="<?= h($layanan) ?>" <?= $data["jenis_layanan"] === $layanan ? "selected" : "" ?>>
                        <?= h($layanan) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"><?= h($error["jenis_layanan"] ?? "") ?></div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="status" class="form-label">Status bengkel</label>
            <select id="status" name="status" class="form-select">
                <?php foreach (DAFTAR_STATUS as $st): ?>
                    <option value="<?= h($st) ?>" <?= $data["status"] === $st ? "selected" : "" ?>><?= h($st) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary"><?= h($teksTombol) ?></button>
        <a href="index.php" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
