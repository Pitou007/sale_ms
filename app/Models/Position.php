<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
    'name',
    'base_salary'
    ];
    
    public function employees() {
        return $this->hasMany(\App\Models\Employee::class);
    }
}
