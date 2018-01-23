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
				if($allOptionText[$x]['option_name']){
					$j['type'] = $allOptionText[$x]['option_name'];
				}else{
					$j['type'] = '未知';
				}
				if($allOptionText[$i]['option_name']){
					$j['brand'] = $allOptionText[$i]['option_name'];
				}else{
					$j['brand'] = '未知';
				}
				array_push($tableData,$j);
			}
		}
		$this->ajaxReturn($tableData);
    }
	
	public function tableExport(){
		Vendor("PHPExcel.PHPExcel");
		$objPHPExcel = new \PHPExcel();
		$Model = new \Think\Model();
		
		// 生成标题数据
		$titleData = array();
		$titleData['type'] = array('title'=>'类型','index'=>'A');
		$titleData['brand'] = array('title'=>'品牌','index'=>'B');
		$letter = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		
		$assetPurchaseDates = $Model->query("SELECT substring(purchase_date,1,4) as year FROM asset GROUP BY substring(purchase_date,1,4);");
		$index = 2;
		foreach($assetPurchaseDates as $k=>$v){
			$titleData[$v['year']] = array('title'=>$v['year'],'index'=>$letter[$index]);
			$index++;
		}
		$titleData['sum'] = array('title'=>'合计','index'=>$letter[$index]);
		
		// 写入Excel标题
		foreach($titleData as $k=>$v){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($v['index'].'1', $v['title']);
		}
		
		// 生成内容数据
		$assetTableListData = $Model->query("SELECT type,brand,substring(purchase_date,1,4) as year,count(*) as count FROM asset GROUP BY substring(purchase_date,1,4),type,brand ORDER BY type,brand,year;");
		$assetTableData = array();
		foreach($assetTableListData as $k=>$v){
			$assetTableData[$v['type']][$v['brand']][$v['year']] = $v['count'];
			$assetTableData[$v['type']][$v['brand']]['sum'] += $v['count'];
		}
		
		$allOptionText = $this->getAllOptionText();
		$tableData = array();
		foreach($assetTableData as $x=>$y){
			foreach($y as $i=>$j){
				if($allOptionText[$x]['option_name']){
					$j['type'] = $allOptionText[$x]['option_name'];
				}else{
					$j['type'] = '未知';
				}
				if($allOptionText[$i]['option_name']){
					$j['brand'] = $allOptionText[$i]['option_name'];
				}else{
					$j['brand'] = '未知';
				}
				array_push($tableData,$j);
			}
		}
		// 写入Excel内容
		$index = 2;
		foreach($tableData as $x=>$y){
			foreach($y as $i=>$j){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($titleData[$i]['index'].$index, $j);
			}
			$index++;
		}

		// 设置表名
		$objPHPExcel->getActiveSheet()->setTitle('资产报表');

		Vendor("PHPExcel.PHPExcel.IOFactory");
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$fileName = 'AssetTable'.date('YmdHis').'.xlsx';
		$objWriter->save('./ExpImp/Export/' . $fileName);
		
		$result = array('success'=>true,'fileName'=>$fileName);
		$this->ajaxReturn($result);
	}
}