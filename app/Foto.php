<?php

namespace App;

use App\Presente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foto extends Model
{
    use SoftDeletes;

    protected $table        = 'fotos';
    protected $primaryKey   = 'idfotos';


    public function chave()
    {
        return $this->idfotos;
    }

    public function presente()
    {
        return $this->belongsTo(Presente::class, 'presentes_idpresentes');
    }
}
