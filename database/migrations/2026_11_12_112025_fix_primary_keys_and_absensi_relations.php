
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan foreign key pada tabel absensis
        Schema::table('absensis', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')
                ->references('id')
                ->on('mahasiswas');

            $table->foreign('matakuliah_id')
                ->references('id')
                ->on('matakuliah');
        });
    }

    public function down(): void
    {
        // Hapus foreign key jika migration di-rollback
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropForeign(['matakuliah_id']);
        });
    }
};
