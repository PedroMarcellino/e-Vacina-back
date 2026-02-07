<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Equipament extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'due_date',
        'purchase_date'
    ];
}
