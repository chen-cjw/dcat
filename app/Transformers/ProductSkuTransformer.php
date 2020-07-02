<?php
namespace App\Transformers;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductSku;
use League\Fractal\TransformerAbstract;

class ProductSkuTransformer extends TransformerAbstract
{
    public function transform(ProductSku $sku)
    {
        return [
            'id' => $sku->id,
            'title' => $sku->title,
            'description' => $sku->description,
            'price' => $sku->price,
            'stock' => $sku->stock,
            'created_at' => $sku->created_at->toDateTimeString(),
            'updated_at' => $sku->updated_at->toDateTimeString(),
        ];
    }
}