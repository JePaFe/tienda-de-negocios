<?php

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
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable()->after('id');
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('set null');

            // $table->foreignId('categoria_id')
            //     ->nullable()
            //     ->after('id')
            //     ->constrained('categorias')
            //     ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');

            // $table->dropConstrainedForeignId('categoria_id');
        });
    }
};
