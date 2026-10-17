<?php
// index.php — Read: daftar bengkel + pencarian
require "koneksi.php";

$cari = trim($_GET["q"] ?? "");

if ($cari !== "") {
    $stmt = $pdo->prepare(
        "SELECT * FROM bengkel
         WHERE nama_bengkel LIKE :q OR kota LIKE :q OR jenis_layanan LIKE :q
         ORDER BY id_bengkel DESC"
    );
    $stmt->execute([":q" => "%$cari%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM bengkel ORDER BY id_bengkel DESC");
}
$daftar = $stmt->fetchAll();

$judulHalaman = "Daftar Bengkel";
require "_header.php";
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h1 class="h3 mb-0">Daftar bengkel</h1>
    <a href="tambah.php" class="btn btn-primary">Tambah bengkel</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-8 col-md-6">
        <input type="search" name="q" class="form-control" value="<?= h($cari) ?>"
               placeholder="Cari nama, kota, atau layanan" aria-label="Cari bengkel">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-primary" type="submit">Cari</button>
        <?php if ($cari !== ""): ?>
            <a href="index.php" class="btn btn-link">Reset</a>
        <?php endif; ?>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama bengkel</th>
                    <th>Kota</th>
                    <th>Telepon</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$daftar): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <?= $cari !== "" ? "Tidak ada bengkel yang cocok dengan pencarian." : "Belum ada data bengkel. Klik Tambah bengkel untuk mulai." ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php foreach ($daftar as $i => $b): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <div class="fw-semibold"><?= h($b["nama_bengkel"]) ?></div>
                        <div class="small text-muted"><?= h($b["alamat"]) ?></div>
                    </td>
                    <td><?= h($b["kota"]) ?></td>
                    <td><?= h($b["nomor_telepon"]) ?></td>
                    <td><?= h($b["jenis_layanan"]) ?></td>
                    <td>
                        <span class="badge text-bg-<?= $b["status"] === "Aktif" ? "success" : "secondary" ?>">
                            <?= h($b["status"]) ?>
                        </span>
                    </td>
                    <td class="text-end text-nowrap">
                        <a href="edit.php?id=<?= (int) $b["id_bengkel"] ?>" class="btn btn-sm btn-outline-primary">Ubah</a>
                        <form action="hapus.php" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus bengkel <?= h(addslashes($b["nama_bengkel"])) ?>?');">
                            <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
                            <input type="hidden" name="id" value="<?= (int) $b["id_bengkel"] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<p class="text-muted small mt-2">Menampilkan <?= count($daftar) ?> bengkel.</p>

<?php require "_footer.php"; ?>
