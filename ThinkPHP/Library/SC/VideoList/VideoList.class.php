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

			$data_groups=$t_groups->select(); //获得分组列表
			if($datagrouping!==false){
				for ($i=0; $i < count($data_groups); $i++) { 
					$condition_sections['lesgrouping_id']=$data_groups[$i]['lesgrouping_id'];
					$data_sections=$t_sections->where($condition_sections)->select();

                    for ($j=0; $j < count($data_sections); $j++) { 
                      	$condition_lessons['lessections_id']=$data_sections[$j]['lessections_id'];
                      	//第三级数据
                      	$data_lessions=$t_lessons->where($condition_lessons)->select();
                        $data_sections[$j]['lesarr']=$data_lessions;
                        //var_dump( $result_les_sections);
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
}
/*
			
*/