<?php

namespace App;

use App\User;
use App\Amigo;
use App\Evento;
use App\Presente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participacao extends Model
{
    use SoftDeletes;

    protected $table        = 'participacao';
    protected $primaryKey   = 'idparticipacao';


    public function chave(){
        return $this->idparticipacao;
    }


    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_idevento');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function amigo()
    {
        return $this->hasOne(Amigo::class, 'participacao_idparticipacao');
    }


    public function presentes()
    {
        return $this->hasMany(Presente::class, 'participacao_idparticipacao');
    }
}
