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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('assignments_id',10);
            $table->string('is_completed')->default(0);
            $table->string('subject');
            $table->string('service');
            $table->string('university');
            $table->string('referencingStyle');
            $table->string('educationLevel');
            $table->datetime('deadline'); // Adjust type if necessary
            $table->integer('pages'); // Assuming pages is an integer
            $table->text('specificInstruction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
