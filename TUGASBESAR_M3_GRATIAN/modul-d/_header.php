<?php

$judulHalaman = $judulHalaman ?? "Data Bengkel";
$flash = ambil_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($judulHalaman) ?> | Rental Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Rental Mobil · Bengkel Maintenance</a>
    </div>
</nav>
<main class="container pb-5">
<?php if ($flash): ?>
    <div class="alert alert-<?= $flash["tipe"] === "sukses" ? "success" : "danger" ?> alert-dismissible fade show" role="alert">
        <?= h($flash["pesan"]) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>
