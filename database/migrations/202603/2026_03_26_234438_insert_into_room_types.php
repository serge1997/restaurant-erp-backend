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
        DB::table("room_types")->insert(array(
            [
                "name" => "Interior"
            ],
            [
                "name" => "Rooftop"
            ],
            [
                "name" => "Terraço"
            ],
            [
                "name" => "Ar livre"
            ],
            [
                "name" => "VIP"
            ],
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table("room_types")->delete();
    }
};
