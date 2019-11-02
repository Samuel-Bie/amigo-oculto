<?php

namespace App;

use App\Foto;
use App\User;
use App\Participacao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presente extends Model
{

    use SoftDeletes;

    protected $table        = 'presentes';
    protected $primaryKey   = 'idpresentes';


    public function chave()
    {
        return $this->idpresentes;
    }

    public function participacao()
    {
        return $this->belongsTo(Participacao::class, 'participacao_idparticipacao');
    }


    public function fotos()
    {
        return $this->hasMany(Foto::class, 'presentes_idpresentes');
    }

    public function user(){
        return $this->participacao->user();
    }

    public function isFrom(User $user){
        return $this->participacao->user->is($user);
    }
    //
}
