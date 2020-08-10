<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at',
        'default'
    ];
    protected $dates = ['last_used_at'];

    protected $appends = ['full_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getFullAddressAttribute() // 拼接完整的地址
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
