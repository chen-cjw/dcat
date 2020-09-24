<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'email', 'nickname','sex','language','city',
        'province','country','avatar','wx_openid','ml_openid','unionid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'unionid'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function ml_openid($code)
    {
        $sessionUser = mini_program()->auth->session($code);
        if (!empty($sessionUser['errcode'])) {
            throw new \Exception('获取用户的openid操作失败!');
        }
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    // 收藏
    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'user_favorite_products')
            ->withTimestamps()// 代表中间表带有时间戳字段
            ->orderBy('user_favorite_products.created_at', 'desc');//  代表默认的排序方式是根据中间表的创建时间倒序排序。
    }

    // 购物车
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    // 邀请码
    public function generateRefCode($length = 6)
    {
        $refCode = \substr(\str_shuffle(\str_repeat(config('game.refCodeCharacters'), $length)), 0, $length);
        $count = 0;
        while (!\is_null(User::where('ref_code', $refCode)->first())) {
            $count++;
            $refCode = \substr(\str_shuffle(\str_repeat(config('game.refCodeCharacters'), $length)), 0, $length);
            if ($count == 100) {
                throw new BadRequestException();
            }
        }
        return $refCode;
    }


    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
