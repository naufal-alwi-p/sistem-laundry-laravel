<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisCucian extends Model
{
    use HasFactory;

    protected $table = 'jenis_cucian';

    public $timestamps = false;

    public function allPesanan(): HasMany {
        return $this->hasMany(Pesanan::class);
    }
}
