<?php
namespace Home\Controller;
use Think\Controller;
class AssetController extends Controller {
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
		
		$assetList = $asset->where($condition)->order('purchase_date')->page($page.','.$rows)->select();
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
		$asset = M("Asset");
		$condition['id'] = $_POST['id'];
		
		$asset->where($condition)->delete();

		$result = json_encode(array('success'=>true));
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
}