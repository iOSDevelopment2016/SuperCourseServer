<?php
import('SC.Common.Constants');

class Getintroduction{
	private $result;
	function __construct($param){
		$this->les_id = $param['les_id'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg =>"",
		Constants::KEY_data =>array()
		);
	}
	public function run(){
		$exinfo=M('sc_les_exinfo');
		$prek_id=M('sc_les_preknowledge');
		$prek_des=M('sc_pre_knowledge');
		$eh_id=M('sc_les_eh');
		$condition['les_id']=$this->les_id;
		$exinfodata=$exinfo->where($condition)->select();
		$prek_iddata=$prek_id->where($condition)->select();
		//dump($prek_iddata);
		$pregroupidarr=array();
		for ($i=0; $i < count($prek_iddata); $i++) { 
			$pregroupid=$prek_iddata[$i]['preknowledge_id'];
			array_push($pregroupidarr, $pregroupid);
		}
		//dump($pregroupidarr);
		$result_des=array();
		for ($i=0; $i < count($pregroupidarr); $i++) { 
			$condition1['preknowledge_id']=$pregroupidarr[$i];
			$prek_desdata=$prek_des->where($condition1)->select();
			array_push($result_des, $prek_desdata);
		}
		//dump($result_des);
		$ehdata=$eh_id->where($condition)->select();
		//dump($ehdata);
		$alldata=array();
		//array_push($alldata, $exinfodata,$result_des,$ehdata);
		//dump($alldata);
		if($exinfodata!==null){
			$this->result[Constants::KEY_status]=Constants::KEY_OK;
			$this->result[Constants::KEY_data]['har_des']=$exinfodata;
			$this->result[Constants::KEY_data]['knowledge']=$result_des;
			$this->result[Constants::KEY_data]['willknow']=$ehdata;
		}else{
			$this->result[Constants::KEY_status]=constants::KEY_FAIL;
			$this->result[Constants::KEY_msg]='查询的内容不存在';
		}
		echo json_encode($this->result,JSON_UNESCAPED_UNICODE);
	}


}
