<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
    'name',
    'position_id',
    'phone',
    'email',
    'start_date'
    ];

    public function position() {
    return $this->belongsTo(\App\Models\Position::class);
    }
    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class);
    }


}
