<?php
import('SC.Common.Constants');

class LoadVideoInfo{
	private $stu_id;
	private $stu_pwd;
	private $lesson_id;
	private $result;

	function __construct($param){
		$this->stu_id = $param['stu_id'];
		$this->stu_pwd = $param['stu_pwd'];
		$this->lesson_id = $param['lesson_id'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg =>"",
		Constants::KEY_data =>array()
		);
	}
	private function getMaxNum(){
		$num = 0;
		$sc_stu_lesrecord = M('sc_stu_lesrecord');
		$cond['stu_id']=$this->stu_id;
		$cond['les_id']=$this->lesson_id;
		$maxNum=$sc_stu_lesrecord->where($cond)->max('num');
		return $maxNum;
	}	
	public function run(){
			if($this->validUser()){
				// 查询课程信息基本表
				$sc_les_baseinfo = M('sc_les_baseinfo');
				$cond_les_baseInfo['les_id'] = $this->lesson_id;
				$resultData_baseInfo = $sc_les_baseinfo->where($cond_les_baseInfo)->select();
				// 查询热点列表
				$sc_les_hotpoint = M('sc_les_hotpoint');
				$cond_les_hotpoint[les_id] = $this->lesson_id;
				$resultData_hotpoint = $sc_les_hotpoint->where($cond_les_hotpoint)->select();
				$resultData_baseInfo[0]['videoLinks'] = $resultData_hotpoint;
				// 查询子标题
				$sc_les_subtitle = M('sc_les_subtitle');
				$cond_les_subtitle[les_id] = $this->lesson_id;
				$resultData_subtitle = $sc_les_subtitle->where($cond_les_subtitle)->select();
				$resultData_baseInfo[0]['videoSubTitles'] = $resultData_subtitle;
				//查询用户自定义子标题
				$sc_stu_lessubtitle = M('sc_stu_lessubtitle');
				$cond_stu_lessubtitle[les_id] = $this->lesson_id;
				$cond_stu_lessubtitle[stu_id] = $this->stu_id;
				$resultData_lessubtitle = $sc_stu_lessubtitle->where($cond_stu_lessubtitle)->select();
				$resultData_baseInfo[0]['studentSubTitle'] = $resultData_lessubtitle;
				//查询视频开始时间
				$num = $this->getMaxNum();
				$sc_stu_lesrecord = M('sc_stu_lesrecord');
				$cond_stu_lesbegintime[les_id] = $this->lesson_id;
				$cond_stu_lesbegintime[stu_id] = $this->stu_id;
				$cond_stu_lesbegintime[num] = $num;
				$resultData_lesbegintime = $sc_stu_lesrecord->where($cond_stu_lesbegintime)->select();
				// $arr = $resultData_lesbegintime[0];

				$resultData_baseInfo[0]['oversty_time'] = $resultData_lesbegintime;
				// dump($resultData_baseInfo['ovesity_time']);
				// 返回数据	
				$this->result[Constants::KEY_status]=Constants::KEY_OK;
				$this->result[Constants::KEY_data]['videoInfo']=$resultData_baseInfo;
				// $this->result[Constants::KEY_data]['videoInfo']=$this->lesson_id;
			}else
			{
				//如果身份认证出错，返回false
			   $this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			   $this->result[Constants::KEY_msg]='错误代码：201602011458。获得视频文件信息时，身份认证错误。';
			}

			echo json_encode($this->result,JSON_UNESCAPED_SLASHES);


			// $t_groups=M('sc_les_grouping');
			// $t_sections=M('sc_les_sections');
			// $t_lessons=M('sc_les_baseinfo');

			// $data_groups=$t_groups->select(); //获得分组列表
			// if($datagrouping!==false){
			// 	for ($i=0; $i < count($data_groups); $i++) { 
			// 		$condition_sections['lesgrouping_id']=$data_groups[$i]['lesgrouping_id'];
			// 		$data_sections=$t_sections->where($condition_sections)->select();

   //                  for ($j=0; $j < count($data_sections); $j++) { 
   //                    	$condition_lessons['lessections_id']=$data_sections[$j]['lessections_id'];
   //                    	//第三级数据
   //                    	$data_lessions=$t_lessons->where($condition_lessons)->select();
   //                      $data_sections[$j]['lesarr']=$data_lessions;
   //                      //var_dump( $result_les_sections);
   //                   }
   //                   $data_groups[$i]['sec_arr']=$data_sections;
			// 	}
			// }else{
			// 	//如果查询出错，find方法返回false
			//    $this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			//    $this->result[Constants::KEY_msg]='错误代码：201503131248。错误信息：请求登录过程中查询数据库出错。';
			// }
			// $this->result[Constants::KEY_data]['categoryArr']=$data_groups;
			//dump($result_les_sections);
			//echo json_encode($result_les_sections,JSON_UNESCAPED_SLASHES);
			// echo json_encode($this->result,JSON_UNESCAPED_SLASHES);
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
				// var_dump($password);exit();
				if($password == $this->stu_pwd){
					$valid = true;
				}
			}
		}
		return $valid;
	}
}