<?php
namespace Home\Controller;
use Think\Controller;
class AllocationController extends Controller {
	public function getAllocatinData(){
		$option = D('option');
		$optionList = $option->select();
		$optionArray = array();
		foreach($optionList as $index=>$data){
			$optionArray[$data['id']] = $data;
		}

		$allocation = D('AllocationView');
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$condition = array();
		if($_POST['sID']){
			$condition['asset_id'] = $_POST['sID'];
		}
		if($_POST['sType']){
			$condition['type'] = $_POST['sType'];
		}
		if($_POST['sBrand']){
			$condition['name'] = $_POST['sBrand'];
		}
		if($_POST['sModel']){
			$condition['name'] = $_POST['sModel'];
		}
		if($_POST['sNumber']){
			$condition['name'] = $_POST['sNumber'];
		}
		if($_POST['sNetWork']){
			$condition['name'] = $_POST['sNetWork'];
		}
		if($_POST['sSource']){
			$condition['name'] = $_POST['sSource'];
			
		}
		if($_POST['sPurchaseDateS']){
			if($_POST['sPurchaseDateE']){
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',$_POST['sPurchaseDateE']));
			}else{
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		if($_POST['sUseDateS']){
			if($_POST['sPurchaseDateE']){
				$condition['use_date'] = array(array('gt',$_POST['sUseDateS']),array('lt',$_POST['sUseDateE']));
			}else{
				$condition['use_date'] = array(array('gt',$_POST['sUseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		if($_POST['sName']){
			$condition['name'] = $_POST['sName'];
		}
		if($_POST['sDepartment']){
			$condition['department'] = $_POST['sDepartment'];
		}
		if($_POST['sState']){
			$condition['state'] = $_POST['sState'];
		}
		
		$allocationList = $allocation->where($condition)->page($page.','.$rows)->select();
		$allocationArray = array();
		foreach($allocationList as $index=>$data){
			$data['type'] = $optionArray[$data['type']]['option_name'];
			$data['brand'] = $optionArray[$data['brand']]['option_name'];
			$data['network'] = $optionArray[$data['network']]['option_name'];
			$data['source'] = $optionArray[$data['source']]['option_name'];
			$data['state'] = $optionArray[$data['state']]['option_name'];
			$data['department'] = $optionArray[$data['department']]['option_name'];
			$data['job'] = $optionArray[$data['job']]['option_name'];
			array_push($allocationArray,$data); 
		}
		
		$allocationArray = json_encode($allocationArray);
		$allocationArray = json_decode($allocationArray);
		$this->ajaxReturn($allocationArray);
    }
	
	public function getOptionData($type){
		$option = M("option");
		$condition['type'] = $type;
		$optionList = $option->where($condition)->field('id,option_name')->select();
		$this->ajaxReturn($optionList);
	}
	
	public function getIdData(){
		$asset = M("asset");
		$idList = $asset->field('id')->select();
		$this->ajaxReturn($idList);
	}
	
	public function getNameData(){
		$user = M("user");
		$nameList = $user->field('id,name')->select();
		$this->ajaxReturn($nameList);
	}
	
	public function getAssetData(){
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
	
	public function getUserData(){
		$user = M("User");
		$condition['name'] = $_POST['name'];
		$userData = $user->where($condition)->find();
		if($userData){
			$result = json_encode(array('success'=>true,'data'=>$userData));
		}else{
			$result = json_encode(array('errorMsg'=>'数据不存在！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function allocationEdit(){
		$allocation = D("AllocationView");
		$condition['id'] = $_POST['id'];
		$allocationData = $allocation->where($condition)->find();
		if($allocationData){
			$result = json_encode(array('success'=>true,'data'=>$allocationData));
		}else{
			$result = json_encode(array('errorMsg'=>'数据不存在！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
    }
	
	public function allocationDestroy(){
		$allocation = D('AllocationView');
		$condition['id'] = $_POST['id'];
		$allocationData = $allocation->where($condition)->find();
		$log = M("log");
		$data['type'] = 1;
		$data['text'] = '解除（' . $allocationData['name'] . '）对资源（编号：' . $allocationData['asset_id'] . '）的占用';
		$data['create_date'] = date("Y-m-d H:i:s",time());
		$log->add($data);
		
		$allocation = M("allocation");
		$condition['id'] = $_POST['id'];
		$allocation->where($condition)->delete();

		$result = json_encode(array('success'=>true));
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function allocationSave(){
		$allocation = M("allocation");
		$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		if($_POST['aOperation']=='add'){
			$allocationData['asset_id'] = $_POST['aAssetID'];
			$allocationData['user_id'] = $_POST['aUserID'];
			$allocationData['use_date'] = $_POST['aUseDate'];
			$allocationData['remark'] = $_POST['aRemark'];
			$allocationData['create_date'] = date("Y-m-d H:i:s",time()); 
			$allocation->add($allocationData);
			$result = json_encode(array('success'=>true,'data'=>$allocationData));
		}elseif($_POST['aOperation']=='edit'){
			$allocationData['id'] = $_POST['aID'];
			$allocationData['asset_id'] = $_POST['aAssetID'];
			$allocationData['user_id'] = $_POST['aUserID'];
			$allocationData['use_date'] = $_POST['aUseDate'];
			$allocationData['remark'] = $_POST['aRemark'];
			$allocationData['create_date'] = date("Y-m-d H:i:s",time());
			$allocation->save($allocationData);
			$result = json_encode(array('success'=>true));
		}else{
			$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
    }
}