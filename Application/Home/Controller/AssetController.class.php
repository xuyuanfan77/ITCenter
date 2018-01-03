<?php
namespace Home\Controller;
use Think\Controller;
class AssetController extends CommonController {
	public function index(){
        $this->redirect('Asset/asset');
    }
	
	private function getCondition(){
		$condition = array();
		if($_POST['sID']){
			$condition['id'] = $_POST['sID'];
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
		if($_POST['sState']){
			$condition['state'] = $_POST['sState'];
		}
		if($_POST['sPurchaseDateS']){
			if($_POST['sPurchaseDateE']){
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',$_POST['sPurchaseDateE']));
			}else{
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		return $condition;
	}
	
	public function getAssetIdList(){
		$asset = M("asset");
		$assetIdList = $asset->field('id')->select();
		$this->ajaxReturn($assetIdList);
	}
	
	private function getAssetData($id){
		$asset = M("asset");
		$condition['id'] = $id;
		$assetData = $asset->where($condition)->find();
		return $assetData;
	}
	
	public function getAssetListData(){
		$allOptionText = $this->getAllOptionText();

		$condition = $this->getCondition();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$asset = M('Asset');
		$assetList = $asset->where($condition)->order('create_date desc')->page($page.','.$rows)->select();
		$assetListData = array();
		foreach($assetList as $k=>$v){
			$v['type'] = $allOptionText[$v['type']]['option_name'];
			$v['brand'] = $allOptionText[$v['brand']]['option_name'];
			$v['network'] = $allOptionText[$v['network']]['option_name'];
			$v['state'] = $allOptionText[$v['state']]['option_name'];
			$v['source'] = $allOptionText[$v['source']]['option_name'];
			array_push($assetListData,$v); 
		}
		$assetCount = $asset->where($condition)->count();
		$assetListData = array('total'=>$assetCount,'rows'=>$assetListData);
		$this->ajaxReturn($assetListData);
    }
	
	public function getOptionData($type){
		$partOptionIdAndText = $this->getPartOptionIdAndText($type);
		$this->ajaxReturn($partOptionIdAndText);
	}
	
	public function assetSave(){
		$asset = M("asset");
		$result = array('errorMsg'=>'数据存在问题，请检查后输入！');
		if($_POST['aOperation']=='add'){
			if($_POST['aID']){
				// 记录日志
				$text = '添加【资产（编号：' . $logData['aID'] . '）】';
				$this->addLogRecord(2, $text);

				// 添加资产
				$assetData = $this->getAssetData($_POST['aID']);
				if($assetData){
					$result = array('errorMsg'=>'此ID已经存在，请检查后输入！');
				}else{
					$assetData['id'] = $_POST['aID'];
					$assetData['type'] = $_POST['aType'];
					$assetData['brand'] = $_POST['aBrand'];
					$assetData['model'] = $_POST['aModel'];
					$assetData['number'] = $_POST['aNumber'];
					$assetData['network'] = $_POST['aNetWork'];
					$assetData['source'] = $_POST['aSource'];
					$assetData['state'] = $_POST['aState'];
					$assetData['purchase_date'] = $_POST['aPurchaseDate'];
					$assetData['remark'] = $_POST['aRemark'];
					$assetData['create_date'] = date("Y-m-d H:i:s",time()); 
					$asset->add($assetData);
					$result = array('success'=>true);
				}
			}else{
				$result = array('errorMsg'=>'ID号不能为空，请检查后输入！');
			}
		}elseif($_POST['aOperation']=='edit'){
			// 记录日志
			$allOptionText = $this->getAllOptionText();
			$condition['id'] = $_POST['aID'];
			$logData = $asset->where($condition)->find();
			$logData['asset_id'] = $_POST['aID'];
			$logData['type'] = $allOptionText[$logData['type']]['option_name'];
			$logData['brand'] = $allOptionText[$logData['brand']]['option_name'];
			$logData['model'] = $_POST['aModel'];
			$logData['number'] = $_POST['aNumber'];
			$logData['network'] = $allOptionText[$logData['network']]['option_name'];
			$logData['source'] = $allOptionText[$logData['source']]['option_name'];
			$logData['state'] = $allOptionText[$logData['state']]['option_name'];	
			$logData['purchase_date'] = $_POST['aPurchaseDate'];

			$text = '修改【资产（编号：' . $logData['asset_id'] . '）】为【类型：' . $logData['type'] . '；品牌：' . $logData['brand'] . '；型号：' . $logData['model'] . '；序列号：' . $logData['number'] . '；接入网络：' . $logData['network'] . '；设备来源：' . $logData['source'] . '；设备状态：' . $logData['state'] . '；购置时间：' . $logData['purchase_date'] . '】';
			$this->addLogRecord(2, $text);
			
			// 修改资产
			$assetData['id'] = $_POST['aID'];
			$assetData['type'] = $_POST['aType'];
			$assetData['brand'] = $_POST['aBrand'];
			$assetData['model'] = $_POST['aModel'];
			$assetData['number'] = $_POST['aNumber'];
			$assetData['network'] = $_POST['aNetWork'];
			$assetData['source'] = $_POST['aSource'];
			$assetData['state'] = $_POST['aState'];
			$assetData['purchase_date'] = $_POST['aPurchaseDate'];
			$assetData['remark'] = $_POST['aRemark'];
			$assetData['create_date'] = date("Y-m-d H:i:s",time()); 
			$asset->save($assetData);
			$result = array('success'=>true);
		}else{
			$result = array('errorMsg'=>'数据存在问题，请检查后输入！');
		}
		$this->ajaxReturn($result);
    }
	
	public function assetEdit(){
		$assetData = $this->getAssetData($_POST['id']);
		if($assetData){
			$result = array('success'=>true,'data'=>$assetData);
		}else{
			$result = array('errorMsg'=>'数据不存在！');
		}
		$this->ajaxReturn($result);
	}
	
	public function assetDestroy(){
		// 记录日志
		$text = '删除【资产（编号：' . $_POST['id'] . '）】';
		$this->addLogRecord(2, $text);
		
		// 删除资产
		$asset = M("Asset");
		$condition['id'] = $_POST['id'];
		$asset->where($condition)->delete();

		$result = array('success'=>true);
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
					->setCellValue('J1', '备注');;
		
		// 设置表内容
		$index = 2;
		$asset = M('Asset');
		$condition = $this->getCondition();		
		$assetList = $asset->where($condition)->order('create_date desc')->select();
		$allOptionText = $this->getAllOptionText();
		foreach($assetList as $key=>$data){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$index, $data['id'])
					->setCellValue('B'.$index, $allOptionText[$data['type']]['option_name'])
					->setCellValue('C'.$index, $allOptionText[$data['brand']]['option_name'])
					->setCellValue('D'.$index, $data['model'])
					->setCellValue('E'.$index, $data['number'])
					->setCellValue('F'.$index, $allOptionText[$data['network']]['option_name'])
					->setCellValue('G'.$index, $allOptionText[$data['source']]['option_name'])
					->setCellValue('H'.$index, $allOptionText[$data['state']]['option_name'])
					->setCellValue('I'.$index, $data['purchase_date'])
					->setCellValue('J'.$index, $data['remark']);
			$index++;
		}

		// 设置表名
		$objPHPExcel->getActiveSheet()->setTitle('资产列表');

		Vendor("PHPExcel.PHPExcel.IOFactory");
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$fileName = 'Asset'.date('YmdHis').'.xlsx';
		$objWriter->save('./ExpImp/Export/' . $fileName);
		
		$result = array('success'=>true,'fileName'=>$fileName);
		$this->ajaxReturn($result);
	}
	
	public function tableImport(){
 		if (!empty($_FILES['assetExcel']['name'])){
			// 判别文件类型是否正确
			$fileTypes = explode ( ".", $_FILES['assetExcel']['name'] );
			$fileType = $fileTypes[count ($fileTypes)-1];
			if (strtolower($fileType)!= "xlsx"){
				exit('error_fileType');
			}
			// 判断拷贝是否成功
			$savePath = './ExpImp/Import/';
			$fileName = date('Ymdhis').".".$fileType;
			$tempFile = $_FILES['assetExcel']['tmp_name'];
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
					if($col==1 || $col==2 || $col==5 || $col==6 || $col==7){
						$excelData[$row][$col] = $allOptionId[$value]['id'];
					}else{
						$excelData[$row][$col] = $value;
					}
				} 
			}
			
			// 将数组的数据写入数据库
			$dataNum = 0;
			foreach($excelData as $k => $v ){
				$condition['id'] = $v[0];
				$assetData = M("asset")->where($condition)->find();
				if($assetData){
					continue;
				}
				$data['id'] = $v[0];
				$data['type'] = $v[1];
				$data['brand'] = $v[2];
				$data['model'] = $v[3];
				$data['number'] = $v[4];
				$data['network'] = $v[5];
				$data['source'] = $v[6];
				$data['purchase_date'] = $v[8];
				$data['remark'] = $v[9];
				$data['state'] = $v[7];
				$data['create_date'] = date("Y-m-d H:i:s",time()); 
				$result = M("asset")->add($data);
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