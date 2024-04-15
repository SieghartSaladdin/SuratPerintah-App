<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SuratPerintah;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPerintahDasar extends Model
{
    use HasFactory;

    protected $table = 'surat_perintah_dasars';

    protected $fillable = [
        'kegiatan'
    ];

    public function suratperintah(): BelongsTo
    {
        return $this->belongsTo(SuratPerintah::class);
    }
}
