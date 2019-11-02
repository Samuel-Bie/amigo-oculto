<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmigoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'amigo';

    /**
     * Run the migrations.
     * @table amigo
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idamigo');
            $table->unsignedInteger('participacao_idparticipacao');
            $table->unsignedBigInteger('users_id');

            $table->index(["participacao_idparticipacao"], 'fk_amigo_participacao2_idx');

            $table->index(["users_id"], 'fk_amigo_users1_idx');
            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('participacao_idparticipacao', 'fk_amigo_participacao2_idx')
                ->references('idparticipacao')->on('participacao')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('users_id', 'fk_amigo_users1_idx')
                ->references('id')->on('users')
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
