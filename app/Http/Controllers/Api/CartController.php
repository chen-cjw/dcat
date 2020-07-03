<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CartRequest;
use App\Models\CartItem;
use App\Models\ProductSku;
use App\Transformers\CartTransformer;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = $this->user->cartItems;
        return $this->response->collection($cartItems, new CartTransformer());
    }
    
    public function store(CartRequest $request)
    {
        $user   = $this->user;
        $skuId  = $request->input('sku_id'); // 商品 sku
        $num = $request->input('num'); // 商品数量

        // 从数据库中查询该商品是否已经在购物车中
        if ($cart = $user->cartItems()->where('product_sku_id', $skuId)->first()) {

            // 如果存在则直接叠加商品数量
            $cart->update([
                'num' => $cart->num + $num,
            ]);
        } else {

            // 否则创建一个新的购物车记录
            $cart = new CartItem(['num' => $num]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }

        return $this->response->created();
    }
    // 把某商品移除购物车
    public function destroy(ProductSku $sku)
    {
        $this->user()->cartItems()->where('product_sku_id', $sku->id)->delete();
        return $this->response->noContent();
    }
}
