<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\SuratPerintah;

class FormattSuratPerintah2 extends Model
{
    use HasFactory;

    protected $table = 'formatt_surat_perintahs2';

    protected $fillable = [
        'gambar',
        'judul',
        'nama_lembaga',
        'alamat',
        'kota_pos',
        'pelaksanaan_tugas',
        'dikeluarkan_di',
        'an_nama',
        'an_pangkat',
        'an_nip',
        'atas_nama'
    ];

    public function suratperintah(): HasMany
    {
        return $this->hasMany(SuratPerintah::class, 'formatt_surat_perintahs2_id');
    }
}
