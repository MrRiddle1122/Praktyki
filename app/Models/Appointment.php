<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointment';
    protected $primaryKey = 'ID';
    protected $fillable = ['inp_nam_sur','inp_dep'];
}
