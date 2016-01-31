<?php
import('SC.Common.Constants');

class VideoList{
		private $result;
		function __construct($param){
		$this->result = array(
		Constants::KEY_data =>array()
		);
	}
		public function run(){
			$sc_les_grouping=M('sc_les_grouping');
			$sc_les_sections=M('sc_les_sections');
			$sc_les_baseinfo=M('sc_les_baseinfo');
			$datagrouping=$sc_les_grouping->select();
			//var_dump($result_les_grouping);
			$result_les_sections=array();
			$result_les_baseinfo=array();
			if($datagrouping!==false){
				for ($i=0; $i < count($datagrouping); $i++) { 
					$result_les_sections[$i]['lesgrouping_id']=$datagrouping[$i]['lesgrouping_id'];
					$result_les_sections[$i]['order_num']=$datagrouping[$i]['order_num'];
					$result_les_sections[$i]['lesgrouping_name']=$datagrouping[$i]['lesgrouping_name'];
					$condition_les_sections['lesgrouping_id']=$datagrouping[$i]['lesgrouping_id'];
					$result_temp_sections=$sc_les_sections->where($condition_les_sections)->select();
                    $result_les_sections[$i]['lesarr']=$result_temp_sections;
                    //var_dump(count($datagrouping));
					//var_dump(count($result_temp_sections));
                    for ($j=0; $j < count($result_temp_sections); $j++) { 
                        //echo $result_temp_sections[$j]['lessections_id']."<br/>";
                      	$result_les_baseinfo[$j]['lessections_id']=$result_temp_sections[$j]['lessections_id'];
                      	//echo $result_temp_sections[$i]['lessections_id']."<br/>";
                      	//var_dump($result_les_baseinfo);
                    	$result_les_baseinfo[$j]['order_num']=$result_temp_sections[$j]['order_num'];
                    	//echo $result_temp_sections[$i]['order_num']."<br/>";
                      	//var_dump($result_les_baseinfo);
                    	$result_les_baseinfo[$j]['lessections_name']=$result_temp_sections[$j]['lessections_name'];
                    	//echo $result_temp_sections[$i]['lessections_name']."<br/>";
                      	//var_dump($result_les_baseinfo);
                      	$condition_les_baseinfo['lessections_id']=$result_temp_sections[$j]['lessections_id'];
                      	//第三级数据
                      	$result_temp_baseinfo=$sc_les_baseinfo->where($condition_les_baseinfo)->select();
                        //dump($result_temp_baseinfo);
                        $result_les_sections[$i][$j]['lesarr']=$result_temp_baseinfo;
                        //var_dump( $result_les_sections);
                     }

				}
			}else{
				//如果查询出错，find方法返回false
			   $this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			   $this->result[Constants::KEY_msg]='错误代码：201503131248。错误信息：请求登录过程中查询数据库出错。';
			}
			$this->result[Constants::KEY_data]['Lesarr']=$result_les_sections;
			//dump($result_les_sections);
			//echo json_encode($result_les_sections,JSON_UNESCAPED_SLASHES);
			echo json_encode($this->result,JSON_UNESCAPED_SLASHES);
		}
}
/*
			
*/