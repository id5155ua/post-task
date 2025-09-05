<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->comment('Статті');
            $table->id()->comment('ID запису');

            $table->foreignId('category_id')
                ->comment('Зв\'язок із категорією')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->string('title', 191)
                ->comment('Заголовок статті, можна з емодзі')
                ->unique();

            $table->text('content')->comment('Зміст статті');

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
        Schema::dropIfExists('posts');
    }
};
