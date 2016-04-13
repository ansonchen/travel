<?php
class FileAction extends CommonAction {

	// 框架首页 CommonAction
	public function index(){
	
		$Folder = D('Folder'); 

		//$where['buildId_folder'] = array(array('eq',0),array('eq',$_SESSION[C('USER_AUTH_KEY')]),'or');
		//仅显示自己创建的文件夹
		$where['buildId_folder'] =$_SESSION[C('USER_AUTH_KEY')];

		$Mlist=$Folder->where($where)->select();

		$this->assign('folder',$Mlist);
		$this->display(); // 输出模板   
		
		}

	
	//添加文件夹页
	public function addFolder(){
	 
	 
	$this->display(); // 输出模板  
	
	}
	//添加文件夹
	public function creatFolder(){
	

	  $Folder    =    D("Folder");
	  
	  $dir = 'ID'.$_SESSION[C('USER_AUTH_KEY')].'D'.date('YmdHis',time()); 

	  $auto = array (
		array('uploadpath_folder',$dir,1),//上传路径
		array('buildId_folder',$_SESSION[C('USER_AUTH_KEY')],1),
		array('time_folder','time',1,'function') //自动添加时间
		);
	  $Folder -> setProperty("_auto",$auto);
	  
        if($vo = $Folder->create()) { 
		
				if(false!==$Folder->add()){ 
					$vo['buildId_folder']     =    nl2br($vo['buildId_folder']);
					$vo['uploadpath_folder'] =  $vo['uploadpath_folder'];
					   //date('Y-m-d H:i:s',$vo['create_time']); 
				//添加机册文件夹
				$dir = '../Public/Uploads/'.$vo['uploadpath_folder'];
					if(!is_dir($dir)) {
						mk_dir($dir);
					}
				 $this->ajaxReturn($dir,'新增文件夹成功！',1); 
				 }else{ 
             	  $this->error('数据写入错误！'); 
           		 } 
        }else{ 
            $this->error($Folder->getError()); 
        }	
	}
	//编辑文件夹
	public function editFolder() {
		if(!empty($_GET['id_folder'])) {
 
		 
		$Folder	=	M("Folder");
		$condition['id_folder']	=	$_GET['id_folder'];
		$condition['buildId_folder'] = $_SESSION[C('USER_AUTH_KEY')];
		$vo = $Folder->where($condition)->find(); // 查询数据   

			if($vo) {
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
	//删除文件夹
	public function deleteFolder(){
	
	if(!empty($_GET['id_folder'])) {
		$Folder	=	M("Folder");
		$condition['id_folder']	=	$_GET['id_folder'];
		$condition['buildId_folder'] = $_SESSION[C('USER_AUTH_KEY')];
		$vo = $Folder->where($condition)->find();
		$result	=$Folder->delete($_GET['id_folder']);
				if(false !== $result) {
					if($vo){
					
					//删除数据
					$File = M('File');
					$where['folderId_file']=$vo['id_folder'];
					$File->where($where)->delete();
				
					//删除所有文件夹文件
					
					import("ORG.Io.Dir"); 
					$fpath = '../Public/Uploads/'.$vo['uploadpath_folder'];
					Dir::delDir($fpath);

					}
					$this->ajaxReturn($_GET['id_folder'],'删除成功！',1);
				}else{
					$this->error('删除出错！');
				}
				
	
	
	}else{
			exit('编辑项不存在！');
		}
	
	}
	//更新文件夹
	public function updateFolder(){
	if(!empty($_POST['id_folder'])) {
	
		$Folder	=	D("Folder");
			
			if($vo = $Folder->create()) {
				$list=$Folder->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Folder->getError());
			}	
		
	
	
	
	
	}else{
			exit('编辑项不存在！');
		}
	}
	
	//文件列表页
	public function fileList(){
	if(!empty($_GET['folderId_file'])) {
		
		$getRand = mt_rand();
		$this->assign('getRand',$getRand);
		
		$Folder = D('Folder'); 
		$where['id_folder'] = $_GET['folderId_file'];
		$Mlist=$Folder->where($where)->find();
		$this->assign('folder',$Mlist);
		 
		$Pic	=	M("File");
		$condition['folderId_file']	=	$_GET['folderId_file'];
		$condition['uploadId_file']	=	$_SESSION[C('USER_AUTH_KEY')];
		$vo = $Pic->where($condition)->select(); // 查询数据   
			
			if($vo) {
				$this->assign('file',$vo);
				$this->display();
			}else{
				$this->assign('noPic','<div class="notification information png_bg"><a href="#" class="close"><img src="__PUBLIC__/admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a><div>这个文件夹还没有上传文件</div></div>');
				$this->display();
			}
		}else{
			exit('文件夹不存在！');
		}
	//$this->display();
	}
	//附件详细资料页
	public function fileShow(){
	//选择中的文件夹
		if(!empty($_GET['id_folder'])) {
			$Folder = D('Folder'); 
			$where['id_folder'] = $_GET['id_folder'];
			$Mlist=$Folder->where($where)->find();
			$this->assign('folder',$Mlist);
			
			if(!empty($_GET['id_file'])) {
			
				//选中的文件数据
				$Pic	=	M("File");
				$condition['folderId_file']	=	$_GET['id_folder'];
				$condition['uploadId_file']	=	$_SESSION[C('USER_AUTH_KEY')];
				$condition['id_file']	=	$_GET['id_file'];
				$vo = $Pic->where($condition)->find(); // 查询数据
				if($vo) {
					$this->assign('selePic',$vo);
				}else{
					$this->assign('errPic','<div class="notification error png_bg"><a href="#" class="close"><img src="__PUBLIC__/admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a><div>文件没有找到，可能已被删除</div></div>');
				}
			
			$this->display();
			
			}else{
			
			exit('请求出错,文件不存在！');
			}
	
		}else{
		exit('文件夹不存在！');
		}
	
	}
	//编辑文件
	public function editPic(){
	
	if(!empty($_POST['id_file'])) {
			$Pic	=	D("File");
			if($vo = $Pic->create()) {
				$list=$Pic->save();
				if($list!==false){
					//$this->success('数据更新成功！');
					$vo['name_file']     =    nl2br($vo['name_file']);
					$vo['explain_file']     =    nl2br($vo['explain_file']);
               		 $this->ajaxReturn($vo,'表单数据保存成功！',1); 
				
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Pic->getError());
			}	
		
		
	}else{
	exit('文件不存在！');
	}
	
	}
	//删除文件
	public function deletePic(){
	
	if(!empty($_GET['id_file'])) {
	
				//多查询一次文件信息，取文件路径
				$Pic	=	M("File");
				$condition['uploadId_file']	=	$_SESSION[C('USER_AUTH_KEY')];
				$condition['id_file']	=	$_GET['id_file'];
				$vo = $Pic->where($condition)->find(); // 查询数据
			
				$result	=	$Pic->delete($_GET['id_file']);
				if(false !== $result) {
					if($vo){
				
						//删除文件
						$apath = '../Public/Uploads/'.$_GET['apath'].'/';
						$picPath = $apath.$vo['saveName_file'];
						$picPathXL = $apath.'xl_'.$vo['saveName_file'];
						$picPathL = $apath.'l_'.$vo['saveName_file'];
						$picPathM = $apath.'m_'.$vo['saveName_file'];
						$picPathS = $apath.'s_'.$vo['saveName_file'];
						
						if(file_exists($picPath)){
							unlink($picPath);
							unlink($picPathXL);
							unlink($picPathL);
							unlink($picPathM);
							unlink($picPathS);
						}				
					}
					else{
						$this->error('没有找到原文件！');
						}
					$this->ajaxReturn($_GET['id_file'],'删除成功！',1);
				}else{
					$this->error('删除出错！');
				}
	
	
	}else{
	exit('文件不存在！');
	}
	
	
	
	}
	
	
	//图片上传页
	public function uploadFile(){
	
	$getRand = mt_rand();
	
	$this->assign('getRand',$getRand);
	
	$sid = Session::id();
	$this->assign('sid',$sid);
	
	$this->display();
	
	
	}
	//文件上传方法
	public function upload(){
	
	if(!empty($_FILES)) { 
			
            //如果有文件上传 上传附件 
            $this->_upload(); 
	    } 
	}
	// 文件上传 
    protected function _upload(){
	
	if (!empty($_POST["PHPSESSID"])) {
		Session::id($_POST["PHPSESSID"]);
		Session::start();
	}
	import("ORG.Net.UploadFile"); 
		$path = $_POST['path'];
		$aid =  $_POST['id'];
        $upload = new UploadFile(); 
		$upload->saveRule = time;
        $upload->savePath =  '../Public/Uploads/'.$path.'/';
        if(!$upload->upload()) { 
            //捕获上传异常 
            $this->error($upload->getErrorMsg()); 
        }else { 
            //取得成功上传的文件信息 
            $uploadList = $upload->getUploadFileInfo(); 
            $name  = $uploadList[0]['name']; 
			$savename  = $uploadList[0]['savename']; 
			$size =  $uploadList[0]['size'];
			
			//保存当前数据对象
			$model = M ('File'); 
			$data['explain_file'] = $name; //默认将原始名称写入说明
			$data['name_file']=$name; 
			$data['saveName_file']= $savename;
			$data['path_file']='__ROOT__/Public/Uploads/'.$path.'/';
			$data['size_file']=$size; 
			$data['folderId_file']=$aid;
			$data['uploadId_file']	=	$_SESSION[C('USER_AUTH_KEY')];
			$data['time_file']=time() ; 
			$list=$model->add ($data);
			 
			if($list!==false){ 
				$this->success ($path.'上传文件成功！'); 
			}else{ 
				$this->error ('上传文件失败!'); 
			} 
			
			$this->success ($fileName .'上传文件成功！'); 
        } 
        
    } 


}
?>
