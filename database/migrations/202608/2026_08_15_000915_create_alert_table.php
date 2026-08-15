<?php

use App\Models\User;
use App\Modules\Alert\Enums\AlertSeverityEnum;
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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string("title", 60);
            $table->string("description", 165);
            $table->enum("severity", array_column(AlertSeverityEnum::cases(), 'value'));
            $table->boolean("is_resolved")->default(false);
            $table->dateTime("resolved_at")->nullable();
            $table->foreignIdFor(User::class,"resolved_by")->nullable()->constrained();
            $table->string("alertable_type");
            $table->integer("alertable_id");
            $table->integer('restaurant_id');
            $table->foreignIdFor(User::class,'alerted_by')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
