<?php
class ArticleAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Article = D('ArticleView'); 

		$where['bORn_article'] = 'b';
		if(!$_SESSION['administrator'])
		{
		$where['writerId_article']=  $_SESSION [C ( 'USER_AUTH_KEY' )];
		}
		$count = $Article->where($where)->count();//计算总数
		$p = new Page ( $count, 10 );
		$Mlist=$Article->where($where)->limit($p->firstRow.','.$p->listRows)->order('id_article desc,writerId_article asc')->select();//findAll
		$p->setConfig('header','篇文章');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
			
		//$Mlist = $Node->order('sort_node asc')->select(); 
		
		$this->assign('article',$Mlist);

		
		$this->display(); // 输出模板   
		
		}
	
	
	//取删除文章数据
	public function delete() {
		if(!empty($_GET['id_article'])) {
 
		 
		$Article	=	M("Article");
		$condition['id_article']	=	$_GET['id_article'];
		$vo = $Article->where($condition)->find(); // 查询数据   
			
			if($vo) {
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('删除项不存在！');
			}
		}else{
			exit('删除项不存在！');
		}
	}
	
	//取查看文章数据
	public function show() {
		if(!empty($_GET['id'])) {
 
		 
		$Article	=	M("Article");
		$condition['id_article']	=	$_GET['id'];
		$vo = $Article->where($condition)->find(); // 查询数据   
			
			if($vo) {
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('删除项不存在！');
			}
		}else{
			exit('删除项不存在！');
		}
	}
	// 删除文章
	public function delArticle() {
		if(!empty($_POST['id_article'])) {
			$Article	=	M("Article");
			$result	=	$Article->delete($_POST['id_article']);
			if(false !== $result) {
				$this->ajaxReturn($_POST['id_article'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	
	//取编辑文章数据
	public function edit() {
		if(!empty($_GET['id_article'])) {
 
		 
		$Article	=	M("Article");
		$condition['id_article']	=	$_GET['id_article'];
		$vo = $Article->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$Node->getById($_GET['id_node']);
			
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
	
	
	//更新文章
	public function updateArticle(){
		if(!empty($_POST['id_article'])) {
		
			$Article	=	D("Article");
			if($vo = $Article->create()) {
				$list=$Article->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Article->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	

	//添加文章
	public function addArticle() {
	
		$Article    =    D("Article"); 
        if($vo = $Article->create()) { 
            if(false!==$Article->add()){ 
                $vo['id_article']     =    nl2br($vo['id_article']);
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'表单数据保存成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($Article->getError()); 
        }
		
	}

}
?>
