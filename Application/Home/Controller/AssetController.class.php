<?php
namespace Home\Controller;
use Think\Controller;
class AssetController extends CommonController {
	public function index(){
        $this->redirect('Asset/assetList');
    }
	
	public function getAssetData(){

		$option = M('option');
		$optionList = $option->select();
		$optionArray = array();
		foreach($optionList as $index=>$data){
			$optionArray[$data['id']] = $data;
		}

		$asset = M('Asset');
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

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
		
		$assetList = $asset->where($condition)->order('create_date desc')->page($page.','.$rows)->select();
		$assetArray = array();
		foreach($assetList as $index=>$data){
			$data['type'] = $optionArray[$data['type']]['option_name'];
			$data['brand'] = $optionArray[$data['brand']]['option_name'];
			$data['network'] = $optionArray[$data['network']]['option_name'];
			$data['state'] = $optionArray[$data['state']]['option_name'];
			$data['source'] = $optionArray[$data['source']]['option_name'];
			array_push($assetArray,$data); 
		}
		$assetCount = $asset->where($condition)->count();
		$assetArray = array('total'=>$assetCount,'rows'=>$assetArray);
		$assetArray = json_encode($assetArray);
		$assetArray = json_decode($assetArray);
		$this->ajaxReturn($assetArray);
    }
	
	public function getOptionData($type){
		$option = M("option");
		$condition['type'] = $type;
		$optionList = $option->where($condition)->field('id,option_name')->select();
		$this->ajaxReturn($optionList);
	}
	
	public function assetSave(){
		$asset = M("asset");
		$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		if($_POST['aOperation']=='add'){
			if($_POST['aID']){
				/*记录日志*/
				$logData['asset_id'] = $_POST['aID'];
				$log = M("log");
				$data['type'] = 2;
				$data['text'] = '添加【资产（编号：' . $logData['asset_id'] . '）】';
				$data['create_date'] = date("Y-m-d H:i:s",time());
				$log->add($data);
				/*记录日志*/
			
				$condition['id'] = $_POST['aID'];
				$assetData = $asset->where($condition)->find();
				if($assetData){
					$result = json_encode(array('errorMsg'=>'此ID已经存在，请检查后输入！'));
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
					$result = json_encode(array('success'=>true));
				}
			}else{
				$result = json_encode(array('errorMsg'=>'ID号不能为空，请检查后输入！'));
			}
		}elseif($_POST['aOperation']=='edit'){
			/*记录日志*/
			$option = M('option');
			$optionList = $option->select();
			$optionArray = array();
			foreach($optionList as $index=>$optionData){
				$optionArray[$optionData['id']] = $optionData;
			}
			
			$condition['id'] = $_POST['aID'];
			$logData = $asset->where($condition)->find();
			
			$logData['asset_id'] = $_POST['aID'];
			$logData['type'] = $optionArray[$logData['type']]['option_name'];
			$logData['brand'] = $optionArray[$logData['brand']]['option_name'];
			$logData['model'] = $_POST['aModel'];
			$logData['number'] = $_POST['aNumber'];
			$logData['network'] = $optionArray[$logData['network']]['option_name'];
			$logData['source'] = $optionArray[$logData['source']]['option_name'];
			$logData['state'] = $optionArray[$logData['state']]['option_name'];	
			$logData['purchase_date'] = $_POST['aPurchaseDate'];
			
			$log = M("log");
			$data['type'] = 2;
			$data['text'] = '修改【资产（编号：' . $logData['asset_id'] . '）】为【类型：' . $logData['type'] . '；品牌：' . $logData['brand'] . '；型号：' . $logData['model'] . '；序列号：' . $logData['number'] . '；接入网络：' . $logData['network'] . '；设备来源：' . $logData['source'] . '；设备状态：' . $logData['state'] . '；购置时间：' . $logData['purchase_date'] . '】';
			$data['create_date'] = date("Y-m-d H:i:s",time());
			$log->add($data);
			/*记录日志*/
			
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
			$result = json_encode(array('success'=>true));
		}else{
			$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
    }
	
	public function assetEdit(){
		$asset = M("Asset");
		$condition['id'] = $_POST['id'];
		$assetData = $asset->where($condition)->find();
		if($assetData){
			$result = json_encode(array('success'=>true,'data'=>$assetData));
		}else{
			$result = json_encode(array('errorMsg'=>'数据不存在！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function assetDestroy(){
		/*记录日志*/
		$logData['asset_id'] = $_POST['id'];
		$log = M("log");
		$data['type'] = 2;
		$data['text'] = '删除【资产（编号：' . $logData['asset_id'] . '）】';
		$data['create_date'] = date("Y-m-d H:i:s",time());
		$log->add($data);
		/*记录日志*/
		
		$asset = M("Asset");
		$condition['id'] = $_POST['id'];
		
		$asset->where($condition)->delete();

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

		$asset = M('Asset');

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
		
		$assetList = $asset->where($condition)->order('create_date desc')->select();
		
		import("Org.Util.PHPExcel");
		
		// Create new PHPExcel object
		$objPHPExcel = new \PHPExcel();

		// Add some data
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
		
		$index = 2;
		foreach($assetList as $key=>$data){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$index, $data['id'])
					->setCellValue('B'.$index, $optionArray[$data['type']]['option_name'])
					->setCellValue('C'.$index, $optionArray[$data['brand']]['option_name'])
					->setCellValue('D'.$index, $data['model'])
					->setCellValue('E'.$index, $data['number'])
					->setCellValue('F'.$index, $optionArray[$data['network']]['option_name'])
					->setCellValue('G'.$index, $optionArray[$data['source']]['option_name'])
					->setCellValue('H'.$index, $optionArray[$data['state']]['option_name'])
					->setCellValue('I'.$index, $data['purchase_date'])
					->setCellValue('J'.$index, $data['remark']);
			$index++;
		}

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('资产列表');

		import("Org.Util.PHPExcel.IOFactory");
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$objWriter->save('asset.xlsx');
		
		$result = json_encode(array('success'=>true));
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function tableImport(){
 		if (!empty($_FILES['assetExcel']['name'])){
			$tmp_file = $_FILES['assetExcel']['tmp_name'];
			$file_types = explode ( ".", $_FILES['assetExcel']['name'] );
			$file_type = $file_types[count ($file_types)-1];
			/*判别是不是.xlsx文件，判别是不是excel文件*/
			if (strtolower($file_type )!= "xlsx"){
				exit('error_fileType');
			}
			
			$savePath = './Public/Upfile/';
			$str = date('Ymdhis');
			$file_name = $str.".".$file_type;
			if (!copy( $tmp_file, $savePath . $file_name )){
				exit('error_fileUpload');
			}
			import("Org.Util.PHPExcel");
			import("Org.Util.PHPExcel.IOFactory");
			$objReader = \PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($savePath.$file_name);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow();
			$highestColumn = $objWorksheet->getHighestColumn();
			import("Org.Util.PHPExcel.Cell");
			$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
			$excelData = array();
			
			$option = M('option');
			$optionList = $option->select();
			$optionArray = array();
			foreach($optionList as $k=>$v){
				$optionArray[$v['option_name']] = $v;
			}
			
			for ($row = 2; $row <= $highestRow; $row++) {
				for ($col = 0; $col < $highestColumnIndex; $col++) {
					$value = (string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
					if($col==1 || $col==2 || $col==5 || $col==6 || $col==7){
						$excelData[$row][$col] = $optionArray[$value]['id'];
					}else{
						$excelData[$row][$col] = $value;
					}
				} 
			}
			
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