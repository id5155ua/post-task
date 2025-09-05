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
        Schema::create('comments', function (Blueprint $table) {
            $table->comment('Коментарі');
            $table->id()->comment('ID запису');

            $table->foreignId('post_id')
                ->comment('Зв\'язок зі статтею')
                ->constrained('posts')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->comment('Зв\'язок з користувачем')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('content')->comment('Текст коментаря');
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
        Schema::dropIfExists('comments');
    }
};
