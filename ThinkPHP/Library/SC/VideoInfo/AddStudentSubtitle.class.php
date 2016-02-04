<?php
import('SC.Common.Constants');

class AddStudentSubtitle{
	private $stu_id;
	private $stu_pwd;
	private $lesson_id;
	private $subtitle;
	private $bg_time;
	private $result;

	function __construct($param){
		$this->stu_id = $param['stu_id'];
		$this->stu_pwd = $param['stu_pwd'];
		$this->lesson_id = $param['lesson_id'];
		$this->subtitle = $param['subtitle'];
		$this->bg_time = $param['bg_time'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg =>"",
		Constants::KEY_data =>array()
		);
	}
		
	public function run(){
			if($this->validUser()){
				// 写入数据库
				$num = $this->getMaxNum();
				$newNum = $num + 1;
				// var_dump($newNum);exit();
				$t_stu_subtitle = M('sc_stu_lessubtitle');
				$info['stu_id']=$this->stu_id;
				$info['les_id']=$this->lesson_id;
				$info['subtitle']=$this->subtitle;
				$info['bg_time']=$this->bg_time;
				$info['num']=$newNum;
				
				$t_stu_subtitle->add($info);
				
				// 返回结果
				 $this->result[Constants::KEY_status]=Constants::KEY_OK;
			}else
			{
				//如果身份认证出错，返回fffalse
			   $this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			   $this->result[Constants::KEY_msg]='错误代码：201602021458。添加学员子标题时，身份认证错误。';
			}

			echo json_encode($this->result,JSON_UNESCAPED_SLASHES);


		}

	private function getMaxNum(){
		$num = 0;
		$t_stu_subtitle = M('sc_stu_lessubtitle');
		$cond['stu_id']=$this->stu_id;
		$cond['les_id']=$this->lesson_id;
		$maxNum=$t_stu_subtitle->where($cond)->max('num');
		if($maxNum>=1){
			$num=$maxNum;	
		} else {
			// var_dump($maxNum); exit();
		}
		return $num;
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