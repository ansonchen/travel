<?php
class MenuAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Node = M('Menu'); 
		$count = $Node->count();//计算总数
		
		$p = new Page ( $count, 10 );
		
		$Mlist=$Node->limit($p->firstRow.','.$p->listRows)->order('sort asc')->findAll();
		
		$p->setConfig('header','个菜单');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
			
		//$Mlist = $Node->order('sort asc')->select(); 
		
		$this->assign('menu',$Mlist);
		
		$this->display(); // 输出模板   
		
		}
	
	
	//取删除菜单数据
	public function delete() {
		if(!empty($_GET['id'])) {
 
		 
		$Node	=	M('Menu');
		$condition['id']	=	$_GET['id'];
		$vo = $Node->where($condition)->find(); // 查询数据   
		
					
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
	// 删除菜单
	public function delMenus() {
		if(!empty($_POST['id'])) {
			$Node	=	M('Menu');
			$result	=	$Node->delete($_POST['id']);
			if(false !== $result) {
				$this->ajaxReturn($_POST['id'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	
	//取编辑菜单数据
	public function edit() {
		if(!empty($_GET['id'])) {
 
		 
		$Node	=	M('Menu');
		$condition['id']	=	$_GET['id'];
		$vo = $Node->where($condition)->find(); // 查询数据   
		
					
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
	
	
	
	
	//更新菜单
	public function updateMenus(){
		if(!empty($_POST['id'])) {
		
			$Node	=	D('Menu');
			if($vo = $Node->create()) {
				$list=$Node->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Node->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	
	//更新菜单状态
	public function updateStatus(){
	
		if(!empty($_GET['id'])) {
		
			$Node	=	D('Menu');
			$where['id'] = $_GET['id'];
			$data = array();
			$data['status'] = $_GET['status'];
			$Node->where($where)->save($data);
			if($Node!==false){
					$this->success('更新状态成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			
		
		}else{
			exit('编辑项不存在！');
		}
	
	
	
	
	}
	
		//更新菜单显示状态
	public function updateShowStatus(){
	
		if(!empty($_GET['id'])) {
		
			$Node	=	D('Menu');
			$where['id'] = $_GET['id'];
			$data = array();
			$data['show_status'] = $_GET['status'];
			$Node->where($where)->save($data);
			if($Node!==false){
					$this->success('更新状态成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			
		
		}else{
			exit('编辑项不存在！');
		}
	
	
	
	
	}
	
	//添加菜单
	public function addMenus() {	
	
	  $Form    =    D('Menu'); 
        if($vo = $Form->create()) { 
            if(false!==$Form->add()){ 
                $vo['name']     =    nl2br($vo['name']);
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'表单数据保存成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($Form->getError()); 
        }
		
	}

}
?>
