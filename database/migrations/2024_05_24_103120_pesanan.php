<?php

use App\Models\JenisCucian;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(JenisCucian::class);
            $table->integer('jumlah');
            $table->enum('status', ['Sedang Dijemput', 'Sudah Sampai Toko', 'Sedang Diproses', 'Sudah Di-packing', 'Sedang Dikirim ke Rumah', 'Selesai', 'Batal']);
            $table->boolean('dijemput');
            $table->boolean('diantar');
            $table->foreignIdFor(User::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
