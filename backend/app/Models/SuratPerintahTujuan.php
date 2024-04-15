<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SuratPerintah;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPerintahTujuan extends Model
{
    use HasFactory;

    protected $table = 'surat_perintah_tujuans';

    protected $fillable = [
        'untuk'
    ];

    public function suratperintah(): BelongsTo
    {
        return $this->belongsTo(SuratPerintah::class);
    }
}
