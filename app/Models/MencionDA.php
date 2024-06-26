<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MencionDA extends Model
{
    use HasFactory;
    protected $table = 'menciones_da';

    //Relacion, una mencion puede tener muchos diplomas academicos
    public function documentos(){
        return $this->hasMany(DiplomaAcademico::class);
    }
}
