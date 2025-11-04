<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemaAsignado extends Model
{
    use HasFactory;

    protected $table = 'temas_asignados';

    protected $fillable = [
        'user_id',
        'tema_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tema()
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }
}
