<?php
class TypeAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Type = D('TypeView'); 
		$count = $Type->count()-1;//计算总数
		
		$p = new Page ( $count, 10 );
		$where['id_type'] = array('neq',1); 
		$where['buildId_type']=  $_SESSION [C ( 'USER_AUTH_KEY' )];
		$Mlist=$Type->where($where)->limit($p->firstRow.','.$p->listRows)->order('belongType_type asc')->findAll();
		$p->setConfig('header','个分类');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
		$this->assign('type',$Mlist);
		$this->display(); // 输出模板   
		
		}
	
		//添加分类
	public function addType() {
	
	  $Type    =    D("Type"); 
	  
	  
	  $auto = array ( 
		 array('buildId_type',$_SESSION[C('USER_AUTH_KEY')],1),
		 array('time_type','time',1,'function') //自动添加时间
		);
	  $Type -> setProperty("_auto",$auto);
	  
	  
        if($vo = $Type->create()) { 
            if(false!==$Type->add()){ 
                $vo['name_type']     =    nl2br($vo['name_type']);
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'表单数据保存成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($Type->getError()); 
        }
		
	}
	
		
	//取编辑数据
	public function edit() {
		if(!empty($_GET['id_type'])) {
 
		 
		$Type	=	M("Type");
		$condition['id_type']	=	$_GET['id_type'];
		$vo = $Type->where($condition)->find(); // 查询数据   
		
					
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
	
		//更新分类
	public function updateType(){
		if(!empty($_POST['id_type'])) {
		
			$Type	=	D("Type");
			
			$auto = array ( 
				array('buildId_type',$_SESSION[C('USER_AUTH_KEY')],2),
				array('time_type','time',2,'function') //自动添加时间
				);	
			$Type -> setProperty("_auto",$auto);
	  
			if($vo = $Type->create()) {
				$list=$Type->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Type->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	
	
	
	//取删除菜单数据
	public function delete() {
		if(!empty($_GET['id_type'])) {
 
		 
		$Type	=	M("Type");
		$condition['id_type']	=	$_GET['id_type'];
		$vo = $Type->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$Node->getById($_GET['id_node']);
			
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
	// 删除分类
	public function delType() {
		if(!empty($_POST['id_type'])) {
			$Type	=	M("Type");
			$result	=	$Type->delete($_POST['id_type']);
			if(false !== $result) {
				$this->ajaxReturn($_POST['id_type'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	

	
	


}
?>
