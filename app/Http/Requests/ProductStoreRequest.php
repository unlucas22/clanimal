<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'supplier_id' => 'required',
            'product_details' => 'required',
            'fecha' => 'required',
            'key_type' => 'required',
            'value_type' => 'required',
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
            'supplier_id.required' => __('Es necesario elegir el proveedor'),
            'product_details.required' => __('Es necesario guardar como minimo un producto en la compra'),
            'fecha.required' => __('Se tiene que especificar la fecha de recepción'),
            //'key_type.required' => __('Se tiene que especificar la factura de la compra'),
            'value_type.required' => __('Se tiene que especificar el valor de la factura, boleta o nota de la compra realizada'),
            'total.required' => __('Se tiene que especificar el total de la compra'),
        ];
    }
}
