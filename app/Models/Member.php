<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public static $snakeAttributes = true;

    protected $table = 'members';
    protected $guarded = false;

    public $timestamps = false;
}
