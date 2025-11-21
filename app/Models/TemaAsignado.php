<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemaAsignado extends Model
{
    use HasFactory;

    protected $table = 'temasAsignados';

    public $timestamps = false;

    protected $fillable = [
        'fk_user',
        'fk_tema',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'fk_user');
    }

    public function tema()
    {
        return $this->belongsTo(Tema::class, 'fk_tema');
    }
}
