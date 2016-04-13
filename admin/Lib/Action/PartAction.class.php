<?php
class PartAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$part = D('Part'); 
		$count = $part->count();//计算总数
		
		$p = new Page ( $count, 10 );
		$Mlist=$part->limit($p->firstRow.','.$p->listRows)->order('sort asc')->findAll();
		$p->setConfig('header','个分类');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
		$this->assign('Part',$Mlist);
		$this->display(); // 输出模板   
		
		}
	
		//添加分类
	public function addPart() {
	
	  $part    =    D("Part");   
        if($vo = $part->create()) { 
            if(false!==$part->add()){ 
                $vo['name']     =    nl2br($vo['name']);
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'表单数据保存成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($part->getError()); 
        }
		
	}
	
		
	//取编辑数据
	public function edit() {
		if(!empty($_GET['id'])) {
 
		 
		$part	=	M("Part");
		$condition['id']	=	$_GET['id'];
		$vo = $part->where($condition)->find(); // 查询数据   
					
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
	
	//选择商品
	public function chose(){
		if(!empty($_GET['id'])) {
		
		//取商品数据
 		$Goods	=	M("Goods");
		$gvo = $Goods->field('id_goods,picturePath_goods,name_goods')->select();
		$this->assign( "goodsv", $gvo );
		
		 
		$part	=	M("Part");
		$condition['id']	=	$_GET['id'];
		$vo = $part->where($condition)->find(); // 查询数据   
					
			if($vo) {
				$this->assign('nvo',$vo);
				$this->display();
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
		
		
		
	}
	public function choseGoods(){
	//$this->ajaxReturn($_POST['id'],'设置成功！',1);
	
	if(!empty($_POST['id'])) {
	
	
	
	//先删除以前的数据
		$pg = M('PartGoods'); 
		$where['part_id'] = $_POST['id'];
		$pg->where($where)->delete();
		
		for($i=0;$i<count($_POST["goodsID"]);$i++)
			{
			
			$pg->part_id = $_POST["id"];
			$pg->goods_id = $_POST["goodsID"][$i];;
			
			$pg->add();
			}
				
	
		$part	=	M("Part");
		//$data['goods_id']=$_POST['goods_id'];
		if($vo = $part->create()) {
				if(false!==$part->save()){
					$this->ajaxReturn($_POST['id'],'设置成功！',1);
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($part->getError());
			}
			
		//$part ->where('id='.$_POST['id'])->data($data)->save();
		
		//$this->ajaxReturn($_POST['id'],'设置成功！',1);
		
	}else{
			exit('编辑项不存在！');
		}
		
	
	}
		//更新栏目
	public function updatePart(){
		if(!empty($_POST['id'])) {
		
			$part	=	D("Part");
			
	  
			if($vo = $part->create()) {
				$list=$part->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($part->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	
	
	
	//取删除菜单数据
	public function delete() {
		if(!empty($_GET['id'])) {
 
		 
		$part	=	M("Part");
		$condition['id']	=	$_GET['id'];
		$vo = $part->where($condition)->find(); // 查询数据   
		
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
	// 删除栏目
	public function delPart() {
		if(!empty($_POST['id'])) {
			$part	=	M("Part");
			$result	=	$part->delete($_POST['id']);
			if(false !== $result) {
				$this->ajaxReturn($_POST['id'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
		//更新显示状态
	public function updateShowStatus(){
	
		if(!empty($_GET['id'])) {
		
			$part	=	D("Part");
			$where['id'] = $_GET['id'];
			$data = array();
			$data['status'] = $_GET['status'];
			$part->where($where)->save($data);
			if($part!==false){
					$this->success('更新状态成功！id='.$_GET['id']);
				}else{
					$this->error("没有更新任何数据!");
				}
			
		}else{
			exit('编辑项不存在！');
		}
	
	
	
	
	}
	
	


}
?>
