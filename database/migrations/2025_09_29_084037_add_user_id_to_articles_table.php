<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('articles', 'date_public')) {
                $table->date('date_public')->nullable();
            }
        });
    }

    public function down(): void
{
    Schema::table('articles', function (Blueprint $table) {
        // Всегда проверяем существование колонок перед удалением
        if (Schema::hasColumn('articles', 'user_id')) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['user_id']);
            }
            $table->dropColumn('user_id');
        }
        
        if (Schema::hasColumn('articles', 'date_public')) {
            $table->dropColumn('date_public');
        }
    });
}
};