<?php
import('SC.Common.Constants');

class GetStudentPlayLog{
		private $result;
		function __construct($param){
			$this->student_id = $param['stu_id'];
			$this->student_password = $param['stu_pwd'];
			$this->result = array(
				Constants::KEY_status =>"",
				Constants::KEY_msg =>"",
				// Constants::KEY_data =>array()
				);
	}
		public function run(){
			

			$t_play_log=M('sc_stu_lesrecord');
			$cond["stu_id"]=$this->student_id;
			// $cond["num"]=1;
			$max_num=$t_play_log->where($cond)->max('num'); 
			$cond["num"]=$max_num;
			$data_play_log=$t_play_log->where($cond)->select(); 
			//dump($maxnum);
			// exit();

			if($data_play_log!==false){
				$this->result[Constants::KEY_status]=Constants::KEY_OK;
				$this->result[Constants::KEY_data]=$data_play_log[0];
			}else{
				//如果查询出错，find方法返回false
			   $this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			   $this->result[Constants::KEY_msg]='错误代码：201503131248。错误信息：请求登录过程中查询数据库出错。';
			}
			//dump($result_les_sections);
			//echo json_encode($result_les_sections,JSON_UNESCAPED_SLASHES);
			echo json_encode($this->result,JSON_UNESCAPED_SLASHES);
		
		}
}
/*
			
*/


// select max(num) from sc_stu_lesrecode where stu_id = "$stu_id"
			// select * from ... where num = max(num) and stu_id=...