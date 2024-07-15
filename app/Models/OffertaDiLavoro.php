<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffertaDiLavoro extends Model
{
    use HasFactory;

    protected $primaryKey = 'offertaLavoroID';
    protected $table = 'TOfferteLavoro';

    protected $fillable = [
        'offertaLavoroID',
        'titolo',
        'descrizioneBreve',
        'dataInserimento',
        'retribuzioneLorda'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'retribuzioneLorda' => 'float',
        'dataInserimento' => 'date'
    ];

}
