<?php
import('SC.Common.Constants');

class Search{
	private $smessage ;
	private $result;

	function __construct($param){
		$this->search_info = $param['searchinfo'];
		$this->stuid=$param['stuid'];
		$this->result = array(
		Constants::KEY_status =>"",
		Constants::KEY_msg =>"",
		Constants::KEY_data =>array()
		);
	}
	public function run(){
		// if($this->stuid=='00000000'){
		// 	echo "您是游客，不能访问搜索功能";
		// 	exit;
		// }
		$table1=M('sc_les_baseinfo');
		$table2=M('sc_les_hotpoint');
		$table3=M('sc_les_subtitle');
		$table5=M('sc_stu_lessubtitle');
		$table6=M('sc_les_sections');
		//dump($this->search_info);
		$searchs="%".$this->search_info."%";
		$condition1['les_name']=array('like',$searchs);
		$condition2['hot_title']=array('like',$searchs);
		$condition3['subtitle']=array('like',$searchs);
		//dump($this->stuid);
		$condition5['stu_id']=$this->stuid;
		$condition6['subtitle']=array('like',$searchs);
		$data1=$table1->where($condition1)->select();
		//dump($data1);
		$data2=$table2->where($condition2)->select();
		$data3=$table3->where($condition3)->select();
		//dump($data3);
		//$data5=$table5->where("stu_id=$this->stuid AND subtitle like "."'"."$searchs"."'"." ")->select();
		$data5=$table5->where($condition6)->where($condition5)->select();
		//var_dump($condition6);
		$les_id1=array();
		//dump($les_id1);
		for ($i=0; $i < count($data1); $i++) { 
			$les_id=$data1[$i]['les_id'];
			//$tump=$les_id['les_id'];
			//dump($les_id);
			if($les_id==null){
				//echo "不存在";
			}else{
				array_push($les_id1, $les_id);	
			}	
		}
		//dump($les_id1);
		for ($i=0; $i < count($data2); $i++) { 
			$les_id=$data2[$i]['les_id'];
			//$tump=$les_id['les_id'];
			if($les_id==null){
				//echo "不存在";
			}else{
				array_push($les_id1, $les_id);	
			}	
		}
		//dump($les_id1);
		for ($i=0; $i < count($data3); $i++) { 
			$les_id=$data3[$i]['les_id'];
			//$tump=$les_id['les_id'];
			if($les_id==null){
				//echo "不存在";
			}else{
				array_push($les_id1, $les_id);	
			}	
		}
		//dump($les_id1);
		for ($i=0; $i < count($data5); $i++) { 
			$les_id=$data5[$i]['les_id'];
			//$tump=$les_id['les_id'];
			if($les_id==null){
				//echo "不存在";
			}else{
				array_push($les_id1, $les_id);	
			}	
		}
		//dump($les_id1);
		$les_id2=array_unique($les_id1);//去掉重复数据；
		//dump($les_id2);
		//echo count($les_id1);
		$result_arr0= array();
     	//var_dump(count($les_id1));
     	for ($i=0; $i <count($les_id1) ; $i++) {
    		$condition4['les_id']=$les_id2[$i];
   			$data4=$table1->where($condition4)->find();
   			//echo "<pre>";
   			//dump($data4); 
   			for ($j=0; $j < count($data4); $j++) { 
   				$condition5['lessections_id']=$data4['lessections_id'];
   				$data5=$table6->where($condition5)->select();
   				if($data5[$j]['lesgrouping_id']=='0000'){
   					array_push($result_arr0, $data4);
   				}else{
   					//echo null;
   				}
   				//echo "<pre>";
   			    // dump($data4);  				
   			}
     	}
     	 //dump($result_arr0);
     	 $result_arr1= array();
     	//var_dump(count($les_id1));
     	for ($i=0; $i <count($les_id1) ; $i++) {
    		$condition4['les_id']=$les_id2[$i];
   			$data4=$table1->where($condition4)->find();
   			//dump($data4);
   			for ($j=0; $j < count($data4); $j++) { 
   				$condition5['lessections_id']=$data4['lessections_id'];
   				$data5=$table6->where($condition5)->select();
   				if($data5[$j]['lesgrouping_id']=='0001'){
   					array_push($result_arr1, $data4);
   				}else{
   					//echo null;
   				}
   				//echo "<pre>";
   			    //dump($data5);  				
   			}
     	}
     	$result_arr[0]['grouping_id']='0000';
     	$result_arr[0]['lesson_list']=$result_arr0;
     	$result_arr[1]['grouping_id']='0001';
     	$result_arr[1]['lesson_list']=$result_arr1;
    	//dump($result_arr);
		if($result_arr!==false){
			$this->result[Constants::KEY_status]=Constants::KEY_OK;
			if($result_arr!==null){	
				

			    $this->result[Constants::KEY_data]['SearchResult']=$result_arr;
		    }
			else{
				$this->result[Constants::KEY_status]=constants::KEY_FAIL;
				$this->result[Constants::KEY_msg]='查询的内容不存在';//dddddd
			}
		}else{
			//如果查询出错，find方法返回false
			$this->result[Constants::KEY_status]=Constants::KEY_FAIL;
			$this->result[Constants::KEY_msg]='错误代码：201503131248。错误信息：请求查询数据库出错。';
		}
    	echo json_encode($this->result,JSON_UNESCAPED_UNICODE);

		
	}


}