<?php
class RoomsAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		if(!empty($_GET['hotels_id'])) {
			
			
		
		$Type = D('RoomsView'); 
		
		$condition['hotels_id']	=	$_GET['hotels_id'];
		
		$Mlist=$Type->where($condition)->order('sort desc')->findAll();
			
		$this->assign('hotels_id',$_GET['hotels_id']);
		
		$this->assign('rooms',$Mlist);
		
			
		$this->display(); // 输出模板   
			
			
		}
	
		
		}
	
		//添加房间
	public function addRooms() {
	
	  $Type    =    D("Rooms"); 
	  
        if($vo = $Type->create()) { 
            if(false!==$Type->add()){ 
               // $vo['name_type']     =    nl2br($vo['name_type']);
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
		if(!empty($_GET['id'])) {
 
		 
		$Type	=	M("Rooms");
		$condition['id']	=	$_GET['id'];
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
	
		//更新房间
	public function updateRooms(){
		if(!empty($_POST['id'])) {
		
			$Type	=	D("Rooms");
			

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
		if(!empty($_GET['id'])) {
 
		 
		$Type	=	M("Rooms");
		$condition['id']	=	$_GET['id'];
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
	// 删除房间
	public function delRooms() {
		if(!empty($_POST['id'])) {
			$Type	=	M("Rooms");
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
	

	
	


}
?>
