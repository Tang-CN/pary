<?php

namespace app\controller;

use app\common\contorller\Api;
use app\model\GuanYin;
use app\Request;
class GuanYinApi extends Api
{
  public function getById(Request $request ){

      $id = $request->get('id');
      if (empty($id)) {
          return $this->error('参数错误');
      }
      $data=GuanYin::find($id);
      if(!$data){
          return $this->error('获取失败',[]);
      }
      return $this->success('获取成功',$data);
  }
}

