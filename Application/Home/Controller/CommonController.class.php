<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function _initialize(){
		//判断用户是否已经登录
		if(!cookie('PHPSESSID') || !session('id') || cookie('PHPSESSID') != session('id')) {
			$this->redirect('Index/index');
		}
	}
}