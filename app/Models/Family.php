<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Family extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
       // 'name',
        'relative_name',
        'age',
        'name_vaccine',
        'application_date'
    ];
}