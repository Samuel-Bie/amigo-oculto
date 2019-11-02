<?php

namespace App;

use App\User;
use App\Participacao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amigo extends Model
{
    use SoftDeletes;

    protected $table        = 'amigo';
    protected $primaryKey   = 'idamigo';


    public function chave(){
        return $this->idamigo;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function participacao()
    {
        return $this->belongsTo(Participacao::class, 'participacao_idparticipacao');
    }
}
