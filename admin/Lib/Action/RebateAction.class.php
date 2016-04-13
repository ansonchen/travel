<?php
class RebateAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {

		import("ORG.Util.Page"); 
	
		$Rebate = M('Rebate'); 
		$count = $Rebate->count();//计算总数
		
		$p = new Page ( $count, 10 );
		
		$Mlist=$Rebate->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll();
		//$Mlist=$Rebate->order('id desc')->findAll();
		
		$p->setConfig('header','个菜单');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		
		$this->assign( "page", $page );
		$nowYear = date('Y-m-d');
		
		$nextTime= date('Y-m-d',strtotime('+1 year'));
		$this->assign('nowTime',$nowYear);
		$this->assign('nextTime',$nextTime);
		$this->assign('Rebate',$Mlist);
		
		$this->display(); // 输出模板   
		
		}
	
	
	// 删除优惠码
	public function delete() {
		if(!empty($_GET['id'])) {
			$Rebate	=	M("Rebate");
			$result	=	$Rebate->delete($_GET['id']);
			if(false !== $result) {
				$this->ajaxReturn($_GET['id'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	//删除多个优惠码
	public function delRebate() {
		if(!empty($_POST['delId'])) {
			$Rebate	=	M("Rebate");
			$deleteId = $_POST['delId'];
			foreach($deleteId as $value)
			{
			$result	=	$Rebate->delete($value);
			}
			$this->ajaxReturn($_POST['delId'],'删除成功！',1);
	
		}else{
			$this->error('请先选择要删除的优惠码！');
		}
	}
	

	
	//更新状态
	public function updateStatus(){
	
		if(!empty($_GET['id'])) {
		
			$Rebate	=	D("Rebate");
			$where['id'] = $_GET['id'];
			$data = array();
			$data['status'] = $_GET['status'];
			$Rebate->where($where)->save($data);
			if($Rebate!==false){
					$this->success('更新状态成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			
		
		}else{
			exit('编辑项不存在！');
		}
	
	
	
	
	}
	

	//添加优惠码
	public function addRebate() {	
	
	  $Rebate    =    D("Rebate");
			
	  if($vo = $Rebate->create()) {
	 		
			 for($i=0;$i< $_POST["mun"];$i++){
				$Rebate-> price = $_POST["price"];
				//$Rebate-> rebateCode =  rand_string(4,2).date('mdHis',time()).rand_string(2,2).floor(microtime()*1000);
				$Rebate-> rebateCode =  rand_string(4,2).date('His',time()).floor(microtime()*1000);
				$Rebate-> beginTime = $_POST["beginTime"];
				$Rebate-> endTime = $_POST["endTime"];
				$Rebate-> add();
			}
	  
			$this->ajaxReturn($vo,'表单数据保存成功！',1); 
             
        }else{ 
            $this->error($Rebate->getError()); 
        }
		
	}

}
?>
