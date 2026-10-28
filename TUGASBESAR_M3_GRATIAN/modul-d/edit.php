<?php

require "koneksi.php";

$id = (int) ($_GET["id"] ?? $_POST["id"] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM bengkel WHERE id_bengkel = :id");
$stmt->execute([":id" => $id]);
$bengkel = $stmt->fetch();

if (!$bengkel) {
    set_flash("error", "Data bengkel tidak ditemukan.");
    header("Location: index.php");
    exit;
}

$data = [
    "nama_bengkel"  => $bengkel["nama_bengkel"],
    "alamat"        => $bengkel["alamat"],
    "kota"          => $bengkel["kota"],
    "nomor_telepon" => $bengkel["nomor_telepon"],
    "email"         => $bengkel["email"] ?? "",
    "jenis_layanan" => $bengkel["jenis_layanan"],
    "status"        => $bengkel["status"],
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
            "UPDATE bengkel SET
                nama_bengkel  = :nama_bengkel,
                alamat        = :alamat,
                kota          = :kota,
                nomor_telepon = :nomor_telepon,
                email         = :email,
                jenis_layanan = :jenis_layanan,
                status        = :status
             WHERE id_bengkel = :id"
        );
        $stmt->execute([
            ":nama_bengkel"  => $data["nama_bengkel"],
            ":alamat"        => $data["alamat"],
            ":kota"          => $data["kota"],
            ":nomor_telepon" => $data["nomor_telepon"],
            ":email"         => $data["email"] !== "" ? $data["email"] : null,
            ":jenis_layanan" => $data["jenis_layanan"],
            ":status"        => $data["status"],
            ":id"            => $id,
        ]);

        set_flash("sukses", "Data bengkel \"{$data["nama_bengkel"]}\" berhasil diperbarui.");
        header("Location: index.php");
        exit;
    }
}

$judulHalaman = "Ubah Bengkel";
$teksTombol = "Simpan perubahan";
require "_header.php";
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-4">Ubah bengkel</h1>
                <?php if ($error): ?>
                    <div class="alert alert-danger">Periksa kembali isian yang ditandai merah.</div>
                <?php endif; ?>
                <?php require "_form.php"; ?>
            </div>
        </div>
    </div>
</div>

<?php require "_footer.php"; ?>
