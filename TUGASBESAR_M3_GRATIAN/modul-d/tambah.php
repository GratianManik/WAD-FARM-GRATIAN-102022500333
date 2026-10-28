<?php

require "koneksi.php";

$data = [
    "nama_bengkel" => "", "alamat" => "", "kota" => "", "nomor_telepon" => "",
    "email" => "", "jenis_layanan" => "", "status" => "Aktif",
];
$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!csrf_valid()) {
        http_response_code(403);
        die("Permintaan tidak valid. Muat ulang halaman lalu coba lagi.");
    }

    [$data, $error] = validasi_bengkel($_POST);

    if (!$error) {
        $stmt = $pdo->prepare(
            "INSERT INTO bengkel
             (nama_bengkel, alamat, kota, nomor_telepon, email, jenis_layanan, status)
             VALUES
             (:nama_bengkel, :alamat, :kota, :nomor_telepon, :email, :jenis_layanan, :status)"
        );
        $stmt->execute([
            ":nama_bengkel"  => $data["nama_bengkel"],
            ":alamat"        => $data["alamat"],
            ":kota"          => $data["kota"],
            ":nomor_telepon" => $data["nomor_telepon"],
            ":email"         => $data["email"] !== "" ? $data["email"] : null,
            ":jenis_layanan" => $data["jenis_layanan"],
            ":status"        => $data["status"],
        ]);

        set_flash("sukses", "Bengkel \"{$data["nama_bengkel"]}\" berhasil ditambahkan.");
        header("Location: index.php");   // Post/Redirect/Get: refresh tidak menyimpan dobel
        exit;
    }
}

$judulHalaman = "Tambah Bengkel";
$teksTombol = "Simpan bengkel";
require "_header.php";
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-4">Tambah bengkel</h1>
                <?php if ($error): ?>
                    <div class="alert alert-danger">Periksa kembali isian yang ditandai merah.</div>
                <?php endif; ?>
                <?php require "_form.php"; ?>
            </div>
        </div>
    </div>
</div>

<?php require "_footer.php"; ?>
