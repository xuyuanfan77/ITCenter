<?php
namespace Home\Controller;
use Think\Controller;
class AllocationTableController extends CommonController {
	public function index(){
        $this->redirect('Asset/allocationTable');
    }
	
	public function getAllocationTableTitleData(){
		$assetTypes = $this->getPartOptionIdAndText(1);
		$this->ajaxReturn($assetTypes);
	}
	
	public function getAllocationTableData(){		
		// 填充报表数组
		$allocation = D('AllocationView');
		$allocationTableListData = $allocation->field('department,type,count(*) as count')->group('department,type')->select();
		foreach($allocationTableListData as $i=>$j){
			$allocationTableData[$j['department']]['field'.$j['type']] = $j['count'];
		}
		
		// 增加报表部门字段
		$allOptionText = $this->getAllOptionText();
		foreach($allocationTableData as $i=>$j){
			if($allOptionText[$i]['option_name']){
				$allocationTableData[$i]['department'] = $allOptionText[$i]['option_name'];
			}else{
				$allocationTableData[$i]['department'] = '未知';
			}
		}
		
		$tableData = array();
		foreach($allocationTableData as $a=>$b){
			array_push($tableData,$b);
		}
		$this->ajaxReturn($tableData);
    }
	
	public function tableExport(){
		$types = $this->getPartOptionIdAndText(1);
		$letter = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$index = 1;
		$typeOption = array();
		foreach($types as $k=>$v){
			$v['index'] = $letter[$index];
			$typeOption[$v['id']] = $v;
			$index++;
		}
		
		$departments = $this->getPartOptionIdAndText(6);
		$departmentOption = array();
		$index = 2;
		foreach($departments as $k=>$v){
			$v['index'] = $index;
			$departmentOption[$v['id']] = $v;
			$index++;
		}
		
		Vendor("PHPExcel.PHPExcel");
		$objPHPExcel = new \PHPExcel();
		
		// 设置表头部
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '部门');
		foreach($typeOption as $k=>$v){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($v['index'].'1', $v['option_name']);
		}
		
		foreach($departmentOption as $k=>$v){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$v['index'], $v['option_name']);
		}
		
		// 设置表内容
		$allOptionText = $this->getAllOptionText();
		$allocation = D('AllocationView');
		$allocationTableListData = $allocation->field('department,type,count(*) as count')->group('department,type')->select();
		foreach($allocationTableListData as $k=>$v){
			if($typeOption[$v['type']]['index'] && $departmentOption[$v['department']]['index']){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($typeOption[$v['type']]['index'].$departmentOption[$v['department']]['index'], $v['count']);
			}
		}

		// 设置表名
		$objPHPExcel->getActiveSheet()->setTitle('配置报表');

		Vendor("PHPExcel.PHPExcel.IOFactory");
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$fileName = 'AllocationTable'.date('YmdHis').'.xlsx';
		$objWriter->save('./ExpImp/Export/' . $fileName);
		
		$result = array('success'=>true,'fileName'=>$fileName);
		$this->ajaxReturn($result);
	}
}