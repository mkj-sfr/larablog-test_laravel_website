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
        Schema::create('comments_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reply_id')->constrained(table: 'comments', indexName: 'comments_relations_reply_id')->cascadeOnDelete();
            $table->bigInteger('parent_comment_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments_relations');
    }
};
