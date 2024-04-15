<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SuratPerintah;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPerintahUntuk2 extends Model
{
    use HasFactory;

    protected $table ='surat_perintah_untuk2s';

    protected $fillable = [
        'untuk',
        'lamaperjalanan',
        'biayaperjalanan'
    ];
    
    public function suratperintah(): BelongsTo
    {
        return $this->belongsTo(SuratPerintah::class, 'surat_perintah_id');
    }
}
