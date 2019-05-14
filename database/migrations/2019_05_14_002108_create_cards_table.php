<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('color', 100);
            $table->string('key', 100)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 100)->unique();
            $table->string('name', 100);
            $table->string('description', 100);
            $table->string('hint', 1000);
            $table->string('text', 1000);
            $table->integer('energy_cost');
            $table->integer('metal_cost');
            $table->integer('energy_upkeep');
            $table->integer('hp');
            $table->integer('damage');
            $table->integer('min-range');
            $table->integer('max-range');
            $table->integer('tier');
            $table->float('rarity');
            $table->foreign('faction')->references('id')->on('factions');
            $table->enum('type', [
                'military-unit',
                'military-structure',
                'tactical',
                'resource-energy',
                'resource-metal'
            ]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factions');
        Schema::dropIfExists('cards');
    }
}
