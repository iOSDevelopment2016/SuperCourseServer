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
	}


	public function run(){
		$recordArr = array();
		$sc_stu_lesrecord=M('sc_stu_lesrecord');
		$sc_les_baseinfo=M('sc_les_baseinfo'); 
		$condition['stu_id']=$this->stu_id;
		$allles_id=$sc_stu_lesrecord->where($condition)->distinct(true)->field('les_id')->select();

 		//获取历史信息
 		for ($i=0; $i < count($allles_id); $i++) 
 		{
 			$condition['stu_id']=$this->stu_id;
			$condition['les_id']=$allles_id[$i]['les_id'];
			$recordArr[$i]=$sc_stu_lesrecord->where($condition)->order('num desc')->limit(1)->find();
 		}

		//echo "<pre>";
 		//print_r($recordArr);
		//exit();

 		// 获取课程名称
 		for ($i=0; $i < count($allles_id); $i++) 
 		{ 
			$condition['les_id']=$allles_id[$i]['les_id'];
			$recordArr[$i]['les_name'] = $sc_les_baseinfo
 			->where($condition)
 			->getField('les_name');
 			// array_push($recordArr[$i],$less_name);
 		}

 		//echo "<pre>";
 		//print_r($recordArr);exit();

		if ($recordArr !== false) {

			if ($recordArr !== null) {
				$this->result[Constants::KEY_status]=Constants::KEY_OK;
				$this->result[Constants::KEY_data]['historyData']=$recordArr;
			}else{
				$this->result[Constants::KEY_status]=Constants::KEY_FAIL;
				$this->result[Constants::KEY_msg]='登陆后查看历史记录';
			}

		}else{
			$this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			$this->result[Constants::KEY_msg]='错误代码：201503131248。错误信息：请求登录过程中查询数据库出错。';
		}
		echo json_encode($this->result,JSON_UNESCAPED_UNICODE);
	}


}
