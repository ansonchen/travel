<?php
class HotelsattrAction extends CommonAction {

    function _initialize() {
                    		
		//下拉列表用的菜单信息
		$menu = M('HotelsAttr'); 
		$where['level']= array(2,1,'or'); 
		$where['status']=1;
	//	$where['show_status']=1;
		$Mlist = $menu->where($where)->order('id asc')->select(); 
		//$Mlist = $menu->order('sort asc')->select(); 
		//$this->assign('leftMenu',$Mlist);
		
		//用于下拉列表数据
		//$olist=$menu->order('sort asc')->select();
		$this->assign('hmenu',$Mlist);
        
    }
	// 框架首页 CommonAction
	public function index() {
	
//		import("ORG.Util.Page"); 
//	
//		$HotelsAttr = M('HotelsAttr'); 
//		$count = $HotelsAttr->count();//计算总数
//		
//		$p = new Page ( $count, 10 );
//		
//		$Mlist=$HotelsAttr->limit($p->firstRow.','.$p->listRows)->order('sort asc')->findAll();
//		
//		$p->setConfig('header','个菜单');
//
//		$p->setConfig('prev',"&laquo; 上一页");
//		$p->setConfig('next','下一页 &raquo;');
//		$p->setConfig('first','&laquo; 第一页');
//		$p->setConfig('last','最后一页 &raquo;');
//		$page = $p->show ();
//		$this->assign( "page", $page );
//			
//		//$Mlist = $HotelsAttr->order('sort asc')->select(); 
//		
//		$this->assign('menu',$Mlist);
//		
		$this->display(); // 输出模板   
		
		}
	//json输出
	public function json(){
	
		$HotelsAttr = M('HotelsAttr');
		$GTlist=$HotelsAttr->order('sort asc')->select();	 
		$CNGTlist =json_encode($GTlist);
		//$CNGTlist = preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $CNGTlist);//输出中文
		//$this->assign('Jgtype',$CNGTlist);
		echo $CNGTlist;
	
	}
	
		//取菜单数据
	public function add() {
		if(!empty($_GET['id'])) {
 
		 

            
		$HotelsAttr	=	M("HotelsAttr");
		$condition['id']	=	$_GET['id'];
		$vo = $HotelsAttr->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$HotelsAttr->getById($_GET['id_HotelsAttr']);
			
			if($vo) {
				$vo['lv'] = $vo['level']+1;
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
	
	//取删除菜单数据
	public function delete() {
		if(!empty($_GET['id'])) {
 
		 
		$HotelsAttr	=	M("HotelsAttr");
		$condition['id']	=	$_GET['id'];
		$vo = $HotelsAttr->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$HotelsAttr->getById($_GET['id_HotelsAttr']);
			
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
	//取删除菜单数据
	public function sdelete() {
		if(!empty($_GET['id'])) {
 
		 
		$HotelsAttr	=	M("HotelsAttr");
		$condition['id']	=	$_GET['id'];
		$vo = $HotelsAttr->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$HotelsAttr->getById($_GET['id_HotelsAttr']);
			
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
			$HotelsAttr	=	M("HotelsAttr");
			$result	=	$HotelsAttr->delete($_POST['id']);
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
 
		 
		$HotelsAttr	=	M("HotelsAttr");
		$condition['id']	=	$_GET['id'];
		$vo = $HotelsAttr->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$HotelsAttr->getById($_GET['id_HotelsAttr']);
			
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
	
		//取编辑菜单数据
	public function sedit() {
		if(!empty($_GET['id'])) {
 
		 
		$HotelsAttr	=	M("HotelsAttr");
		$condition['id']	=	$_GET['id'];
		$vo = $HotelsAttr->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$HotelsAttr->getById($_GET['id_HotelsAttr']);
			
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
		
			$HotelsAttr	=	D("HotelsAttr");
			if($vo = $HotelsAttr->create()) {
				$list=$HotelsAttr->save();
				if($list!==false){
				
				$this->ajaxReturn($vo,'表单数据保存成功！',1);
				//	$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($HotelsAttr->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	
	//更新菜单状态
	public function updateStatus(){
	
		if(!empty($_GET['id'])) {
		
			$HotelsAttr	=	D("HotelsAttr");
			$where['id'] = $_GET['id'];
			$data = array();
			$data['status'] = $_GET['status'];
			$HotelsAttr->where($where)->save($data);
			if($HotelsAttr!==false){
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
		
			$HotelsAttr	=	D("HotelsAttr");
			$where['id'] = $_GET['id'];
			$data = array();
			$data['show_status'] = $_GET['status'];
			$HotelsAttr->where($where)->save($data);
			if($HotelsAttr!==false){
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
	
	  $Form    =    D("HotelsAttr"); 
        if($vo = $Form->create()) { 
			$addId = $Form->add();
            if(false!==$addId){ 
				
				$condition['id']=$addId;
				$vonew = $Form->where($condition)->find(); // 查询数据 
				
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
