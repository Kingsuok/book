<?php

namespace App\Http\Middleware;

use Closure;

class HomeLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check login or not
        $httpReferer = $_SERVER['HTTP_REFERER'];// last http url
        $httpReferer = urlencode($httpReferer);//当字符串数据以url的形式传递给web服务器时,字符串中是不允许出现空格和特殊字符

        $member = $request->session()->get('member','');

        if ($member == ''){
            return redirect('/login?returnURL='.$httpReferer);
        }
        return $next($request);
    }
}
