<?php
import('SC.Common.Constants');

class Login{
	private $user_phone ;
	private $user_password ;
	private $result;

	function __construct($param){
		$this->user_phone = $param['phone'];
		$this->user_password = $param['password'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg =>"",
		Constants::KEY_data =>array()
		);
	}
	public function run(){
		$User=M('sc_stu_info');
		$condition ['phone'] = $this->user_phone;
		$data=$User->where($condition)->find();
		if($data!==false){

			$this->result[Constants::KEY_status]=Constants::KEY_OK;
			if($data!==null){
				if($data['password']!==$this->user_password){
					// var_dump($data['password']);
					$this->result[Constants::KEY_data]['LoginState']=constants::KEY_FAIL;
					$this->result[Constants::KEY_msg]='登录失败，密码不正确……';
				}else{
					$this->result[Constants::KEY_data]['LoginSucceed']=constants::KEY_OK;
					$this->result[Constants::KEY_data]['stu_id']=$data['stu_id'];
				}
			}else{
				$this->result[Constants::KEY_data]['LoginState']=constants::KEY_FAIL;
				$this->result[Constants::KEY_msg]='登录失败，账号不存在……';//dddddd
			}
		}else{
			//如果查询出错，find方法返回false
			$this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			$this->result[Constants::KEY_msg]='错误代码：201503131248。错误信息：请求登录过程中查询数据库出错。';
		}
		echo json_encode($this->result);

	}


}