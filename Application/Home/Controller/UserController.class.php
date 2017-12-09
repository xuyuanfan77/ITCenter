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
 		$option = M('option');
		$optionList = $option->select();
		$optionArray = array();
		foreach($optionList as $index=>$data){
			$optionArray[$data['id']] = $data;
		}

		$user = M('User');
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
		
		$userList = $user->where($condition)->order('create_date desc')->select();

		import("Org.Util.PHPExcel");
		
		// Create new PHPExcel object
		$objPHPExcel = new \PHPExcel();

		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '姓名')
					->setCellValue('B1', '部门')
					->setCellValue('C1', '职务')
					->setCellValue('D1', '办公电话')
					->setCellValue('E1', '移动电话');
		
		$index = 2;
		foreach($userList as $key=>$data){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$index, $data['name'])
					->setCellValue('B'.$index, $optionArray[$data['department']]['option_name'])
					->setCellValue('C'.$index, $optionArray[$data['job']]['option_name'])
					->setCellValue('D'.$index, $data['office_phone'])
					->setCellValue('E'.$index, $data['mobile_phone']);
			$index++;
		}

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('人员列表');

		import("Org.Util.PHPExcel.IOFactory");
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$objWriter->save('user.xlsx');
		
		$result = json_encode(array('success'=>true));
		$result = json_decode($result);
		$this->ajaxReturn($result);
		
	}
}