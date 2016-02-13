<?php
import('SC.Common.Constants');

class History{
	private $result;
	function __construct($param){
		$this->stu_id = $param['stu_id'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg 	=>"",
		Constants::KEY_data =>array()
		);
		// dump($this->stu_id);
	}
	public function run(){
		$sc_stu_lesrecord=M('sc_stu_lesrecord');
		$sc_les_baseinfo=M('sc_les_baseinfo');
		$allles_id=$sc_stu_lesrecord->distinct(true)->field('les_id')->select();
		// dump($allles_id);
 		for ($i=0; $i < count($allles_id); $i++) { 
 			$nowles_id=$allles_id[$i]['les_id'];
 			$condition['stu_id']=$this->stu_id;
			$condition['les_id']=$nowles_id;
			$recorddata[$i]=$sc_stu_lesrecord->where($condition)->order('num desc')->limit(1)->select();
 		}

		// $condition['stu_id']=$this->stuid;
		// $condition['les_id']=$nowles_id;
		// $recorddata=$sc_stu_lesrecord->where($condition)->order('num desc')->limit(1)->select();
		//dump($recorddata);
		if ($recorddata !== null) {
			for ($i=0; $i <count($recorddata) ; $i++) { 
			$condition1['les_id']=$allles_id[$i];
			// dump($condition1['les_id']);
			$data=$sc_les_baseinfo->where($condition1)->select();
			$recorddata[$i]['les_name']=$data['les_name'];

			//dump($data);
		}
		}
		
		if($recorddata!==null){
			$this->result[Constants::KEY_status]=Constants::KEY_OK;
			$this->result[Constants::KEY_data]['historyData']=$recorddata;	
		}else{
			$this->result[Constants::KEY_status]=constants::KEY_FAIL;
			$this->result[Constants::KEY_msg]='登陆后查看历史记录';
		}	

		
		echo json_encode($this->result,JSON_UNESCAPED_UNICODE);
		// dump($this->result);
	}


}
