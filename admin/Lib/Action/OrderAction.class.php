<?php
class OrderAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Order = D('Order'); 
		$count = $Order->count();//计算总数
		
		$p = new Page ( $count, 10 );
		$Mlist=$Order->limit($p->firstRow.','.$p->listRows)->order('id_order asc')->findAll();
		$p->setConfig('header','张订单');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
		$this->assign('order',$Mlist);
		$this->display(); // 输出模板   
		
		}
	

		
	//取编辑数据
	public function edit() {
		if(!empty($_GET['id'])) {
 
		 
		$Order	=	M("Order");
		$condition['id_order']	=	$_GET['id'];
		$vo = $Order->where($condition)->find(); // 查询数据   
		if($vo) {
				$Olist = M("ShoppingList");
				$where['order_id'] =$_GET['id'];
				$goodsList = $Olist->where($where)->select();
			
				$this->assign('goodsList',$goodsList);
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('没有找到数据，可能已被删除！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
	
		//更新订单
	public function updateOrder(){
		if(!empty($_POST['id_order'])) {
		
			$Order	=	D("Order");
			
			$auto = array ( 
				array('updateTime_order','time',2,'function') //自动添加时间
				);	
			$Order -> setProperty("_auto",$auto);
	  
			if($vo = $Order->create()) {
				$list=$Order->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Order->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	
	
	
	//更新状态
	public function updateStatus(){
	
		if(!empty($_GET['id'])) {
		
			$Order	=	D("Order");
			$where['id_order'] = $_GET['id'];
			$data = array();
			$data['paymentStaus_order'] = $_GET['status'];
			$Order->where($where)->save($data);
			if($Order!==false){
					$this->success('更新状态成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			
		
		}else{
			exit('编辑项不存在！');
		}
	
	
	
	
	}
	// 删除订单
	public function delOrder() {
		if(!empty($_POST['id_order'])) {
			$Order	=	M("Order");
			$result	=	$Order->delete($_POST['id_order']);
			if(false !== $result) {
				//删除订单对应购物清单
					$shoppinglist = M('ShoppingList'); 
					$where['order_id'] = $_POST['id_order'];
					$shoppinglist->where($where)->delete();
		
				$this->ajaxReturn($_POST['id_order'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	

	
	


}
?>
