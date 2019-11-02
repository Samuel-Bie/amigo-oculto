<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'fotos';

    /**
     * Run the migrations.
     * @table fotos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idfotos');
            $table->text('path')->nullable();
            $table->text('url')->nullable();
            $table->unsignedInteger('presentes_idpresentes');

            $table->index(["presentes_idpresentes"], 'fk_fotos_presentes1_idx');
            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('presentes_idpresentes', 'fk_fotos_presentes1_idx')
                ->references('idpresentes')->on('presentes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
