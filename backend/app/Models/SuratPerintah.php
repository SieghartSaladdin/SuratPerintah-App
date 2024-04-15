<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SuratPerintahDasar;
use App\Models\SuratPerintahKepada;
use App\Models\FormattSuratPerintah;
use App\Models\FormattSuratPerintah2;
use App\Models\SuratPerintahTujuan;
use App\Models\SuratPerintahDisampaikanKepada;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SuratPerintah extends Model
{
    use HasFactory;

    protected $table = 'surat_perintahs';

    protected $fillable = [
        'no_sp',
        'bidang',
        'dari',
        'tanggal'
    ];

    public function formattsuratperintah(): BelongsTo
    {
        return $this->belongsTo(FormattSuratPerintah::class, 'formatt_surat_perintahs_id');
    }

    public function formattsuratperintah2(): BelongsTo
    {
        return $this->belongsTo(FormattSuratPerintah2::class, 'formatt_surat_perintahs2_id');
    }

    public function dasar(): HasMany
    {
        return $this->hasMany(SuratPerintahDasar::class);
    }

    public function kepada(): HasMany
    {
        return $this->hasMany(SuratPerintahKepada::class);
    }

    public function tujuan(): HasMany
    {
        return $this->hasMany(SuratPerintahTujuan::class);
    }

    public function disampaikan(): HasMany
    {
        return $this->hasMany(SuratPerintahDisampaikanKepada::class);
    }

    public function untuk2(): HasOne
    {
        return $this->hasOne(SuratPerintahUntuk2::class, 'surat_perintah_id');
    }
}
