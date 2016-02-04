<?php
class Api{
	/**
	 * 登录
	 * @param unknown $param
	 */
	public function Login($param){
		import('SC.User.Login');//导入相应的类库
		$userLogin=new Login($param);
		$result=$userLogin->run();
		echo $result;
	}
/*	public function List($param){
		import('SC.VideoList.VideoList');
		echo 'hello';
		//$result=run();
		//echo $result;
	}
*/
	public function Search($param){
		//echo "hello";
		import('SC.Search.Search');
		$searchInfo=new Search($param);
		$result=$searchInfo->run();
		echo $result;
	}
	public function VideoList($param){
		//echo 'hello';
		import('SC.VideoList.VideoList');
		$null=new VideoList($param);
		$result=$null->run();
		echo $result;
	}
	public function Reg($param){
		//echo 'hello';
		import('SC.Reg.Reg');
		$userReg=new Reg($param);
		$result=$userReg->run();
		echo $result;
	}
	public function Getintroduction($param){
		//echo "hello";
		 import('SC.getintroduction.getintroduction');
		 $getin=new Getintroduction($param);
		 $result=$getin->run();
		 echo $result;
	}
	public function GetStudentPlayLog($param){
		 import('SC.PlayLog.GetStudentPlayLog');
		 $student_play_log=new GetStudentPlayLog($param);
		 $result=$student_play_log->run();
		 echo $result;
	}

}