<?php
namespace App\Transformers;
use App\Models\Banner;
use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['skus'];

    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'title' => $product->title,
            'description' => $product->description,
            'image' => $product->image_url,
            'on_sale' => $product->on_sale,
            'rating' => $product->rating,
            'sold_count' => $product->sold_count,
            'review_count' => $product->review_count,
            'price' => $product->price, // 最低价格
            'favor' => auth('api')->user()?boolval(auth('api')->user()->favoriteProducts()->find($product->id)): false, // 是否收藏
            'created_at' => $product->created_at->toDateTimeString(),
            'updated_at' => $product->updated_at->toDateTimeString(),
        ];
    }
    public function includeSkus(Product $product)
    {
        return $this->collection($product->skus,new ProductSkuTransformer());
    }
}