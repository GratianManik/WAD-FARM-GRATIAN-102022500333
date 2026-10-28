<?php

require "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !csrf_valid()) {
    http_response_code(405);
    die("Permintaan tidak valid.");
}

$id = (int) ($_POST["id"] ?? 0);

$stmt = $pdo->prepare("DELETE FROM bengkel WHERE id_bengkel = :id");
$stmt->execute([":id" => $id]);

if ($stmt->rowCount() > 0) {
    set_flash("sukses", "Data bengkel berhasil dihapus.");
} else {
    set_flash("error", "Data bengkel tidak ditemukan.");
}

header("Location: index.php");
exit;
