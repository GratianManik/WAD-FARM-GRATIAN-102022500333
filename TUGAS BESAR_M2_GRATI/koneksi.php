<?php

session_start();

$host     = "localhost";
$username = "root";
$password = "";
$database = "rental_mobil";


const DEBUG = true;

try {
    $pdo = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database`
                CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$database`");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS bengkel (
            id_bengkel    INT AUTO_INCREMENT PRIMARY KEY,
            nama_bengkel  VARCHAR(100) NOT NULL,
            alamat        TEXT NOT NULL,
            kota          VARCHAR(100) NOT NULL,
            nomor_telepon VARCHAR(20)  NOT NULL,
            email         VARCHAR(100) NULL,
            jenis_layanan VARCHAR(100) NOT NULL,
            status        ENUM('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
            dibuat_pada   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    $detail = DEBUG ? " Detail: " . htmlspecialchars($e->getMessage()) : "";
    die("Koneksi database gagal. Pastikan MySQL di Laragon sudah aktif." . $detail);
}

const DAFTAR_LAYANAN = ["Service Mesin", "Ganti Oli", "Service Rem", "Service AC", "Ganti Ban"];
const DAFTAR_STATUS  = ["Aktif", "Tidak Aktif"];


function h($teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, "UTF-8");
}


function set_flash(string $tipe, string $pesan): void
{
    $_SESSION["flash"] = ["tipe" => $tipe, "pesan" => $pesan];
}

function ambil_flash(): ?array
{
    $flash = $_SESSION["flash"] ?? null;
    unset($_SESSION["flash"]);
    return $flash;
}


function csrf_token(): string
{
    if (empty($_SESSION["csrf"])) {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
    }
    return $_SESSION["csrf"];
}

function csrf_valid(): bool
{
    return isset($_POST["csrf"], $_SESSION["csrf"])
        && hash_equals($_SESSION["csrf"], $_POST["csrf"]);
}


function validasi_bengkel(array $in): array
{
    $data = [
        "nama_bengkel"  => trim($in["nama_bengkel"] ?? ""),
        "alamat"        => trim($in["alamat"] ?? ""),
        "kota"          => trim($in["kota"] ?? ""),
        "nomor_telepon" => trim($in["nomor_telepon"] ?? ""),
        "email"         => trim($in["email"] ?? ""),
        "jenis_layanan" => trim($in["jenis_layanan"] ?? ""),
        "status"        => trim($in["status"] ?? "Aktif"),
    ];
    $error = [];

    if ($data["nama_bengkel"] === "" || mb_strlen($data["nama_bengkel"]) > 100) {
        $error["nama_bengkel"] = "Nama bengkel wajib diisi (maksimal 100 karakter).";
    }
    if ($data["alamat"] === "") {
        $error["alamat"] = "Alamat wajib diisi.";
    }
    if ($data["kota"] === "" || mb_strlen($data["kota"]) > 100) {
        $error["kota"] = "Kota wajib diisi (maksimal 100 karakter).";
    }
    if (!preg_match('/^[0-9+\-\s]{8,20}$/', $data["nomor_telepon"])) {
        $error["nomor_telepon"] = "Nomor telepon harus 8-20 karakter: angka, +, - atau spasi.";
    }
    if ($data["email"] !== "" && !filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Format email tidak valid.";
    }
    if (!in_array($data["jenis_layanan"], DAFTAR_LAYANAN, true)) {
        $error["jenis_layanan"] = "Pilih jenis layanan dari daftar.";
    }
    if (!in_array($data["status"], DAFTAR_STATUS, true)) {
        $error["status"] = "Status tidak valid.";
    }

    return [$data, $error];
}
