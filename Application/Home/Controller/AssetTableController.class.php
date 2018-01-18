<?php
namespace Home\Controller;
use Think\Controller;
class AssetTableController extends CommonController {
	public function index(){
        $this->redirect('Asset/assetTable');
    }

	public function getAssetTableTitleData(){
		$Model = new \Think\Model();
		$assetPurchaseDates = $Model->query("SELECT substring(purchase_date,1,4) as year FROM asset GROUP BY substring(purchase_date,1,4);");
		$this->ajaxReturn($assetPurchaseDates);
	}
	
	public function getAssetTableData(){
		$Model = new \Think\Model();
		$assetTableListData = $Model->query("SELECT type,brand,substring(purchase_date,1,4) as year,count(*) as count FROM asset GROUP BY substring(purchase_date,1,4),type,brand ORDER BY type,brand,year;");
		$assetTableData = array();
		foreach($assetTableListData as $k=>$v){
			$assetTableData[$v['type']][$v['brand']]['field'.$v['year']] = $v['count'];
			$assetTableData[$v['type']][$v['brand']]['sum'] += $v['count'];
		}
		
		$allOptionText = $this->getAllOptionText();
		$tableData = array();
		foreach($assetTableData as $x=>$y){
			foreach($y as $i=>$j){
				$j['type'] = $allOptionText[$x]['option_name'];
				$j['brand'] = $allOptionText[$i]['option_name'];
				array_push($tableData,$j);
			}
		}
		$this->ajaxReturn($tableData);
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
		foreach($assetList as $k=>$v){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$index, $v['id'])
					->setCellValue('B'.$index, $allOptionText[$v['type']]['option_name'])
					->setCellValue('C'.$index, $allOptionText[$v['brand']]['option_name'])
					->setCellValue('D'.$index, $v['model'])
					->setCellValue('E'.$index, $v['number'])
					->setCellValue('F'.$index, $allOptionText[$v['network']]['option_name'])
					->setCellValue('G'.$index, $allOptionText[$v['source']]['option_name'])
					->setCellValue('H'.$index, $allOptionText[$v['state']]['option_name'])
					->setCellValue('I'.$index, $v['purchase_date'])
					->setCellValue('J'.$index, $v['remark']);
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
}