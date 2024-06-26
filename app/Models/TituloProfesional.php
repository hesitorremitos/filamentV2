<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TituloProfesional extends Model
{
    use HasFactory;
    protected $table = 'titulos_profesionales';
    protected $primaryKey = 'nro_documento';
    public $incrementing = false;

    //Relacion, un titulo profesional pertenece a una persona
    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    //Relacion, un titulo profesional pertenece a una carrera
    public function carrera(){
        return $this->belongsTo(Carrera::class);
    }

    //Relacion, un titulo profesional solo tiene una mencion
    public function mencion(){
        return $this->belongsTo(MencionTP::class);
    }


}
