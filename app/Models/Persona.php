<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'personas';
    protected $primaryKey = 'ci';

    // desactivar autoincremento
    public $incrementing = false;
    //Relacion, una persona puede tener muchos titulos profesionales
    
    public function getFileName(){
        $file_name = $this->ci . '-' . $this->nombres . '-'
            .($this->apellido_paterno ? $this->apellido_paterno : '' ). ' '
            .($this->apellido_materno ? $this->apellido_materno : '');
        return $file_name;
    }
    public function titulosProfesionales(){
        return $this->hasMany(TituloProfesional::class);
    }

    //Relacion, una persona puede tener muchos diplomas academicos

    public function diplomasAcademicos(){
        return $this->hasMany(DiplomaAcademico::class);
    }

    public function casts():array
    {
        return [
            'fecha_nacimiento' => 'datetime',
        ];
    }
}
