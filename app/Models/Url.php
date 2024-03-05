<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'shortened_url',
        'expiration_date',
        'visits',
        'last_visit'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];




}
