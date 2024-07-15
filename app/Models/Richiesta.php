<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Richiesta extends Model
{
    use HasFactory, HasTimestamps;

    protected $primaryKey = 'RichiestaID';
    protected $table = 'richieste';

    protected $fillable = [
        'RichiestaID',
        'CognomeNomeRichiedente',
        'DataInserimentoRichiesta',
        'Importo',
        'NumeroRate'
    ];

    protected $casts = [
        'DataInserimentoRichiesta' => 'date',
    ];
}
