<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'mnvu',
        'name_nv',
        'start_nv',
        'end_nv',
        'finish_nv',
        'status_nv',
        'user_id',
        'creat_id',
    ];
}
