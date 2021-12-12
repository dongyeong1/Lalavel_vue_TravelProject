<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recomments', function (Blueprint $table) {

            $table->id();
            $table->foreignId('comment_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('house_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('writeUser')->nullable();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('reComment');
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
        Schema::dropIfExists('recomments');
    }
}
