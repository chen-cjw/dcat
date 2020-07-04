<?php

namespace App\Services;

use App\Models\CartItem;

class CartService
{
    public function add($user, $skuId, $num)
    {
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
        return $cart;// 虽然没有用，这里可以不 return
    }
}