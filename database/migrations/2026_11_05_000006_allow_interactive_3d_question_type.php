<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        // PostgreSQL enum columns are CHECK constraints; ->change() to varchar leaves the old CHECK behind.
        DB::statement('ALTER TABLE exercises DROP CONSTRAINT IF EXISTS exercises_question_type_check');
        DB::statement("ALTER TABLE exercises ADD CONSTRAINT exercises_question_type_check CHECK (question_type IN ('multiple_choice', 'fill_blank', 'code_ordering', 'output_prediction', 'matching_pair', 'interactive_3d'))");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        if (DB::table('exercises')->where('question_type', 'interactive_3d')->exists()) {
            throw new RuntimeException('Cannot remove interactive_3d constraint while 3D exercises exist.');
        }

        DB::statement('ALTER TABLE exercises DROP CONSTRAINT exercises_question_type_check');
        DB::statement("ALTER TABLE exercises ADD CONSTRAINT exercises_question_type_check CHECK (question_type IN ('multiple_choice', 'fill_blank', 'code_ordering', 'output_prediction', 'matching_pair'))");
    }
};
