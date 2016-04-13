<?php
class AlbumAction extends CommonAction {

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
	//用于Fck	
	public function indexFck(){
	$this->index();
	}
	
	//用于单选	
	public function indexOne(){
	$this->index();
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
	
	//用于Fck
	public function pictureListFck(){
	$this->pictureList();
	}
	
	//用于单选
	public function pictureListOne(){
	$this->pictureList();
	}
	

}
?>
