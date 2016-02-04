<?php
import('SC.Common.Constants');

class VideoList{
		private $result;
		function __construct($param){
		$this->stuid=$param['stuid'];
		$this->result = array(
		Constants::KEY_data =>array()
		);
	}
		public function run(){
			$t_groups=M('sc_les_grouping');
			$t_sections=M('sc_les_sections');
			$t_lessons=M('sc_les_baseinfo');
			$tump1=$this->permissionid();
			dump($tump1);
			$data_groups=$t_groups->select(); //获得分组列表
			if($datagrouping!==false){
				for ($i=0; $i < count($data_groups); $i++) { 
					$condition_sections['lesgrouping_id']=$data_groups[$i]['lesgrouping_id'];
					$data_sections=$t_sections->where($condition_sections)->select();

                    for ($j=0; $j < count($data_sections); $j++) { 
                      	$condition_lessons['lessections_id']=$data_sections[$j]['lessections_id'];
                      	//第三级数据
                      	$data_lessions=$t_lessons->where($condition_lessons)->select();                       
                        for ($k = 0; $k<count($data_lessions) ;$k++){
                        	$data_lessions[$k]["permission"] = '否';
                        	for ($g=0; $g <count($tump1) ; $g++) { 
                        		if($data_lessions[$k]['les_id']==$tump1[$g]){
                        			dump($data_lessions[$k]['les_id']);
                        			dump($tump1[$g]);
                        			$data_lessions[$k]["permission"] = '是';
                        		}
                        		elseif ($tump1[$g]=="*") {
                        			$data_lessions[$k]["permission"] = '是';
                        		}
                        	}
                        	
                        }
                        dump($data_lessions);
                        $data_sections[$j]['lesarr']=$data_lessions;
                     }
                     $data_groups[$i]['sec_arr']=$data_sections;
				}
			}else{
				//如果查询出错，find方法返回false
			   $this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			   $this->result[Constants::KEY_msg]='错误代码：201503131248。错误信息：请求登录过程中查询数据库出错。';
			}
			$this->result[Constants::KEY_data]['categoryArr']=$data_groups;
			//dump($result_les_sections);
			//echo json_encode($result_les_sections,JSON_UNESCAPED_SLASHES);
			echo json_encode($this->result,JSON_UNESCAPED_SLASHES);
		}
		public function permissionid(){
			$sc_stu_info=M('sc_stu_info');
			$sc_stu_grouping=M('sc_stu_grouping');
			$sc_sys_stulesauthgrouping=M('sc_sys_stulesauthgrouping');
			$condition_stuid['stu_id']=$this->stuid;
			$datastuid=$sc_stu_info->where($condition_stuid)->find();
			$condition_grouping['stugrouping_id']=$datastuid['stugrouping_id'];
			$datagrouping=$sc_stu_grouping->where($condition_grouping)->find();
			$condition_permissionid['lesauth_groupingid']=$datagrouping['lesauth_groupingid'];
			$datapermission=$sc_sys_stulesauthgrouping->where($condition_permissionid)->select();
			$result_arr=array();
			for ($p=0; $p < count($datapermission); $p++) { 
				$les_authid=$datapermission[$p]['authles_id'];
				array_push($result_arr, $les_authid);
			}
			// $result_authid=$this->$datapermission['authles_id'];
			return $result_arr;
		}
}
/*
			
*/