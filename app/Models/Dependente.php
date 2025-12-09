<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dependente extends Model
{
    use HasFactory;

    protected $table = 'dependentes';

    protected $fillable = [
        'funcionario_id',
        'nome',
        'data_nascimento',
        'tipo',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function getIdadeAttribute(): int
    {
        return $this->data_nascimento->age;
    }
}
