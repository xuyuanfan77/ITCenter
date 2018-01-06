<?php
namespace Home\Controller;
use Think\Controller;
class AllocationController extends CommonController {
	public function index(){
        $this->redirect('Asset/allocation');
    }
	
	private function getCondition(){
		$condition = array();
		if($_POST['sID']){
			$condition['asset_id'] = $_POST['sID'];
		}
		if($_POST['sType']){
			$condition['type'] = $_POST['sType'];
		}
		if($_POST['sBrand']){
			$condition['brand'] = $_POST['sBrand'];
		}
		if($_POST['sModel']){
			$condition['model'] = $_POST['sModel'];
		}
		if($_POST['sNumber']){
			$condition['number'] = $_POST['sNumber'];
		}
		if($_POST['sNetWork']){
			$condition['network'] = $_POST['sNetWork'];
		}
		if($_POST['sSource']){
			$condition['source'] = $_POST['sSource'];
		}
		if($_POST['sPurchaseDateS']){
			if($_POST['sPurchaseDateE']){
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',$_POST['sPurchaseDateE']));
			}else{
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		if($_POST['sUseDateS']){
			if($_POST['sUseDateE']){
				$condition['use_date'] = array(array('gt',$_POST['sUseDateS']),array('lt',$_POST['sUseDateE']));
			}else{
				$condition['use_date'] = array(array('gt',$_POST['sUseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		if($_POST['sName']){
			$condition['user_id'] = $_POST['sName'];
		}
		if($_POST['sDepartment']){
			$condition['department'] = $_POST['sDepartment'];
		}
		if($_POST['sState']){
			$condition['state'] = $_POST['sState'];
		}
		return $condition;
	}
	
	public function getAllocatinListData(){
		$allOptionText = $this->getAllOptionText();

		$condition = $this->getCondition();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$allocation = D('AllocationView');
		$allocationList = $allocation->where($condition)->order('allocation_create_date desc')->page($page.','.$rows)->select();
		$allocationListData = array();
		foreach($allocationList as $k=>$v){
			$v['type'] = $allOptionText[$v['type']]['option_name'];
			$v['brand'] = $allOptionText[$v['brand']]['option_name'];
			$v['network'] = $allOptionText[$v['network']]['option_name'];
			$v['source'] = $allOptionText[$v['source']]['option_name'];
			$v['state'] = $allOptionText[$v['state']]['option_name'];
			$v['department'] = $allOptionText[$v['department']]['option_name'];
			$v['job'] = $allOptionText[$v['job']]['option_name'];
			array_push($allocationListData,$v); 
		}
		$allocationCount = $allocation->where($condition)->count();
		$allocationListData = array('total'=>$allocationCount,'rows'=>$allocationListData);
		$this->ajaxReturn($allocationListData);
    }
	
	public function getOptionData($type){
		$partOptionIdAndText = $this->getPartOptionIdAndText($type);
		$this->ajaxReturn($partOptionIdAndText);
	}
	
	public function getAssetData(){
		$asset = M("Asset");
		$condition['id'] = $_POST['id'];
		$assetData = $asset->where($condition)->find();
		if($assetData){
			$result = array('success'=>true,'data'=>$assetData);
		}else{
			$result = array('errorMsg'=>'数据不存在！');
		}
		$this->ajaxReturn($result);
	}
	
	public function getUserData(){
		$user = M("User");
		$condition['name'] = $_POST['name'];
		$userData = $user->where($condition)->find();
		if($userData){
			$result = array('success'=>true,'data'=>$userData);
		}else{
			$result = array('errorMsg'=>'数据不存在！');
		}
		$this->ajaxReturn($result);
	}
	
	public function allocationEdit(){
		$allocation = D("AllocationView");
		$condition['id'] = $_POST['id'];
		$allocationData = $allocation->where($condition)->find();
		if($allocationData){
			$result = array('success'=>true,'data'=>$allocationData);
		}else{
			$result = array('errorMsg'=>'数据不存在！');
		}
		$this->ajaxReturn($result);
    }
	
	public function allocationDestroy(){
		// 记录日志
		$allocation = D('AllocationView');
		$condition['id'] = $_POST['id'];
		$allocationData = $allocation->where($condition)->find();
		$text = '删除【（' . $allocationData['name'] . '）占用资产（编号：' . $allocationData['asset_id'] . '）】';
		$this->addLogRecord(1, $text);
		
		// 删除配置
		$allocation = M("allocation");
		$condition['id'] = $_POST['id'];
		$allocation->where($condition)->delete();

		$result = array('success'=>true);
		$this->ajaxReturn($result);
	}
	
	public function allocationSave(){
		$allocation = M("allocation");
		$result = array('errorMsg'=>'数据存在问题，请检查后输入！');

		if($_POST['aOperation']=='add'){	
			$condition1['asset_id'] = $_POST['aAssetID'];
			$isAllocation = $allocation->where($condition1)->find();
			if($isAllocation){
				$result = array('errorMsg'=>'该设备已被分配，请检查后输入！');
			}else{				
				// 记录日志
				$user = M("user");
				$condition2['id'] = $_POST['aUserID'];
				$userData = $user->where($condition2)->find();
				$text = '添加【（' . $userData['name'] . '）占用资产（编号：' . $_POST['aAssetID'] . '）】';
				$this->addLogRecord(1, $text);
				
				// 添加配置
				$allocationData['asset_id'] = $_POST['aAssetID'];
				$allocationData['user_id'] = $_POST['aUserID'];
				$allocationData['use_date'] = $_POST['aUseDate'];
				$allocationData['remark'] = $_POST['aRemark'];
				$allocationData['create_date'] = date("Y-m-d H:i:s",time()); 
				$allocation->add($allocationData);
				
				$result = array('success'=>true,'data'=>$allocationData);
			}
		}elseif($_POST['aOperation']=='edit'){
			// 记录日志
			$allocation = D('AllocationView');
			$condition3['id'] = $_POST['aID'];
			$allocationData = $allocation->where($condition3)->find();
			$logData['user_name1'] = $allocationData['name'];
			$logData['asset_id1'] = $allocationData['asset_id'];
			$user = M("user");
			$condition4['id'] = $_POST['aUserID'];
			$userData = $user->where($condition4)->find();
			$logData['user_name2'] = $userData['name'];
			$logData['asset_id2'] = $_POST['aAssetID'];
			$text = '修改【（' . $logData['user_name1'] . '）占用资产（编号：' . $logData['asset_id1'] . '）】为【（' . $logData['user_name2'] . '）占用资产（编号：' . $logData['asset_id2'] . '）】';
			$this->addLogRecord(1, $text);

			// 修改配置
			$allocation = M('Allocation');
			$allocationData['id'] = $_POST['aID'];
			$allocationData['asset_id'] = $_POST['aAssetID'];
			$allocationData['user_id'] = $_POST['aUserID'];
			$allocationData['use_date'] = $_POST['aUseDate'];
			$allocationData['remark'] = $_POST['aRemark'];
			$allocationData['create_date'] = date("Y-m-d H:i:s",time());
			$allocation->save($allocationData);

			$result = array('success'=>true);
		}else{
			$result = array('errorMsg'=>'数据存在问题，请检查后输入！');
		}
		$this->ajaxReturn($result);
    }
	
	public function tableExport(){
		Vendor("PHPExcel.PHPExcel");
		$objPHPExcel = new \PHPExcel();

		// 设置表头部
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '资产编号')
					->setCellValue('B1', '类型')
					->setCellValue('C1', '品牌')
					->setCellValue('D1', '型号')
					->setCellValue('E1', '序列号')
					->setCellValue('F1', '接入网络')
					->setCellValue('G1', '设备来源')
					->setCellValue('H1', '资产状态')
					->setCellValue('I1', '购置日期')
					->setCellValue('J1', '资产备注')
					->setCellValue('K1', '使用人')
					->setCellValue('L1', '部门')
					->setCellValue('M1', '职务')
					->setCellValue('N1', '办公电话')
					->setCellValue('O1', '移动电话')
					->setCellValue('P1', '分配日期')
					->setCellValue('Q1', '分配备注');
		
		// 设置表内容
		$index = 2;
		$allOptionText = $this->getAllOptionText();
		$allocation = D('AllocationView');
		$condition = $this->getCondition();
		$allocationList = $allocation->where($condition)->order('allocation_create_date desc')->select();
		foreach($allocationList as $k=>$v){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$index, $v['asset_id'])
					->setCellValue('B'.$index, $allOptionText[$v['type']]['option_name'])
					->setCellValue('C'.$index, $allOptionText[$v['brand']]['option_name'])
					->setCellValue('D'.$index, $v['model'])
					->setCellValue('E'.$index, $v['number'])
					->setCellValue('F'.$index, $allOptionText[$v['network']]['option_name'])
					->setCellValue('G'.$index, $allOptionText[$v['source']]['option_name'])
					->setCellValue('H'.$index, $allOptionText[$v['state']]['option_name'])
					->setCellValue('I'.$index, $v['purchase_date'])
					->setCellValue('J'.$index, $v['asset_remark'])
					->setCellValue('K'.$index, $v['name'])
					->setCellValue('L'.$index, $allOptionText[$v['department']]['option_name'])
					->setCellValue('M'.$index, $allOptionText[$v['job']]['option_name'])
					->setCellValue('N'.$index, $v['office_phone'])
					->setCellValue('O'.$index, $v['mobile_phone'])
					->setCellValue('P'.$index, $v['use_date'])
					->setCellValue('Q'.$index, $v['allocation_remark']);
			$index++;
		}

		// 设置表名
		$objPHPExcel->getActiveSheet()->setTitle('配置列表');

		Vendor("PHPExcel.PHPExcel.IOFactory");
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$fileName = 'Allocation'.date('YmdHis').'.xlsx';
		$objWriter->save('./ExpImp/Export/' . $fileName);
		
		$result = array('success'=>true,'fileName'=>$fileName);
		$this->ajaxReturn($result);
	}
	
	public function tableImport(){
 		if (!empty($_FILES['allocationExcel']['name'])){
			// 判别文件类型是否正确
			$fileTypes = explode ( ".", $_FILES['allocationExcel']['name'] );
			$fileType = $fileTypes[count ($fileTypes)-1];
			if (strtolower($fileType )!= "xlsx"){
				exit('error_fileType');
			}
			// 判断拷贝是否成功
			$savePath = './ExpImp/Import/';
			$fileName = date('YmdHis').".".$fileType;
			$tempFile = $_FILES['allocationExcel']['tmp_name'];
			if (!copy( $tempFile, $savePath . $fileName )){
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
					if($col==1 || $col==2 || $col==5 || $col==6 || $col==7 || $col==11 || $col==12){
						$excelData[$row][$col] = $allOptionId[$value]['id'];
					}else{
						$excelData[$row][$col] = $value;
					}
				} 
			}
			
			$dataNum = 0;
			foreach($excelData as $k => $v ){
				$condition1['asset_id'] = $v[0];
				$allocationData = M("allocation")->where($condition1)->find();
				if($allocationData){
					continue;
				}
				
				// 若没有相应的资产，则导入资产
				$condition2['id'] = $v[0];
				$assetData = M("asset")->where($condition2)->find();
				if(!$assetData){
					$data2['id'] = $v[0];
					$data2['type'] = $v[1];
					$data2['brand'] = $v[2];
					$data2['model'] = $v[3];
					$data2['number'] = $v[4];
					$data2['network'] = $v[5];
					$data2['source'] = $v[6];
					$data2['purchase_date'] = $v[8];
					$data2['remark'] = $v[9];
					$data2['state'] = $v[7];
					$data2['create_date'] = date("Y-m-d H:i:s",time()); 
					M("asset")->add($data2);
				}
				// 若没有相应的用户，则导入用户
				$condition3['name'] = $v[10];
				$userData = M("user")->where($condition3)->find();
				if(!$userData){
					$data3['name'] = $v[10];
					$data3['department'] = $v[11];
					$data3['job'] = $v[12];
					$data3['office_phone'] = $v[13];
					$data3['mobile_phone'] = $v[14];
					$data3['create_date'] = date("Y-m-d H:i:s",time()); 
					$userId = M("user")->add($data3);
				}else{
					$userId = $userData['id'];
				}

				// 若没有相应的配置，则导入配置
				$data1['asset_id'] = $v[0];
				$data1['user_id'] = $userId;
				$data1['use_date'] = $v[15];
				$data1['remark'] = $v[16];
				$data1['create_date'] = date("Y-m-d H:i:s",time()); 
				M("allocation")->add($data1);
				
				$dataNum++;
			}
			$this->ajaxReturn($dataNum);
		}else{
			exit('error_fileEmpty');
		}
	}
}