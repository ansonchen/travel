<?php
class UserAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Node = M('User'); 
		$count = $Node->count();//计算总数
		
		$p = new Page ( $count, 10 );
		
		$Mlist=$Node->limit($p->firstRow.','.$p->listRows)->order('id asc')->findAll();
		
		$p->setConfig('header','位用户');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
			
		//$Mlist = $Node->order('sort asc')->select(); 
		
		$this->assign('User',$Mlist);
		
		$this->display(); // 输出模板   
		
		}
	
	
	//取删除用户数据
	public function delete() {
		if(!empty($_GET['id'])) {
 
		 
		$User	=	M("User");
		$condition['id']	=	$_GET['id'];
		$vo = $User->where($condition)->find(); // 查询数据   
		
					
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
	// 删除用户
	public function delUser() {
		if(!empty($_POST['id'])) {
			$User	=	M("User");
			$result	=	$User->delete($_POST['id']);
			if(false !== $result) {
				$this->ajaxReturn($_POST['id'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	
	//取编辑用户数据
	public function edit() {
		if(!empty($_GET['id'])) {
 
		 
		$User	=	M("User");
		$condition['id']	=	$_GET['id'];
		$vo = $User->where($condition)->find(); // 查询数据   
		
					
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
	
	
	
	
	//更新用户
	public function updateUser(){
		if(!empty($_POST['id'])) {
		
			$User	=	D("User");
			
			if($vo = $User->create()) {
				$list=$User->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($User->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}

	
	//添加用户
	public function addUser() {	
	
	  $User    =    D("User"); 
	  
        if($vo = $User->create()) { 
            if(false!==$User->add()){ 
                $vo['id']     =    nl2br($vo['id']);
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'表单数据保存成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($User->getError()); 
        }
		
	}
	
	
	//修改密码页
	public function password(){
	$this->display(); 
	}
	
	//更改用户密码
	public function changeUserPassword(){
	if(!empty($_POST['id'])) {
		$map	=	array();
       // $map['password']= pwdHash($_POST['oldpassword']);
        $map['account']	 =	 $_POST['account'];
        $map['id']		=	 $_POST['id'];
		        //检查用户
        $User    =   D("User");
		$result = $User->create();   

		if (!$result){ 
		$this->error($User->getError());
		}
		else{
			if(!$User->where($map)->field('id')->find()) {
				$this->error('旧密码错误或者帐号不存在！');
			}else {
				$User->password	=	pwdHash($_POST['password']);
				$User->save();
				$this->success('密码修改成功！');
			 }
		 }
	} else{
			exit('编辑项不存在！');
		}
	}
	
	//更新用户状态
	public function updateStatus(){
	
		if(!empty($_GET['id'])) {
		
			$Role	=	D("User");
			$where['id'] = $_GET['id'];
			$data = array();
			$data['status'] = $_GET['status'];
			$Role->where($where)->save($data);
			if($Role!==false){
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
