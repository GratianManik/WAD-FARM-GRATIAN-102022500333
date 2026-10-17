
<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "rental_mobil";

$pesan = "";
$jenisPesan = "";

try {

    $pdo = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );


    $pdo->exec(
        "CREATE DATABASE IF NOT EXISTS `$database`
         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
    );


    $pdo->exec("USE `$database`");


    $pdo->exec("
        CREATE TABLE IF NOT EXISTS bengkel (
            id_bengkel INT AUTO_INCREMENT PRIMARY KEY,
            nama_bengkel VARCHAR(100) NOT NULL,
            alamat TEXT NOT NULL,
            kota VARCHAR(100) NOT NULL,
            nomor_telepon VARCHAR(20) NOT NULL,
            email VARCHAR(100),
            jenis_layanan VARCHAR(100) NOT NULL,
            status ENUM('Aktif', 'Tidak Aktif') NOT NULL DEFAULT 'Aktif',
            dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nama_bengkel = trim($_POST["nama_bengkel"] ?? "");
        $alamat = trim($_POST["alamat"] ?? "");
        $kota = trim($_POST["kota"] ?? "");
        $nomor_telepon = trim($_POST["nomor_telepon"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $jenis_layanan = trim($_POST["jenis_layanan"] ?? "");
        $status = trim($_POST["status"] ?? "");


        if (
            $nama_bengkel === "" ||
            $alamat === "" ||
            $kota === "" ||
            $nomor_telepon === "" ||
            $jenis_layanan === "" ||
            !in_array($status, ["Aktif", "Tidak Aktif"], true)
        ) {
            $pesan = "Mohon isi semua kolom wajib dengan benar.";
            $jenisPesan = "error";
        } elseif (
            $email !== "" &&
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            $pesan = "Format email tidak valid.";
            $jenisPesan = "error";
        } else {

            $sql = "INSERT INTO bengkel
                    (nama_bengkel, alamat, kota, nomor_telepon,
                     email, jenis_layanan, status)
                    VALUES
                    (:nama_bengkel, :alamat, :kota, :nomor_telepon,
                     :email, :jenis_layanan, :status)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nama_bengkel" => $nama_bengkel,
                ":alamat" => $alamat,
                ":kota" => $kota,
                ":nomor_telepon" => $nomor_telepon,
                ":email" => $email !== "" ? $email : null,
                ":jenis_layanan" => $jenis_layanan,
                ":status" => $status
            ]);

            $pesan = "Data bengkel berhasil disimpan ke database!";
            $jenisPesan = "sukses";
        }
    }
} catch (PDOException $e) {

    $pesan = "Koneksi atau proses database gagal. Pastikan MySQL Laragon aktif. Detail: "
           . $e->getMessage();
    $jenisPesan = "error";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Data Bengkel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 700px;
            margin: 30px auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px #00000015;
        }

        h1 {
            color: #243b53;
        }

        .pesan {
            padding: 15px;
            border-radius: 6px;
            overflow-wrap: anywhere;
        }

        .sukses {
            background: #e3fcef;
            color: #17663a;
        }

        .error {
            background: #fde8e8;
            color: #9b1c1c;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            color: #1769aa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Bengkel Maintenance</h1>

        <?php if ($pesan !== ""): ?>
            <div class="pesan <?= htmlspecialchars($jenisPesan) ?>">
                <?= htmlspecialchars($pesan) ?>
            </div>
        <?php endif; ?>

        <a href="form-bengkel.html">Kembali ke Form Bengkel</a>
    </div>
</body>
</html>
