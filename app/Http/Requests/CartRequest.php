<?php

namespace App\Http\Requests;

use App\Models\ProductSku;

class CartRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'POST':
                return [
                    'sku_id' => [
                        'required',
                        function ($attribute, $value, $fail) {
                            if (!$sku = ProductSku::find($value)) {
                                return $fail('该商品不存在');
                            }
                            if (!$sku->product->on_sale) {
                                return $fail('该商品未上架');
                            }
                            if ($sku->stock === 0) {
                                return $fail('该商品已售完');
                            }
                            if ($this->input('amount') > 0 && $sku->stock < $this->input('amount')) {
                                return $fail('该商品库存不足');
                            }
                        },
                    ],
                    'num' => ['required', 'integer', 'min:1'],
                ];
            case 'PATCH':
                return [
                ];
            case 'DELETE':

            default:
                return [];
        }

    }

    public function attributes()
    {
        return [
            'amount' => '商品数量'
        ];
    }

    public function messages()
    {
        return [
            'sku_id.required' => '请选择商品'
        ];
    }
}
