<?php
class PictureAction extends CommonAction {

	// 框架首页 CommonAction
	public function index(){
	
		$Album = D('Album'); 

		//$where['buildId_album'] = array(array('eq',0),array('eq',$_SESSION[C('USER_AUTH_KEY')]),'or');
		//仅显示自己创建的相册
		$where['buildId_album'] =$_SESSION[C('USER_AUTH_KEY')];

		$Mlist=$Album->where($where)->select();

		$this->assign('album',$Mlist);
		$this->display(); // 输出模板   
		
		}

	
	//添加相册页
	public function addAlbum(){
	 
	 
	$this->display(); // 输出模板  
	
	}
	//添加相册
	public function creatAlbum(){
	

	  $Album    =    D("Album");
	  
	  $dir = 'ID'.$_SESSION[C('USER_AUTH_KEY')].'D'.date('YmdHis',time()); 

	  $auto = array (
		array('uploadpath_album',$dir,1),//上传路径
		array('buildId_album',$_SESSION[C('USER_AUTH_KEY')],1),
		array('time_album','time',1,'function') //自动添加时间
		);
	  $Album -> setProperty("_auto",$auto);
	  
        if($vo = $Album->create()) { 
		
				if(false!==$Album->add()){ 
					$vo['buildId_album']     =    nl2br($vo['buildId_album']);
					$vo['uploadpath_album'] =  $vo['uploadpath_album'];
					   //date('Y-m-d H:i:s',$vo['create_time']); 
				//添加机册文件夹
				$dir = '../Public/Uploads/'.$vo['uploadpath_album'];
					if(!is_dir($dir)) {
						mk_dir($dir);
					}
				 $this->ajaxReturn($dir,'新增相册成功！',1); 
				 }else{ 
             	  $this->error('数据写入错误！'); 
           		 } 
        }else{ 
            $this->error($Album->getError()); 
        }	
	}
	//编辑相册
	public function editAlbum() {
		if(!empty($_GET['id_album'])) {
 
		 
		$Album	=	M("Album");
		$condition['id_album']	=	$_GET['id_album'];
		$condition['buildId_album'] = $_SESSION[C('USER_AUTH_KEY')];
		$vo = $Album->where($condition)->find(); // 查询数据   

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
	//删除相册
	public function deleteAlbum(){
	
	if(!empty($_GET['id_album'])) {
		$Album	=	M("Album");
		$condition['id_album']	=	$_GET['id_album'];
		$condition['buildId_album'] = $_SESSION[C('USER_AUTH_KEY')];
		$vo = $Album->where($condition)->find();
		$result	=$Album->delete($_GET['id_album']);
				if(false !== $result) {
					if($vo){
					
					//删除数据
					$Picture = M('Picture');
					$where['albumId_picture']=$vo['id_album'];
					$Picture->where($where)->delete();
				
					//删除所有相册文件
					
					import("ORG.Io.Dir"); 
					$fpath = '../Public/Uploads/'.$vo['uploadpath_album'];
					Dir::delDir($fpath);

					}
					$this->ajaxReturn($_GET['id_album'],'删除成功！',1);
				}else{
					$this->error('删除出错！');
				}
				
	
	
	}else{
			exit('编辑项不存在！');
		}
	
	}
	//更新相册
	public function updateAlbum(){
	if(!empty($_POST['id_album'])) {
	
		$Album	=	D("Album");
			
			if($vo = $Album->create()) {
				$list=$Album->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Album->getError());
			}	
		
	
	
	
	
	}else{
			exit('编辑项不存在！');
		}
	}
	//设置相册封面
	public function frontAlbum(){
	
	if(!empty($_GET['id_picture'])) {
	
	
			$Pic	=	M("Picture");
			$condition['uploadId_picture']	=	$_SESSION[C('USER_AUTH_KEY')];
			$condition['id_picture']	=	$_GET['id_picture'];
			$vo = $Pic->where($condition)->find(); // 查询数据
			$path = $vo['path_picture'].'s_'.$vo['saveName_picture'];
				
			$Album	=	D("Album");
			$where['id_album'] = $_GET['id_album'];
			$data = array();
			$data['frontCover_album'] = $path;
			$Album->where($where)->save($data);
			if($Album!==false){
					$this->ajaxReturn($_GET['id_album'],'更新封面成功！',1); 
				}else{
					$this->error("没有更新任何数据!");
				}
				
	
	}else{
			exit('编辑项不存在！');
		}

	}
	
	//图片列表页
	public function pictureList(){
	if(!empty($_GET['albumId_picture'])) {
		
		
		$Album = D('Album'); 
		$where['id_album'] = $_GET['albumId_picture'];
		$Mlist=$Album->where($where)->find();
		$this->assign('album',$Mlist);
		 
		$Pic	=	M("Picture");
		$condition['albumId_picture']	=	$_GET['albumId_picture'];
		$condition['uploadId_picture']	=	$_SESSION[C('USER_AUTH_KEY')];
		$vo = $Pic->where($condition)->select(); // 查询数据   
			
			if($vo) {
				$this->assign('picture',$vo);
				$this->display();
			}else{
				$this->assign('noPic','<div class="notification information png_bg"><a href="#" class="close"><img src="__PUBLIC__/admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a><div>这个相册还没有上传照片</div></div>');
				$this->display();
			}
		}else{
			exit('相册不存在！');
		}
	//$this->display();
	}
	//图片详细资料页
	public function pictureShow(){
	//选择中的相册
		if(!empty($_GET['id_album'])) {
			$Album = D('Album'); 
			$where['id_album'] = $_GET['id_album'];
			$Mlist=$Album->where($where)->find();
			$this->assign('album',$Mlist);
			
			if(!empty($_GET['id_picture'])) {
			
				//选中的照片数据
				$Pic	=	M("Picture");
				$condition['albumId_picture']	=	$_GET['id_album'];
				$condition['uploadId_picture']	=	$_SESSION[C('USER_AUTH_KEY')];
				$condition['id_picture']	=	$_GET['id_picture'];
				$vo = $Pic->where($condition)->find(); // 查询数据
				if($vo) {
					$this->assign('selePic',$vo);
				}else{
					$this->assign('errPic','<div class="notification error png_bg"><a href="#" class="close"><img src="__PUBLIC__/admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a><div>照片没有找到，可能已被删除</div></div>');
				}
			
			$this->display();
			
			}else{
			
			exit('请求出错,照片不存在！');
			}
	
		}else{
		exit('相册不存在！');
		}
	
	}
	//编辑图片
	public function editPic(){
	
	if(!empty($_POST['id_picture'])) {
			$Pic	=	D("Picture");
			if($vo = $Pic->create()) {
				$list=$Pic->save();
				if($list!==false){
					//$this->success('数据更新成功！');
					$vo['name_picture']     =    nl2br($vo['name_picture']);
					$vo['explain_picture']     =    nl2br($vo['explain_picture']);
               		 $this->ajaxReturn($vo,'表单数据保存成功！',1); 
				
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Pic->getError());
			}	
		
		
	}else{
	exit('照片不存在！');
	}
	
	}
	//删除图片
	public function deletePic(){
	
	if(!empty($_GET['id_picture'])) {
	
				//多查询一次图片信息，取图片路径
				$Pic	=	M("Picture");
				$condition['uploadId_picture']	=	$_SESSION[C('USER_AUTH_KEY')];
				$condition['id_picture']	=	$_GET['id_picture'];
				$vo = $Pic->where($condition)->find(); // 查询数据
			
				$result	=	$Pic->delete($_GET['id_picture']);
				if(false !== $result) {
					if($vo){
				
						//删除文件
						$apath = '../Public/Uploads/'.$_GET['apath'].'/';
						$picPath = $apath.$vo['saveName_picture'];
						$picPathXL = $apath.'xl_'.$vo['saveName_picture'];
						$picPathL = $apath.'l_'.$vo['saveName_picture'];
						$picPathM = $apath.'m_'.$vo['saveName_picture'];
						$picPathS = $apath.'s_'.$vo['saveName_picture'];
						
						if(file_exists($picPath)){
							unlink($picPath);
							unlink($picPathXL);
							unlink($picPathL);
							unlink($picPathM);
							unlink($picPathS);
						}				
					}
					else{
						$this->error('没有找到原图片！');
						}
					$this->ajaxReturn($_GET['id_picture'],'删除成功！',1);
				}else{
					$this->error('删除出错！');
				}
	
	
	}else{
	exit('照片不存在！');
	}
	
	
	
	}
	
	
	//图片上传页
	public function uploadPicture(){
	
	$sid = Session::id();
	$this->assign('sid',$sid);
	
	$this->display();
	
	
	}
	//图片上传方法
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
		//$path = $_POST['path'];
		//$aid =  $_POST['id'];
        
        $ps = explode("_", $_POST['id']);
        
        $path = $ps[1];
		$aid =  $ps[0];
        
        $upload = new UploadFile(); 
        //设置上传文件大小 
        //$upload->maxSize  = 32922000 ; 
        //设置上传文件类型 
		
		$upload->allowExts  =array('jpg', 'gif', 'png', 'jpeg');
        //$upload->allowExts  = explode(',','jpg,gif,png,jpeg'); 
        //设置附件上传目录 
        $upload->savePath =  '../Public/Uploads/'.$path.'/';
		
//        //是否子目录保存
//		$upload->autoSub = true;
//	    $upload->subType = 'date';
//	    $upload->dateFormat = 'Ymd';
		
		//设置需要生成缩略图，仅对图像文件有效 
       $upload->thumb =  true; 
       //设置需要生成缩略图的文件后缀 
        $upload->thumbPrefix   =  'xl_,l_,m_,s_';  //生产4张缩略图 
       //设置缩略图最大宽度 
        $upload->thumbMaxWidth =  '675,310,220,50'; 
       //设置缩略图最大高度 
        $upload->thumbMaxHeight = '456,310,220,38'; 
       //设置上传文件规则 
       $upload->saveRule = uniqid; 
       //删除原图 
      // $upload->thumbRemoveOrigin = true; 
        if(!$upload->upload()) { 
            //捕获上传异常 
            $this->error($upload->getErrorMsg()); 
        }else { 
            //取得成功上传的文件信息 
            $uploadList = $upload->getUploadFileInfo(); 
            $name  = $uploadList[0]['name']; 
			$savename  = $uploadList[0]['savename']; 
			$savepath =  $uploadList[0]['savepath'];//此处要增加USE_ID
			$size =  $uploadList[0]['size'];
			
			//保存当前数据对象
			$model = M ('Picture'); 
			$data['explain_picture'] = $name; //默认将原始名称写入说明
			$data['name_picture']=$name; 
			$data['saveName_picture']= $savename;
			//$data['path_picture']=$savepath.'s_'.$savename; 
			$data['path_picture']='__ROOT__/Public/Uploads/'.$path.'/';
			$data['size_picture']=$size; 
			$data['albumId_picture']=$aid;
			$data['uploadId_picture']	=	$_SESSION[C('USER_AUTH_KEY')];
			$data['time_picture']=time() ; 
			$list=$model->add ($data);
			 
			if($list!==false){ 
				$this->success ('上传图片成功！'); 
			}else{ 
				$this->error ('上传图片失败!'); 
			} 
			
			$this->success ($fileName .'上传图片成功！'); 
        } 
        
    } 


}
?>
