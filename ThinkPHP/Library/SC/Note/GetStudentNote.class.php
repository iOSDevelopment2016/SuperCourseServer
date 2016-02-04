<?php
import('SC.Common.Constants');

class GetStudentNote{
	private $student_id ;
	private $student_password ;
	private $result;

	function __construct($param){
		$this->student_id = $param['student_id'];
		$this->student_password = $param['student_password'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg =>"",
		Constants::KEY_data =>array()
		);
	}
   //http://localhost/SV/?method=Login&param={"data":{"phone":"13800001","password":"1111"}}
	public function run(){
		//echo "use RUN()";
		$t_note=M('sc_stu_note');
		$condition ['stu_id'] = $this->student_id;
		$data_note=$t_note->where($condition)->find();
		if($data_note!==false){

			$this->result[Constants::KEY_status]=Constants::KEY_OK;
			if($data_note!==null){
				// var_dump($data_note);exit();
				$this->result[Constants::KEY_data]=$data_note['note'];
			
			}else{
				$this->result[Constants::KEY_data]='';
			}
		}else{
			//如果查询出错，find方法返回false
			$this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			$this->result[Constants::KEY_msg]='错误代码：201602021236。错误信息：请求学员备注时查询数据库出错。';
		}
		echo json_encode($this->result);

	}


}