<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public static $snakeAttributes = true;

    protected $table = "posts";
    protected $fillable = ['title', 'description', 'image_id'];
}
