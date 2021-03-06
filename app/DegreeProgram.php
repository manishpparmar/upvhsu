<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DegreeProgram extends Model
{
    protected $table = 'degree_programs';

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'degree_program_id');
    }
}
