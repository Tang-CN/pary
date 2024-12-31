<?php

namespace app\common\middleware;

use Closure;
use think\Request;
use think\Response;

class AllowCrossDomain
{
    protected array $header = [
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Max-Age'           => 1800,
        'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'     => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, platform',  // 允许 platform 头字段
    ];

    /**
     * 跨域请求检测
     * @access public
     * @param Request $request
     * @param Closure $next
     * @param array|null $header
     * @return Response
     */
    public function handle(Request $request, Closure $next, ?array $header = []): Response
    {
        // 设置跨域头部
        $header = !empty($header) ? array_merge($this->header, $header) : $this->header;

        // 允许所有来源跨域
        $header['Access-Control-Allow-Origin'] = '*';  // 允许所有来源跨域

        // 处理 OPTIONS 请求
        if ($request->isOptions()) {
            return response('', 204, $header);
        }

        // 继续处理请求
        return $next($request)->header($header);
    }
}

