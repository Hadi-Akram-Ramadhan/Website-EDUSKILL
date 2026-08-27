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
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->integer('score')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
        });

        Schema::create('user_streaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('active_date');
            $table->timestamps();

            $table->unique(['user_id', 'active_date']);
        });

        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('badge_code');
            $table->string('badge_name');
            $table->string('badge_description')->nullable();
            $table->string('icon')->nullable();
            $table->timestamp('unlocked_at');
            $table->timestamps();

            $table->unique(['user_id', 'badge_code']);
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('cert_code')->unique();
            $table->string('cert_hash')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('recipient_name');
            $table->string('course_title');
            $table->string('mentor_name')->nullable();
            $table->decimal('score_average', 5, 2)->default(100.00);
            $table->date('issue_date');
            $table->string('qr_code_url')->nullable();
            $table->string('pdf_path')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('user_streaks');
        Schema::dropIfExists('user_progress');
    }
};
