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
		// 初始化报表数组
		/* $departmentIds = $this->getPartOptionIdAndText(6);
		$typeIds = $this->getPartOptionIdAndText(1);
		$allocationTableData = array();
		foreach($departmentIds as $k=>$v){
			foreach($typeIds as $x=>$y){
				$allocationTableData[$v['id']]['field'.$y['id']] = 0;
			}
		} */
		
		// 填充报表数组
		$allocation = D('AllocationView');
		$allocationTableListData = $allocation->field('department,type,count(*) as count')->group('department,type')->select();
		foreach($allocationTableListData as $i=>$j){
			$allocationTableData[$j['department']]['field'.$j['type']] = $j['count'];
		}
		
		// 增加报表部门字段
		$allOptionText = $this->getAllOptionText();
		foreach($allocationTableData as $i=>$j){
			$allocationTableData[$i]['department'] = $allOptionText[$i]['option_name'];
		}
		
		$tableData = array();
		foreach($allocationTableData as $a=>$b){
			array_push($tableData,$b);
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