<?php
namespace Home\Controller;
use Think\Controller;


class UserController extends CommonController {
	public function index(){
        $this->redirect('Asset/user');
    }
	private function getCondition(){
		$condition = array();
		if($_POST['sName']){
			$condition['id'] = $_POST['sName'];
		}
		if($_POST['sDepartment']){
			$condition['department'] = $_POST['sDepartment'];
		}
		if($_POST['sJob']){
			$condition['job'] = $_POST['sJob'];
		}
		if($_POST['sOfficePhone']){
			$condition['office_phone'] = array('like','%'.$_POST['sOfficePhone'].'%');//$_POST['sOfficePhone'];
		}
		if($_POST['sMobilePhone']){
			$condition['mobile_phone'] = array('like','%'.$_POST['sMobilePhone'].'%');//$_POST['sMobilePhone'];
		}
		return $condition;
	}
	
	public function getUserNameList(){
		$user = M("user");
		$userNameList = $user->field('id,name')->select();
		$this->ajaxReturn($userNameList);
	}
	
	private function getUserData($id){
		$user = M("User");
		$condition['id'] = $id;
		$userData = $user->where($condition)->find();
		return $userData;
	}
	
	public function getUserListData(){		
		$allOptionText = $this->getAllOptionText();
		
		$condition = $this->getCondition();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$user = M('User');
		$userList = $user->where($condition)->order('create_date desc')->page($page.','.$rows)->select();
		$userListData = array();
		foreach($userList as $k=>$v){
			$v['department'] = $allOptionText[$v['department']]['option_name'];
			$v['job'] = $allOptionText[$v['job']]['option_name'];
			array_push($userListData,$v); 
		}
		$userCount = $user->where($condition)->count();
		$userListData = array('total'=>$userCount,'rows'=>$userListData);
		$this->ajaxReturn($userListData);
    }
	
	public function getOptionData($type){
		$partOptionIdAndText = $this->getPartOptionIdAndText($type);
		$this->ajaxReturn($partOptionIdAndText);
	}
	
	public function getNameData(){
		$allUserIdAndName = $this->getAllUserIdAndName();
		$this->ajaxReturn($allUserIdAndName);
	}
	
	public function userSave(){
		$user = M("user");
		$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		if($_POST['aOperation']=='add'){
			// 记录日志
			$text = '添加【人员（' . $_POST['aName'] . '）】';
			$this->addLogRecord(3, $text);
		
			// 添加用户
			$userData['name'] = $_POST['aName'];
			$userData['department'] = $_POST['aDepartment'];
			$userData['job'] = $_POST['aJob'];
			$userData['office_phone'] = $_POST['aOfficePhone'];
			$userData['mobile_phone'] = $_POST['aMobilePhone'];
			$userData['create_date'] = date("Y-m-d H:i:s",time()); 
			$user->add($userData);
			$result = array('success'=>true);
		}elseif($_POST['aOperation']=='edit'){
			$allOptionText = $this->getAllOptionText();
			$userData = $this->getUserData($_POST['aID']);
			
			// 记录日志
			$logData['name1'] = $userData['name'];
			$logData['name2'] = $_POST['aName'];
			$logData['department'] = $allOptionText[$_POST['aDepartment']]['option_name'];
			$logData['job'] = $allOptionText[$_POST['aJob']]['option_name'];
			$logData['office_phone'] = $_POST['aOfficePhone'];
			$logData['mobile_phone'] = $_POST['aMobilePhone'];
			
			$text = '修改【人员（' . $logData['name1'] . '）】为【' . '姓名：' . $logData['name2'] . '；部门：' . $logData['department'] . '；职务：' . $logData['job'] . '；办公电话：' . $logData['office_phone'] . '；移动电话：' . $logData['mobile_phone'] . '】';
			$this->addLogRecord(3, $text);
			
			// 修改用户
			$userData['id'] = $_POST['aID'];
			$userData['name'] = $_POST['aName'];
			$userData['department'] = $_POST['aDepartment'];
			$userData['job'] = $_POST['aJob'];
			$userData['office_phone'] = $_POST['aOfficePhone'];
			$userData['mobile_phone'] = $_POST['aMobilePhone'];
			$userData['create_date'] = date("Y-m-d H:i:s",time());
			$user->save($userData);
			$result = array('success'=>true);
		}else{
			$result = array('errorMsg'=>'数据存在问题，请检查后输入！');
		}
		$this->ajaxReturn($result);
    }
	
	public function userEdit(){
		$userData = $this->getUserData($_POST['id']);
		if($userData){
			$result = array('success'=>true,'data'=>$userData);
		}else{
			$result = array('errorMsg'=>'数据不存在！');
		}
		$this->ajaxReturn($result);
	}
	
	public function userDestroy(){
		// 记录日志
		$userData = $this->getUserData($_POST['id']);
		$text = '删除【人员（' . $userData['name'] . '）】';
		$this->addLogRecord(3, $text);
		
		// 删除用户
		$user = M("User");
		$condition['id'] = $_POST['id'];
		$user->where($condition)->delete();

		$result = array('success'=>true);
		$this->ajaxReturn($result);
	}
	
	public function tableExport(){
		Vendor("PHPExcel.PHPExcel");
		$objPHPExcel = new \PHPExcel();
		
		// 设置表头部
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '姓名')
					->setCellValue('B1', '部门')
					->setCellValue('C1', '职务')
					->setCellValue('D1', '办公电话')
					->setCellValue('E1', '移动电话');
		
		// 设置表内容
		$index = 2;
		$allOptionText = $this->getAllOptionText();
		$user = M('User');
		$condition = $this->getCondition();
		$userList = $user->where($condition)->order('create_date desc')->select();
		foreach($userList as $k=>$v){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$index, $v['name'])
					->setCellValue('B'.$index, $allOptionText[$v['department']]['option_name'])
					->setCellValue('C'.$index, $allOptionText[$v['job']]['option_name'])
					->setCellValue('D'.$index, $v['office_phone'])
					->setCellValue('E'.$index, $v['mobile_phone']);
			$index++;
		}

		// 设置表名
		$objPHPExcel->getActiveSheet()->setTitle('人员列表');
		
		Vendor("PHPExcel.PHPExcel.IOFactory");
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$fileName = 'User'.date('YmdHis').'.xlsx';
		$objWriter->save('./ExpImp/Export/' . $fileName);
		
		$result = array('success'=>true,'fileName'=>$fileName);
		$this->ajaxReturn($result);
		
	}
	
	public function tableImport(){
 		if (!empty($_FILES['userExcel']['name'])){
			// 判别文件类型是否正确
			$fileTypes = explode ( ".", $_FILES['userExcel']['name'] );
			$fileType = $fileTypes[count ($fileTypes)-1];
			if (strtolower($fileType)!= "xlsx"){
				exit('error_fileType');
			}
			// 判断拷贝是否成功
			$savePath = './ExpImp/Import/';
			$fileName = date('YmdHis').".".$fileType;
			$tempFile = $_FILES['userExcel']['tmp_name'];
			if (!copy( $tempFile, $savePath.$fileName )){
				exit('error_fileUpload');
			}
			
			Vendor("PHPExcel.PHPExcel");
			$objReader = \PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($savePath.$fileName);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow();
			$highestColumn = $objWorksheet->getHighestColumn();
			$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
			
			// 将Excel表的数据写入数组
			$allOptionId = $this->getAllOptionId();
			$excelData = array();
			for ($row = 2; $row <= $highestRow; $row++) {
				for ($col = 0; $col < $highestColumnIndex; $col++) {
					$value = (string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
					if($col==1 || $col==2){
						$excelData[$row][$col] = $allOptionId[$value]['id'];
					}else{
						$excelData[$row][$col] = $value;
					}
				} 
			}
			
			// 将数组的数据写入数据库
			$dataNum = 0;
			foreach($excelData as $k => $v ){
				$condition['name'] = $v[0];
				$userData = M("user")->where($condition)->find();
				if($userData){
					continue;
				}
				$data['name'] = $v[0];
				$data['department'] = $v[1];
				$data['job'] = $v[2];
				$data['office_phone'] = $v[3];
				$data['mobile_phone'] = $v[4];
				$data['create_date'] = date("Y-m-d H:i:s",time()); 
				$result = M("user")->add($data);
				if(!$result){
					exit('error_writeMysql');
				}
				$dataNum++;
			}
			$this->ajaxReturn($dataNum);
		}else{
			exit('error_fileEmpty');
		}
	}
}