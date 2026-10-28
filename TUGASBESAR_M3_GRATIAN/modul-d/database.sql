
CREATE DATABASE IF NOT EXISTS `rental_mobil` 
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


USE `rental_mobil`;


CREATE TABLE IF NOT EXISTS `bengkel` (
    `id_bengkel` INT AUTO_INCREMENT PRIMARY KEY,
    `nama_bengkel` VARCHAR(100) NOT NULL,
    `alamat` TEXT NOT NULL,
    `kota` VARCHAR(100) NOT NULL,
    `nomor_telepon` VARCHAR(20) NOT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    `jenis_layanan` VARCHAR(100) NOT NULL,
    `status` ENUM('Aktif', 'Tidak Aktif') NOT NULL DEFAULT 'Aktif',
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;