<?php
// 小程序连接
function mini_program() {
    return app('wechat.mini_program');
}
// 因为支付那里需要，自身的助手函数又去掉了，自定义一个
function array_get($array, $key, $default = null)
{
    if (is_null($key)) {
        return $array;
    }

    if (isset($array[$key])) {
        return $array[$key];
    }
    foreach (explode('.', $key) as $segment) {
        if (! is_array($array) || ! array_key_exists($segment, $array)) {
            return value($default);
        }
        $array = $array[$segment];
    }
    return $array;
}

