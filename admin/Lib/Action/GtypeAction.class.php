<?php
class GtypeAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
//		import("ORG.Util.Page"); 
//	
//		$Type = M('GoodsType'); 
//		$count = $Type->count()-1;//计算总数
//		
//		$p = new Page ( $count, 10 );
//		$Mlist=$Type->limit($p->firstRow.','.$p->listRows)->order('id asc')->findAll();
//		$p->setConfig('header','个分类');
//
//		$p->setConfig('prev',"&laquo; 上一页");
//		$p->setConfig('next','下一页 &raquo;');
//		$p->setConfig('first','&laquo; 第一页');
//		$p->setConfig('last','最后一页 &raquo;');
//		$page = $p->show ();
//		$this->assign( "page", $page );
//		$this->assign('type',$Mlist);
//		
//		$GTlist=$Type->order('id asc')->select();	
//			
//		$this->assign('gtype',$GTlist);
//		header('Content-Type: text/html; charset=utf-8');
		$this->display(); // 输出模板   
		
		}
		
	public function json(){
	
		$Type = M('GoodsType');
		$GTlist=$Type->order('id asc')->select();	 
		$CNGTlist =json_encode($GTlist);
		//$CNGTlist = preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $CNGTlist);//输出中文
		//$this->assign('Jgtype',$CNGTlist);
		echo $CNGTlist;
	
	}
	
		//添加分类
	public function addType() {
	
	  $Type    =    D("GoodsType"); 
	  
	  
	 
        if($vo = $Type->create()) {
			$addId = $Type->add();
            if(false!== $addId){ 
			
				$condition['id']=$addId;
				$vonew = $Type->where($condition)->find(); // 查询数据 
		
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vonew,'表单数据保存成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($Type->getError()); 
        }
		
	}
	
		//取编辑数据
	public function add() {
		if(!empty($_GET['id'])) {
 
		 
		$Type	=	M("GoodsType");
		
		
		$condition['id']	=	$_GET['id'];
		$vo = $Type->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$Node->getById($_GET['id_node']);
			
			if($vo) {
				$vo['lv'] = $vo['level']+1;
				$GTlist=$Type->order('id asc')->select();		
				$this->assign('gtype',$GTlist);
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
			

	//取编辑数据
	public function edit() {
		if(!empty($_GET['id'])) {
 
		 
		$Type	=	M("GoodsType");
		
		
		$condition['id']	=	$_GET['id'];
		$vo = $Type->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$Node->getById($_GET['id_node']);
			
			if($vo) {
				$GTlist=$Type->order('id asc')->select();		
				$this->assign('gtype',$GTlist);
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
	//取编辑数据
	public function sedit() {
		if(!empty($_GET['id'])) {
 
		 
		$Type	=	M("GoodsType");
		
		
		$condition['id']	=	$_GET['id'];
		$vo = $Type->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$Node->getById($_GET['id_node']);
			
			if($vo) {
				$GTlist=$Type->order('id asc')->select();		
				$this->assign('gtype',$GTlist);
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
		if(!empty($_POST['id'])) {
		
			$Type	=	D("GoodsType");
			
			if($vo = $Type->create()) {
				$list=$Type->save();
				if($list!==false){
					//$this->success('数据更新成功！');
					$this->ajaxReturn($vo,'表单数据保存成功！',1);
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
	
	
	
	//取删除数据
	public function delete() {
		if(!empty($_GET['id'])) {
 
		 
		$Type	=	M("GoodsType");
		
		$condition['id']	=	$_GET['id'];
		$vo = $Type->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$Node->getById($_GET['id_node']);
			
			if($vo) {
				$GTlist=$Type->order('id asc')->select();		
				$this->assign('gtype',$GTlist);
		
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('删除项不存在！');
			}
		}else{
			exit('删除项不存在！');
		}
	}
		//取删除数据
	public function sdelete() {
		if(!empty($_GET['id'])) {
 
		 
		$Type	=	M("GoodsType");
		
		$condition['id']	=	$_GET['id'];
		$vo = $Type->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$Node->getById($_GET['id_node']);
			
			if($vo) {
				$GTlist=$Type->order('id asc')->select();		
				$this->assign('gtype',$GTlist);
		
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
		if(!empty($_POST['id'])) {
			$Type	=	M("GoodsType");
			$result	=	$Type->delete($_POST['id']);
			if(false !== $result) {
				$this->ajaxReturn($_POST['id'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	//更新状态
	public function updateStatus(){
	
		if(!empty($_GET['id'])) {
		
			$Node	=	D("GoodsType");
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
	
	


}
?>
