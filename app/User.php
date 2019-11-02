<?php

namespace App;

use App\Evento;
use App\Participacao;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function participacoes()
    {
        return $this->hasMany(Participacao::class, 'users_id');
    }


    public function participacaoEm(Evento $evento)
    {
        return $this->participacoes()->whereHas('evento', function ($consulta) use ($evento) {
            $consulta->where('idevento', $evento->chave());
        })->first();
    }
}
