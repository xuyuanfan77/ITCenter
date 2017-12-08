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
		
		$userList = $user->where($condition)->order('create_date desc')->page($page.','.$rows)->select();
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
			/*记录日志*/
			$logData['name'] = $_POST['aName'];
			
			$log = M("log");
			$data['type'] = 3;
			$data['text'] = '添加【人员（' . $logData['name'] . '）】';
			$data['create_date'] = date("Y-m-d H:i:s",time());
			$log->add($data);
			/*记录日志*/
		
			$userData['name'] = $_POST['aName'];
			$userData['department'] = $_POST['aDepartment'];
			$userData['job'] = $_POST['aJob'];
			$userData['office_phone'] = $_POST['aOfficePhone'];
			$userData['mobile_phone'] = $_POST['aMobilePhone'];
			$userData['create_date'] = date("Y-m-d H:i:s",time()); 
			$user->add($userData);
			$result = json_encode(array('success'=>true));
		}elseif($_POST['aOperation']=='edit'){
			/*记录日志*/
			$option = M('option');
			$optionList = $option->select();
			$optionArray = array();
			foreach($optionList as $index=>$optionData){
				$optionArray[$optionData['id']] = $optionData;
			}
			
			$user = M("User");
			$condition['id'] = $_POST['aID'];
			$userData = $user->where($condition)->find();
			$logData['name1'] = $userData['name'];
			$logData['name2'] = $_POST['aName'];
			$logData['department'] = $optionArray[$_POST['aDepartment']]['option_name'];
			$logData['job'] = $optionArray[$_POST['aJob']]['option_name'];
			$logData['office_phone'] = $_POST['aOfficePhone'];
			$logData['mobile_phone'] = $_POST['aMobilePhone'];
			
			$log = M("log");
			$data['type'] = 3;
			$data['text'] = '修改【人员（' . $logData['name1'] . '）】为【' . '姓名：' . $logData['name2'] . '；部门：' . $logData['department'] . '；职务：' . $logData['job'] . '；办公电话：' . $logData['office_phone'] . '；移动电话：' . $logData['mobile_phone'] . '】';
			$data['create_date'] = date("Y-m-d H:i:s",time());
			$log->add($data);
			/*记录日志*/
			
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
		/*记录日志*/		
		$user = M("User");
		$condition['id'] = $_POST['id'];
		$userData = $user->where($condition)->find();
		$logData['name'] = $userData['name'];
		
		$log = M("log");
		$data['type'] = 3;
		$data['text'] = '删除【人员（' . $logData['name'] . '）】';
		$data['create_date'] = date("Y-m-d H:i:s",time());
		$log->add($data);
		/*记录日志*/
		
		$user = M("User");
		$condition['id'] = $_POST['id'];
		
		$user->where($condition)->delete();

		$result = json_encode(array('success'=>true));
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function tableExport(){
/* 		$condition = array();
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
		
		$userList = $user->where($condition)->order('create_date desc')->page($page.','.$rows)->select(); */
		
		include 'PHPExcel.php';
		include 'PHPExcel/Writer/Excel2007.php';
		//或者include 'PHPExcel/Writer/Excel5.php'; 用于输出.xls的
		创建一个excel
		$objPHPExcel = new PHPExcel();
		//输出Excel表格到浏览器下载
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="abc.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save('php://output');
		
		
		$result = json_encode(array('errorMsg' => $_POST['sName']));
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
}