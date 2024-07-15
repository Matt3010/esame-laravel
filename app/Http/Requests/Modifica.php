<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Modifica extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'CognomeNomeRichiedente' => 'required|string',
            'DataInserimentoRichiesta' => 'required|date',
            'Importo' => 'required',
            'NumeroRate' => 'required|integer|in:6,12,18,24,48,60',
           // 'richiestaID' => 'required|integer'
        ];
    }
}
