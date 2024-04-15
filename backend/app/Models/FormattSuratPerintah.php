<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\SuratPerintah;

class FormattSuratPerintah extends Model
{
    use HasFactory;

    protected $table = 'formatt_surat_perintahs';

    protected $fillable = [
        'gambar',
        'judul',
        'nama_lembaga',
        'website',
        'alamat',
        'kota_pos',
        'ditetapkan_di',
        'atas_nama',
        'an_nama',
        'an_jabatan',
        'an_nip',
    ];

    public function suratperintah(): HasMany
    {
        return $this->hasMany(SuratPerintah::class, 'formatt_surat_perintahs_id');
    }
}
