<?php
namespace App\Transformers;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'phone' => $user->phone,
            'ml_openid' => $user->ml_openid,
            'wx_openid' => $user->wx_openid,
            'province' => $user->province,
            'country' => $user->country,
            'nickname' => $user->nickname,
            'sex' => $user->sex,
            'city' => $user->city,
            'avatar' => $user->avatar,
            'is_vip' => $user->is_vip,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }
}
