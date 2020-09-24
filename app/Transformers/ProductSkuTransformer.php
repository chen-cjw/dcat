<?php
namespace App\Transformers;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductSku;
use League\Fractal\TransformerAbstract;

class ProductSkuTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['product'];
    public function transform(ProductSku $sku)
    {
        return [
            'id' => $sku->id,
            'title' => $sku->title,
            'description' => $sku->description,
            'price' => auth('api')->user()->is_vip==0 ? $sku->sell_price : $sku->buy_price, // todo 显示进货/平时售卖
            'stock' => $sku->stock,
            'commission'=> $sku->commission, // 佣金
            'created_at' => $sku->created_at->toDateTimeString(),
            'updated_at' => $sku->updated_at->toDateTimeString(),
        ];
    }

    public function includeProduct(ProductSku $sku)
    {
        return $this->item($sku->product, new ProductTransformer());
    }
}