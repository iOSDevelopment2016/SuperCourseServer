<?php
namespace Home\Controller;
use Think\Controller;
import('SC.Api.Api');//导入api业务处理类
import('SC.Common.Constants');
class IndexController extends Controller {
	public function index(){
		$method=$_POST['method']==null?$_GET['method']:$_POST['method'];//请求的方法名，首字母小写
		$param=$_POST['param']==null?$_GET['param']:$_POST['param'];
		//var_dump($method);
		//var_dump($param);
		$param=json_decode($param,true);//通过 json_decode 函数将json字符串转换成array
		//var_dump($param);
		call_user_func_array(array('Api',$method),$param); //调用回调函数，并把一个数组参数作为回调函数的参数
	}
	public function index4ios(){
		$method=$_POST['method']==null?$_GET['method']:$_POST['method'];//请求的方法名，首字母小写
		$param=$_POST['param']==null?$_GET['param']:$_POST['param'];
		//var_dump($method);
		call_user_func_array(array('Api',$method),$param); //调用回调函数，并把一个数组参数作为回调函数的参数
	}
}