<?php

namespace Database\Seeders;

use App\Models\Bengkel;
use Illuminate\Database\Seeder;

class BengkelSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Bengkel Maju Jaya',   'Jl. Asia Afrika No. 10',   'Bandung', '022-1234567',  'majujaya@example.com', 'Service Mesin', 'Aktif'],
            ['Oli Center Sejahtera','Jl. Dago No. 45',          'Bandung', '081234567890', null,                   'Ganti Oli',     'Aktif'],
            ['Rem Pro Garage',      'Jl. Soekarno Hatta No. 88','Bandung', '022-7654321',  'rempro@example.com',   'Service Rem',   'Aktif'],
            ['Dingin AC Mobil',     'Jl. Cihampelas No. 21',    'Bandung', '082198765432', null,                   'Service AC',    'Tidak Aktif'],
            ['Ban Mandiri',         'Jl. Buah Batu No. 5',      'Bandung', '085611223344', 'banmandiri@example.com','Ganti Ban',    'Aktif'],
        ];

        foreach ($data as [$nama, $alamat, $kota, $telp, $email, $layanan, $status]) {
            Bengkel::create([
                'nama_bengkel'  => $nama,
                'alamat'        => $alamat,
                'kota'          => $kota,
                'nomor_telepon' => $telp,
                'email'         => $email,
                'jenis_layanan' => $layanan,
                'status'        => $status,
            ]);
        }
    }
}
