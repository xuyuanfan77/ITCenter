<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	public function getUserData(){
		$option = M('option');
		$optionList = $option->select();
		$optionArray = array();
		foreach($optionList as $index=>$data){
			$optionArray[$data['id']] = $data;
		}

		$user = M('User');
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$condition = array();
		if($_POST['sName']){
			$condition['name'] = $_POST['sName'];
		}
		if($_POST['sDepartment']){
			$condition['department'] = $_POST['sDepartment'];
		}
		if($_POST['sJob']){
			$condition['job'] = $_POST['sJob'];
		}
		if($_POST['sOfficePhone']){
			$condition['office_phone'] = $_POST['sOfficePhone'];
		}
		if($_POST['sMobilePhone']){
			$condition['mobile_phone'] = $_POST['sMobilePhone'];
		}
		
		$userList = $user->where($condition)->page($page.','.$rows)->select();
		$userArray = array();
		foreach($userList as $index=>$data){
			$data['department'] = $optionArray[$data['department']]['option_name'];
			$data['job'] = $optionArray[$data['job']]['option_name'];
			array_push($userArray,$data); 
		}
		$userCount = $user->where($condition)->count();
		$userArray = array('total'=>$userCount,'rows'=>$userArray);
		$userArray = json_encode($userArray);
		$userArray = json_decode($userArray);
		$this->ajaxReturn($userArray);
    }
	
	public function getOptionData($type){
		$option = M("option");
		$condition['type'] = $type;
		$optionList = $option->where($condition)->field('id,option_name')->select();
		$this->ajaxReturn($optionList);
	}
	
	public function getNameData(){
		$user = M("user");
		$nameList = $user->field('id,name')->select();
		$this->ajaxReturn($nameList);
	}
	
	public function userSave(){
		$user = M("user");
		$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		if($_POST['aOperation']=='add'){
			$userData['name'] = $_POST['aName'];
			$userData['department'] = $_POST['aDepartment'];
			$userData['job'] = $_POST['aJob'];
			$userData['office_phone'] = $_POST['aOfficePhone'];
			$userData['mobile_phone'] = $_POST['aMobilePhone'];
			$userData['create_date'] = date("Y-m-d H:i:s",time()); 
			$user->add($userData);
			$result = json_encode(array('success'=>true));
		}elseif($_POST['aOperation']=='edit'){
			$userData['id'] = $_POST['aID'];
			$userData['name'] = $_POST['aName'];
			$userData['department'] = $_POST['aDepartment'];
			$userData['job'] = $_POST['aJob'];
			$userData['office_phone'] = $_POST['aOfficePhone'];
			$userData['mobile_phone'] = $_POST['aMobilePhone'];
			$userData['create_date'] = date("Y-m-d H:i:s",time());
			$user->save($userData);
			$result = json_encode(array('success'=>true));
		}else{
			$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
    }
	
	public function userEdit(){
		$user = M("User");
		$condition['id'] = $_POST['id'];
		$userData = $user->where($condition)->find();
		if($userData){
			$result = json_encode(array('success'=>true,'data'=>$userData));
		}else{
			$result = json_encode(array('errorMsg'=>'数据不存在！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function userDestroy(){
		$user = M("User");
		$condition['id'] = $_POST['id'];
		
		$user->where($condition)->delete();

		$result = json_encode(array('success'=>true));
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
}