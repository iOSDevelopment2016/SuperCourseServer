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
	public function LoadVideoInfo($param){
		import('SC.VideoInfo.LoadVideoInfo');
		$videoInfo=new LoadVideoInfo($param);
		$result=$videoInfo->run();
		echo $result;
	}
	public function AddStudentSubtitle($param){
		import('SC.VideoInfo.AddStudentSubtitle');
		$addSubtitle=new AddStudentSubtitle($param);
		$result=$addSubtitle->run();
		echo $result;
	}
	public function AddStudentStopTime($param){
		import('SC.VideoInfo.AddStudentStopTime');
		$AddStopTime=new AddStudentStopTime($param);
		$result=$AddStopTime->run();
		echo $result;
	}
	public function DeleteStudentSubtitle($param){
		import('SC.VideoInfo.DeleteStudentSubtitle');
		$DeleteSubTitle=new DeleteStudentSubtitle($param);
		$result=$DeleteSubTitle->run();
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

	public function GetStudentNote($param){
		import('SC.Note.GetStudentNote');
		$getNote=new GetStudentNote($param);
		$result=$getNote->run();
		echo $result;
	}
	public function SaveStudentNote($param){
		//echo "hello";
		import('SC.Note.SaveStudentNote');
		$saveNote=new SaveStudentNote($param);
		$result=$saveNote->run();
		echo $result;
	}
	// public function VideoHistory($param){
	// 	//echo "hello";
	// 	import('SC.VideoHistory.VideoHistory');
	// 	$VideoHistory=new SaveStudentNote($param);
	// 	$result=$saveNote->run();
	// 	echo $result;
	// }
	public function History($param){
		//echo "hello";
		import('SC.History.History');
		$history=new History($param);
		$result=$history->run();
		echo $result;
	}

}
