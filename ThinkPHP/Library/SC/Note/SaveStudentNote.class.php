<?php
class SaveStudentNote{
	private $student_id ;
	private $student_password ;
	private $save;
	private $result;

	function __construct($param){
		$this->student_id = $param['student_id'];
		$this->student_password = $param['student_password'];
		$this->save = $param['save'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg =>"",
		Constants::KEY_data =>array()
		);
	}
	public function run(){
		$s_note=M('sc_stu_note');
	    $condition ['stu_id'] = $this->student_id;
	    $is_exits = $s_note->where($condition)->find();
	    if ($is_exits !== null) {
	    	//更新
	    	$data['note']=$this->save;
	    	$s_note->where($condition)->save($data);
	    }else{
	    	//写入
	    	$data['note']=$this->save;
	    	$data['stu_id']=$this->student_id;
	    	$s_note->add($data);
	    }
		// $data_note=$s_note->where($condition)->add($data);
		// if($this->save==null){
		// 	$this->result[Constants::KEY_status]=Constants::KEY_FAIL;
		// }else{
		// 	$this->result[Constants::KEY_status]=Constants::KEY_OK;
		// }
	}
}