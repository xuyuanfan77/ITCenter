<?php
namespace Home\Model;
use Think\Model\ViewModel;
class AllocationViewModel extends ViewModel {
	public $viewFields = array(
		'asset'=>array(
			'type',
			'brand',
			'model',
			'number',
			'network',
			'source',
			'purchase_date',
			'remark'=>'asset_remark',
			'state',
			'create_date'=>'asset_create_date',
			'_type'=>'RIGHT',
		),
		'allocation'=>array(
			'id',
			'asset_id',
			'user_id',
			'use_date',
			'remark'=>'allocation_remark',
			'create_date'=>'allocation_create_date',
			'_on'=>'allocation.asset_id=asset.id',
			'_type'=>'LEFT',
		),
		'user'=>array(
			'name',
			'department',
			'job',
			'office_phone',
			'mobile_phone',
			'_on'=>'allocation.user_id=user.id',
			'create_date'=>'user_create_date',
		),
	);
 }