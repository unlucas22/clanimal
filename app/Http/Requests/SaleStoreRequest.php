<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleStoreRequest extends FormRequest
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
            'client_id' => 'required',
            'radio' => 'required',
            'total' => 'required',
            'igv' => 'required',
            'productos_guardados' => 'required',
        ];
    }

    /**
      * Get custom messages for validator errors.
      *
      * @return array
      */
     public function messages()
     {
        return [
            'client_id.required' => __('El DNI del cliente es obligatorio'),
            'radio.required' => __('El metodo de pago es obligatorio'),
            'productos_guardados.required' => __('Tiene que agregar productos en la compra'),
        ];
    }
}
