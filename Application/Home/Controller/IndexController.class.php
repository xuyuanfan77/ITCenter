<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }
	
	public function login(){
		$manager = M('manager');
		$condition['name'] = array('eq',$_POST['name']);
		$managerData = $manager->where($condition)->find();
		if ($managerData&&$managerData['password']==$_POST['password']){
			$sessionID = session_id();
			session('id', $sessionID);
			session('name', $userData['name']);	

			$this->redirect('Asset/assetList');
        }else{
            $this->error('账号或者密码输入错误！');
        }
	}
}