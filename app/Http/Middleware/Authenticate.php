<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.　新規登録が通らなかったらどこに飛ぶか
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request) //ログインできなかったら新規登録画面にリダイレクト
    {
        if (! $request->expectsJson()) {
            return route('register');
        }
    }
}
