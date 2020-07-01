<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AuthMlOpenidStoreRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function testLogin()
    {
        $user = User::findOrFail(1);
        $token = \Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token,$user)->setStatusCode(201);
    }
    // 小程序 获取用户的openid
    public function mlOpenidStore1(AuthMlOpenidStoreRequest $request,User $user)
    {
        $code = $request->code;
        $sessionUser = $user->ml_openid();
        $openid = $sessionUser['openid'];
        $session_key = $sessionUser['session_key'];
        Cache::put($code, ['session_key'=>$session_key,'ml_openid'=>$openid], 300);
        if($user = User::where('ml_openid', $openid)->first()) {
            if ($user->phone) {
                $token = \Auth::guard('api')->fromUser($user);
                return $this->respondWithToken($token,$openid,$user);
            }
            return $this->oauthNo();// 第二次去拿手机号码
        }
        User::create($this->createUser($sessionUser,$request));
        return $this->oauthNo();
    }

    protected function createUser($sessionUser,$request)
    {
        return [ // 不存在此用户添加
            'ml_openid'=>$sessionUser['openid'],
        ];
    }

    // 获取手机号码
    public function phoneStore(AuthPhoneStoreRequest $request)
    {
        $session = Cache::get($request->code);// 解析的问题
        if(!$session) {
            throw new \Exception('code 和第一次的不一致');
        }
        $app = app('wechat.mini_program');
        $decryptedData = $app->encryptor->decryptData($session['session_key'], $request->iv, $request->encrypted_data);

        if (empty($decryptedData)) {
            throw new \Exception('操作失败!321');
        }

        $user = User::where('ml_openid',$session['ml_openid'])->firstOrFail();
        $phoneNumber = $decryptedData['phoneNumber'];
        $user->update(['phone'=>$phoneNumber]);

        $token = \Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token,$phoneNumber,$user)->setStatusCode(201);
    }

    // 个人中心
    public function meShow()
    {
        return $this->user();
        return auth('api')->user();
        return $this->response->item($this->user(),new UserTransformer());
    }

    public function destroy()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }

    protected function respondWithToken($token, $user)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user'=>$user,
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 120
        ]);
    }

    protected function oauthNo()
    {
        return $this->response->array([
            'oauth'=>'未授权手机号码'
        ]);
    }
}
