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
			session('managerID', $managerData['id']);	
			session('managerName', $managerData['name']);

			//$this->redirect('Asset/allocation');
			$this->redirect('Allocation/index');
        }else{
            $this->error('账号或者密码输入错误！');
        }
	}
}