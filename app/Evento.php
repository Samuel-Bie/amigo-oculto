<?php

namespace App;

use App\Participacao;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use SoftDeletes;

    protected $table        = 'evento';
    protected $primaryKey   = 'idevento';


    public function chave()
    {
        return $this->idevento;
    }

    public function nrParticipantes()
    {
        return $this->participacoes()->count();
    }


    public function participacoes()
    {
        return $this->hasMany(Participacao::class, 'evento_idevento');
    }

    public function isFuture()
    {
        return (new Carbon($this->data_realizacao))->isFuture();
    }

    public static function futuros()
    {
        return static::whereDate('data_realizacao', '>=', now())->get();
    }

    public function isSubscribed(User $user)
    {
        return $this->participacoes()->whereHas('user', function ($consulta) use ($user) {
            $consulta->where('id', $user->id);
        })->exists();
    }

    public function isDrawn()
    {
        return $this->drawn;
    }
}
