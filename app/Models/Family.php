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
        'status',
        'name_vaccine',
        'application_date',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // belongsTo quer dizer que a propriedade pertence a outro modal tipo Igual nessa função
    // fiz um belongsTo pra associar ao modal de users 

    // Esse User::class é o modal
}