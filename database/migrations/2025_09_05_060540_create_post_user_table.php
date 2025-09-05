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
        Schema::create('post_user', function (Blueprint $table) {
            $table->comment('Pivot: стаття і користувач');

            $table->foreignId('post_id')
                ->comment('Зв\'язок зі статтею')
                ->constrained('posts')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->comment('Зв\'язок з користувачем')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_user');
    }
};
