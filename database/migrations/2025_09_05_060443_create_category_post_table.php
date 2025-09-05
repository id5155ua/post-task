<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_post', function (Blueprint $table) {
            $table->comment('Pivot: Категорія та статті');
            $table->id()->comment('ID запису');

            $table->foreignId('category_id')
                ->comment('Зв\'язок з категорією')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('post_id')
                ->comment('Зв\'язок зі статтею')
                ->constrained('posts')
                ->cascadeOnDelete();

            $table->unique(['category_id', 'post_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_post');
    }
};
