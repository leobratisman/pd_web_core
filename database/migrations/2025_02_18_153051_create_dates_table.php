<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Utils\enums\DateType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->date('event_date');
            $table->text('description')->nullable();
            $table->enum('type_of_event', [
                DateType::BIRTHDAY->value,
                DateType::AWARD->value,
                DateType::DISCOVERY->value,
            ])->default(DateType::BIRTHDAY->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dates');
    }
};
