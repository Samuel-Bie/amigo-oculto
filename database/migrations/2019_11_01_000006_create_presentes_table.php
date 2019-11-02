<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresentesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'presentes';

    /**
     * Run the migrations.
     * @table presentes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idpresentes');
            $table->string('nome', 45)->nullable();
            $table->string('detalhes', 45)->nullable();
            $table->unsignedInteger('participacao_idparticipacao');

            $table->index(["participacao_idparticipacao"], 'fk_presentes_participacao1_idx');
            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('participacao_idparticipacao', 'fk_presentes_participacao1_idx')
                ->references('idparticipacao')->on('participacao')
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
