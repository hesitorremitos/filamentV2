<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MencionTP extends Model
{
    use HasFactory;
    protected $table = 'menciones_tp';

    //Relacion, una mencion puede tener muchos titulos profesionales
    public function documentos(){
        return $this->hasMany(TituloProfesional::class);
    }
}
