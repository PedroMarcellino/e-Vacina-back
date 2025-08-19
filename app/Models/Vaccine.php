<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Vaccine extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        
        'name',
        'age_range',
        'status',
        'application_date'
        
    ];
}