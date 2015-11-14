<?php

namespace serranatural\Http\Requests;

use serranatural\Http\Requests\Request;

class PagamentoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pagamento' => 'mimes:jpeg,bmp,png,pdf,',
            'notaFiscal' => 'mimes:jpeg,bmp,png,pdf,'
        ];
    }

    public function messages()
    {

        return [
            'pagamento.mimes' => 'O arquivo deve ser imagem (.png, .jpg, .pdf).',
            'notaFiscal.mimes' => 'O arquivo deve ser imagem(.png, .jpg), .pdf.',

        ];
    }
}