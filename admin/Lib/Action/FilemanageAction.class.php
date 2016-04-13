<?php
class FilemanageAction extends CommonAction {
	  //返回当前目录下所有文件列表
	public function getFiles($dir = ''){
	
			$arrReturn = array();
			if(empty($dir))
			{
				$dir = $this->dir;
			}
			//处理文件夹信息
			if ($handle = opendir($dir)) 
			{
			    while (false !== ($file = readdir($handle))) 
			    {
			        if ($file != "." && $file != "..") 
			        {
			            if(is_dir($dir.'/'.$file))
			            {
			            	$arrReturn['dirs'][] = $file;
			            }
			            else
			            {
							$arrReturn['files'][] = $file;
			            }
			        }
			    }
			    closedir($handle);
			}
			return $arrReturn;
		
		}
	public function u_g($path){  
    	return  iconv("UTF-8", "GB2312", $path);  
	}  
	public function g_u($path){  
    	return  iconv("GB2312", "UTF-8", $path);  
	}
	//创建目录
	public function MakeDir($dirName, $dir = '', $mod = 0777)
	{
		if(empty($dirName))
		{
			return false;
		}
		if(empty($dir))
		{
			$dir = $this->dir;
		}
		return is_dir($dir.'/'.$dirName) or ($this->MakeDir(dirname($dirName),$dir, $mod) and @mkdir($dir.'/'.$dirName, $mod));
	}
	// 框架首页 CommonAction
	public function index(){

		$getRand = mt_rand();
		$this->assign('getRand',$getRand);
		
		if(!empty($_POST['path'])) {
			$path = $_POST['path'];
			$path = ereg_replace("^[\/\\\.]+","",$path);
			//$path = './' . $path;
			$path = iconv('utf-8','gb2312',ereg_replace("[\/\\]+","/",$path));
			//chdir($path);

		}else{
				$path = realpath("..");//上级目录
		}
		$this->assign('path',$path);
		
		if(!empty($_POST['name'])) {
			$name = $_POST['name'];
			
		}else{
				$name = "";//上级目录
		}
		$this->assign('name',$name);
		
		$list = $this->getFiles($path);
		
		$f = $list['files'];
		$d = $list['dirs'];
		
		if (($f) && ($d)) {
			$fd = array_merge($d,$f);
			$dir = json_encode($fd);
		}elseif($d){$dir = json_encode($d);}
		else{$dir = json_encode($f);}
		
		$this->assign('json',$dir);
		$this->display();
		}
	public function add(){
		$this->display();
	}
	public function addFolder(){}
	public function edit(){$this->display();}
	public function updateFolder(){}
	public function delete(){$this->display();}
	public function delFolder(){}	
}
?>
