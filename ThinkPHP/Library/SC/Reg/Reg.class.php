<?php
import('SC.Common.Constants');

class Reg{
	private $user_phone ;
	private $user_password ;
	private $result;
	//private $UUID;

	function uuid($prefix = ''){  
    $chars = md5(uniqid(mt_rand(), true));  
    $uuid  = substr($chars,0,8) . '-';  
    $uuid .= substr($chars,8,4) . '-';  
    $uuid .= substr($chars,12,4) . '-';  
    $uuid .= substr($chars,16,4) . '-';  
    $uuid .= substr($chars,20,12);  
    return $prefix . $uuid;  
  	}
	function __construct($param){
		$this->user_phone = $param['phone'];
		$this->user_password = md5('0000'.'IOSSC');
		$this->user_stu_id=$this->uuid();
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
					$this->result[Constants::KEY_data]['RegState']=constants::KEY_FAIL;
					$this->result[Constants::KEY_msg]='注册失败，用户名已存在……';
				}else{
					$info['phone'] = $this->user_phone ;
					$info['password'] = $this->user_password;
					$info['stu_id'] =$this->user_stu_id;
					$User->add($info);
					$this->result[Constants::KEY_data]['RegSucceed']=constants::KEY_OK;
					$this->result[Constants::KEY_msg]='';
				}
		}else{
			//如果查询出错，find方法返回false
			$this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			$this->result[Constants::KEY_msg]='错误代码：201503131248。错误信息：请求登录过程中查询数据库出错。';
		}
		echo json_encode($this->result);
	}


}