<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_number')->unique();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('student_id')->nullable()->index(); // Untuk NoAnggota (NPM)
            
            $table->foreignId('gender_id')->nullable()->constrained('genders');
            $table->foreignId('profession_id')->nullable()->constrained('professions');
            $table->foreignId('education_id')->nullable()->constrained('educations');
            $table->foreignId('visit_purpose_id')->nullable()->constrained('visit_purposes');
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->foreignId('status_id')->nullable()->constrained('statuses');

            $table->text('notes')->nullable(); // Untuk Deskripsi/Information
            $table->timestamp('visited_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
