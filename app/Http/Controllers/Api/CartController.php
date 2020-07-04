<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CartRequest;
use App\Models\CartItem;
use App\Models\ProductSku;
use App\Services\CartService;
use App\Transformers\CartTransformer;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = $this->user->cartItems;
        return $this->response->collection($cartItems, new CartTransformer());
    }
    
    public function store(CartRequest $request, CartService $cartService)
    {
        $user   = $this->user;
        $skuId  = $request->input('sku_id'); // 商品 sku
        $num = $request->input('num'); // 商品数量
        $cartService->add($user,$skuId,$num);
        return $this->response->created();
    }
    // 把某商品移除购物车
    public function destroy(ProductSku $sku)
    {
        $this->user()->cartItems()->where('product_sku_id', $sku->id)->delete();
        return $this->response->noContent();
    }
}
