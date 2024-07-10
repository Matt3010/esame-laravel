<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SommaImportiRichiesteFinanziamento extends FormRequest
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
        ];
    }

}
