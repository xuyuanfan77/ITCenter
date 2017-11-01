<?php
namespace Home\Controller;
use Think\Controller;
class LogController extends Controller {
	public function getUserData(){
		$log = M('Log');
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

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
		
		$logList = $log->where($condition)->page($page.','.$rows)->select();
		$logArray = array();
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
			array_push($logArray,$data); 
		}
		
		$logCount = $log->where($condition)->count();
		$logArray = array('total'=>$logCount,'rows'=>$logArray);
		$logArray = json_encode($logArray);
		$logArray = json_decode($logArray);
		$this->ajaxReturn($logArray);
    }
}