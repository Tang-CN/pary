<?php

namespace app\common\contorller;

use app\BaseController;
use think\Response;
use think\response\Json;

class Api extends BaseController
{

    /**
     * 操作成功
     * @param string $msg 提示消息
     * @param mixed $data 返回数据
     * @param int $code 错误码
     * @param string $type 返回数据格式
     */
    protected function success(string $msg = '', mixed $data = null, int $code = 1, string $type = 'json'): Response
    {
        return $this->result($msg, $data, $code, $type);
    }

    /**
     * 操作失败
     * @param string $msg 提示消息
     * @param mixed $data 返回数据
     * @param int $code 错误码
     * @param string $type 返回数据格式
     */
    protected function error(string $msg = '', mixed $data = null, int $code = 0, string $type = 'json'): Response
    {
        return $this->result($msg, $data, $code, $type);
    }

    /**
     * 返回 API 数据
     * @param string $msg 提示消息
     * @param mixed $data 返回数据
     * @param int $code 错误码
     * @param string $type 返回数据格式
     */
    public function result(string $msg, mixed $data = null, int $code = 0, string $type = 'json'): Response
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        return Response::create($result, $type);
    }
}
