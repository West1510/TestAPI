<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testapi extends Model
{
    use HasFactory;
    protected $casts = [
        'jsonData' => 'object',
    ];
}
