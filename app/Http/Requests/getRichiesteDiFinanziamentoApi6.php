<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class getRichiesteDiFinanziamentoApi6 extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'DataMin' => 'required|date',
            'DataMax' => 'required|date',
            'maxRichieste' => 'integer|min:1',
        ];
    }

}
