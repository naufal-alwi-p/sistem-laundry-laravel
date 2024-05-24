<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pesanan';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function ulasan(): HasOne {
        return $this->hasOne(Ulasan::class);
    }

    public function jenisCucian(): BelongsTo {
        return $this->belongsTo(JenisCucian::class);
    }
}
