<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use App\Transformers\OrderTransformer;

class OrdersController extends Controller
{
    // todo 此用户超出2小时此单作废
    public function index()
    {
        $orders = $this->user->orders()->orderBy('created_at','desc')->paginate();
        return $this->response->paginator($orders,new OrderTransformer());
    }

    public function show($id)
    {
        $orders = $this->user->orders()->findOrFail($id);
        return $this->response->item($orders,new OrderTransformer());
    }
    
    public function store(OrderRequest $request,OrderService $orderService)
    {
        $user  = $this->user();
        // 开启一个数据库事务
        return $this->response->item($orderService->add($user,$request), new OrderTransformer());
    }
}
