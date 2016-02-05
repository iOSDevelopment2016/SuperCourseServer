<?php
import('SC.Common.Constants');

class CheckPermission{
	private $stu_id;
	private $stu_pwd;
	private $lesson_id;
	private $result;

	function __construct($param){
		$this->stu_id = $param['stu_id'];
		$this->stu_pwd = $param['stu_pwd'];
		$this->lesson_id = $param['lesson_id'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg =>"",
		Constants::KEY_data =>array()
		);
	}
		
	public function run(){
			if($this->validUser()){
				// 获得学员分类内码
				$stugrouping_id = $this->getStudentTypeID();
				// 获得课程授权分类内码
				$lesauth_groupingid = $this->getPermissionTypeID($stugrouping_id);
				// 获得课程授权信息		
				$permission = $this->getPermission($lesauth_groupingid, $this->lesson_id);
				// 返回结果
				$this->result[Constants::KEY_data]=$permission;
				$this->result[Constants::KEY_status]=Constants::KEY_OK;

			
			}else
			{
				//如果身份认证出错，返回fffalse
			   $this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			   $this->result[Constants::KEY_msg]='错误代码：201602051747。获得视频授权信息时，身份认证错误。';
			}

			echo json_encode($this->result,JSON_UNESCAPED_SLASHES);


		}

	// 获得课程授权信息
	private function getPermission($lesauth_groupingid, $lesson_id){
		$permission = '否';
		$t_sc_sys_stulesauthgrouping = M('sc_sys_stulesauthgrouping');
		$cond['lesauth_groupingid']=$lesauth_groupingid;
		$cond['authles_id']=$lesson_id;
		$data = $t_sc_sys_stulesauthgrouping->where($cond)->select();
		if(count($data)>0){
			$permission='1';
		}else{
			$cond['authles_id']='*';
			$data = $t_sc_sys_stulesauthgrouping->where($cond)->select();
			if(count($data)>0){
				$permission = '是';
			}
		}
		return $permission;
	}

	// 获得课程授权分类内码
	private function getPermissionTypeID($stu_type_id){
	
		$t_sc_stu_grouping = M('sc_stu_grouping');
		$cond['stugrouping_id']=$stu_type_id;
		$data = $t_sc_stu_grouping->where($cond)->select();
		$lesauth_groupingid=$data[0]['lesauth_groupingid'];
		return $lesauth_groupingid;
	}

	// 获得学员分类内码
	private function getStudentTypeID(){
		$stugrouping_id = '0000';
		if($this->stu_id!=='UnLoginUserSession'){
			$t_sc_stu_info = M('sc_stu_info');
			$cond['stu_id']=$this->stu_id;
			//stugrouping_id
			$data = $t_sc_stu_info->where($cond)->select();
			$stugrouping_id=$data[0]['stugrouping_id'];
		}
		return $stugrouping_id;
	}

	private function validUser(){
		$valid = false;
		if($this->stu_id=='UnLoginUserSession'){
			$valid = true;
		}else{
			$sc_stu_info = M('sc_stu_info');
			$cond['stu_id'] = $this->stu_id;
			$result = $sc_stu_info->where($cond)->select();
			if( $result!== false){
				$password = $result[0]["password"];
				if($password == $this->stu_pwd){
					$valid = true;
				}
			}
		}
		return $valid;
	}
}