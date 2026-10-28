<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model
{
    protected $table = 'bengkels';
    protected $primaryKey = 'id_bengkel';

    public const DAFTAR_LAYANAN = [
        'Service Mesin', 'Ganti Oli', 'Service Rem', 'Service AC', 'Ganti Ban',
    ];

    public const DAFTAR_STATUS = ['Aktif', 'Tidak Aktif'];

    protected $fillable = [
        'nama_bengkel',
        'alamat',
        'kota',
        'nomor_telepon',
        'email',
        'jenis_layanan',
        'status',
    ];
}
