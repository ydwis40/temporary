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
        Schema::dropIfExists('indication_problems');
        Schema::create('indication_problems', function (Blueprint $table) {
            $table->id();
            $table->string('indication_code');
            $table->string('problem_code');
            $table->timestamps();

            $table->foreign('indication_code')->references('code')->on('indications');
            $table->foreign('problem_code')->references('code')->on('problems');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indication_problems');
    }
};
