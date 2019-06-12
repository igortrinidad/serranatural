<?php

namespace serranatural\Http\Requests;

use serranatural\Http\Requests\Request;

use serranatural\Models\Cliente;

class VotacaoClienteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $clienteEmail = Request::get('emailCliente');
        $cliente = Cliente::where('email', '=', $clienteEmail)->first();

        if(is_null($cliente)){

            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
          $rules = [
            'emailCliente' => 'required',
          ];

          foreach($this->request->get('opcaoEscolhida') as $key => $val)
          {
            $rules['opcaoEscolhida.'.$key] = 'required';
          }

          return $rules;
    }

    public function messages()
    {

        return [
            'opcaoEscolhida.required' => 'Por favor escolha alguma opção.',
            'emailCliente.required' => 'Por favor, informe seu e-mail.'
        ];

    }
}
