<?php
namespace Home\Controller;
use Think\Controller;
class LogController extends CommonController {
	public function index(){
        $this->redirect('Asset/log');
    }
	
	private function getCondition(){
		$condition = array();
		if($_POST['sType']){
			$condition['type'] = $_POST['sType'];
		}
		if($_POST['sCreateDateS']){
			if($_POST['sCreateDateE']){
				$condition['create_date'] = array(array('gt',$_POST['sCreateDateS']),array('lt',$_POST['sCreateDateE']));
			}else{
				$condition['create_date'] = array(array('gt',$_POST['sCreateDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		return $condition;
	}
	
	public function getLogListData(){
		$condition = $this->getCondition();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$log = M('Log');
		$logList = $log->where($condition)->order('create_date desc')->page($page.','.$rows)->select();
		$logListData = array();
		foreach($logList as $index=>$data){
			switch ($data['type'])
			{
			case 1:
				$data['type'] = '配置';
				break;  
			case 2:
				$data['type'] = '资产';
				break;
			case 3:
				$data['type'] = '人员';
				break;
			default:
				$data['type'] = '未知';
			}
			array_push($logListData,$data); 
		}
		$logCount = $log->where($condition)->count();
		$logListData = array('total'=>$logCount,'rows'=>$logListData);
		$this->ajaxReturn($logListData);
    }
}