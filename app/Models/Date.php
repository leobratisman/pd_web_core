<?php

namespace App\Models;

use App\Utils\enums\DateType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    protected $table = 'dates';
    protected $guarded = false;

    public $timestamps = false;

    protected $casts = [
        "type_of_event" => DateType::class
    ];
}
