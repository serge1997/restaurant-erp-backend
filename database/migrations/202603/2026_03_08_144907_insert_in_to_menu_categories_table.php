<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table("menu_categories")->insert([
            [
                'name' => 'Refrigerentes',
                'created_at' => now()
            ],
            [
                'name' => 'Cervejas',
                'created_at' => now()
            ],
        ]);
    }

    public function down(): void
    {
        DB::table("menu_categories")->whereIn('name', ['Refrigerentes', 'Cervejas'])->delete();
    }
};
