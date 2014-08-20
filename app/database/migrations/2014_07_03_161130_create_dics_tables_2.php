<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDicsTables2 extends Migration {

    public $table = "speciality_data";

	public function up(){

        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function(Blueprint $table) {
                #$table->increments('id');
                $table->integer('spec_id')->nullable()->unsigned();
                $table->integer('dicval_id')->nullable()->unsigned();
            });
            echo(' + ' . $this->table . PHP_EOL);
        } else {
            echo('...' . $this->table . PHP_EOL);
        }

    }


	public function down(){

        Schema::dropIfExists($this->table);
        echo(' - ' . $this->table . PHP_EOL);

	}

}