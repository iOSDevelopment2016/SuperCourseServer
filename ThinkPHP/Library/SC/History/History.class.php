<?php
import('SC.Common.Constants');

class History{
	private $result;
	function __construct($param){
		$this->stuid = $param['stuid'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg =>"",
		Constants::KEY_data =>array()
		);
	}
	public function run(){
		$record=M('sc_stu_lesrecord');
		$condition['stu_id']=$this->stuid;
		$recorddata=$record->where($condition)->select();
		//dump($recorddata);
		if($recorddata!==null){
			$this->result[Constants::KEY_status]=Constants::KEY_OK;
			$this->result[Constants::KEY_data]['har_des']=$recorddata;
		}else{
			$this->result[Constants::KEY_status]=constants::KEY_FAIL;
			$this->result[Constants::KEY_msg]='登陆后查看历史记录';
		}
		echo json_encode($this->result,JSON_UNESCAPED_UNICODE);
	}


}
