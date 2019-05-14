<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEffectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('effects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 100)->index("effect_key");
            $table->enum('type', [
                'resource',
                'skill',
                'trigger',
                'action'
            ]);
            $table->string('params', 2000); // TODO: change this to be MM relationship
            $table->timestamps();
        });

        Schema::create('card_effect', function (Blueprint $table) {
            $table->integer('card_id')->unsigned();
            $table->integer('effect_id')->unsigned();
            $table->foreign('card_id')->references('id')->on('cards')
                ->onDelete('cascade');
            $table->foreign('effect_id')->references('id')->on('effects')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('effects');
        Schema::dropIfExists('card_effect');
    }
}
