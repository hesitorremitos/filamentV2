<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    protected $table = 'carreras';
    
    //Relacion, una carrera pertenece a una facultad
    public function facultad(){
        return $this->belongsTo(Facultad::class);
    }
    
}
