<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Transformers\ProductTransformer;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // 创建一个查询构造器
        $builder = Product::query()->where('on_sale', true);

        // 判断是否有提交 search 参数，如果有就赋值给 $search 变量
        // search 参数用来模糊搜索商品
        if ($search = \request()->input('search', '')) {
            $like = '%'.$search.'%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                        $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }

        if ($soldCountSort = \request()->sold_count) { // desc|asc
            $builder->where('sold_count',$soldCountSort);
        }

        if ($priceSort = \request()->price) {
            $builder->where('sold_count',$priceSort);
        }

        $products = $builder->paginate(config('app.default_page')); // 在线

        return $this->response->paginator($products, new ProductTransformer());
    }

    public function show(Product $product, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。
        if (!$product->on_sale) {
            throw new ResourceException('商品未上架');
        }
        return $this->response->item($product, new ProductTransformer());
    }
}
