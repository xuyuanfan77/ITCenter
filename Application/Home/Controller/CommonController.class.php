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
	
	protected function getAllOptionText(){
		$option = M('option');
		$optionData = $option->select();
		$allOptionText = array();
		foreach($optionData as $k=>$v){
			$allOptionText[$v['id']] = $v;
		}
		return $allOptionText;
	}
	
	protected function getAllOptionId(){
		$option = M('option');
		$optionData = $option->select();
		$allOptionText = array();
		foreach($optionData as $k=>$v){
			$allOptionText[$v['option_name']] = $v;
		}
		return $allOptionText;
	}
	
	protected function getPartOptionText($type){
		$option = M('option');
		$condition['type'] = $type;
		$optionData = $option->where($condition)->field('id,option_name')->select();
		$allOptionText = array();
		foreach($optionData as $k=>$v){
			$allOptionText[$v['id']] = $v;
		}
		return $allOptionText;
	}
	
	protected function getPartOptionIdAndText($type){
		$option = M("option");
		$condition['type'] = $type;
		$partOptionIdAndText = $option->where($condition)->field('id,option_name')->select();
		return $partOptionIdAndText;
	}
	
	protected function getAllUserIdAndName(){
		$user = M("user");
		$allUserIdAndName = $user->field('id,name')->select();
		return $allUserIdAndName;
	}
	
	protected function addLogRecord($type, $text){
		$data = array();
		$data['type'] = $type;
		$data['text'] = $text;
		$data['create_date'] = date("Y-m-d H:i:s",time());
		$log = M("log");
		$log->add($data);
	}
}