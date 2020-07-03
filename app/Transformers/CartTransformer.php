<?php
namespace App\Transformers;
use App\Models\Banner;
use App\Models\CartItem;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['productSku'];

    public function transform(CartItem $cartItem)
    {
        return [
            'id' => $cartItem->id,
            'num' => $cartItem->num,
            'sku_id' => $cartItem->product_sku_id,
        ];
    }

    public function includeProductSku(CartItem $cartItem)
    {
        return $this->item($cartItem->productSku,new ProductSkuTransformer());
    }
}