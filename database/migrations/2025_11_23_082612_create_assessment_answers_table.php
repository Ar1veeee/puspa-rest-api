<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_detail_id');
            $table->unsignedBigInteger('question_id');
            $table->enum('type', [
                'umum_parent',
                'fisio_parent',
                'okupasi_parent',
                'paedagog_parent',
                'wicara_parent',
                'fisio_assessor',
                'okupasi_assessor',
                'paedagog_assessor',
                'wicara_assessor'
            ]);
            $table->longText('answer_value')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('assessment_detail_id')->references('id')->on('assessment_details')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('assessment_questions')->onDelete('cascade');

            $table->unique(['assessment_detail_id', 'question_id']);
            $table->index('assessment_detail_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_answers');
    }
};
