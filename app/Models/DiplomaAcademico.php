<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiplomaAcademico extends Model // Camb
{
    use HasFactory;
    protected $table = 'diplomas_academicos';
    protected $primaryKey = 'nro_documento';
    public $incrementing = false;


    
    public function setPathAttribute($value)
    {   
        $persona = Persona::find($this->attributes['persona_ci']);
        $file = $persona->ci."-".$persona->nombres
                .($persona->apellido_paterno ? $persona->apellido_paterno : "")." "
                .($persona->apellido_materno ? $persona->apellido_materno : "");

        $directory = "diplomas_academicos/"
                    .MencionDA::find($this->attributes['mencion_id'])
                    ->nombre."/";
        $this->attributes['path'] = $directory.$file;
    }
    
    //Relacion, una persona puede poseer muchos diplomas academicos
    public function persona(){
        return $this->belongsTo(Persona::class);
    }
    
    //Relacion, un diploma academico pertenece a una carrera
    public function carrera(){
        return $this->belongsTo(Carrera::class);
    }
    //Relacion, el diploma academico solo tiene una mencion
    public function mencion(){
        return $this->belongsTo(MencionDA::class);
    }
}
