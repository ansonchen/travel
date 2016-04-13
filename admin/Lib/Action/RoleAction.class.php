<?php
class RoleAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Role = M('Role'); 
		$count = $Role->count();//计算总数
		
		$p = new Page ( $count, 10 );
		
		$Mlist=$Role->limit($p->firstRow.','.$p->listRows)->order('id asc')->findAll();
		
		$list= $Role->order('id asc')->select();
		
		$p->setConfig('header','个角色');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
			
		//$Mlist = $Node->order('sort_node asc')->select(); 
		
		$this->assign('role',$Mlist);
		$this->assign('oRole',$list);
		
		$this->display(); // 输出模板   
		
		}
	
	
	//取删除角色数据
	public function delete() {
		if(!empty($_GET['id'])) {
 
		 
		$Role	=	M("Role");
		$condition['id']	=	$_GET['id'];
		$vo = $Role->where($condition)->find(); // 查询数据 
		$list= $Role->order('id asc')->select();
		$this->assign('oRole',$list); 
		
					
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
	// 删除角色
	public function delRole() {
		if(!empty($_POST['id'])) {
			$Role	=	M("Role");
			$result	=	$Role->delete($_POST['id']);
			if(false !== $result) {
				$this->ajaxReturn($_POST['id'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	//用户列表页
	public function userList(){
	if(!empty($_GET['id'])) {
		
		header("Content-Type:text/html; charset=utf-8");
	
		//显示所有用户
		$Member = M('User'); 
		$Mlist = $Member->order('id asc')->select(); 
		$this->assign('selectMember',$Mlist);
		
		//取用户角色表
		$rouser = M('RoleUser'); 
		$wherer['role_id']=$_GET['id']; 
		$Alist = $rouser->where($wherer)->field('user_id')->select(); 
	
		$this->assign('userList',$Alist);
		
		
		$this->display();
		
	}else{
			exit('编辑项不存在！');
		}
	
	}
	//用户角色保存
	public function userRoleList(){
	if(!empty($_POST['id'])) {
	
	//先删除以前的角色
		$rouser = M('RoleUser'); 
		$where['role_id'] = $_POST['id'];
		$rouser->where($where)->delete();
		
		for($i=0;$i<count($_POST["id_user"]);$i++)
			{

			$rouser->role_id = $_POST["id"];
			$rouser->user_id = $_POST["id_user"][$i];
			$rouser->add();
			}
		 $this->ajaxReturn($_POST["id"],'角色设置成功！',1); 
	
	}else{
			exit('编辑项不存在！');
		}
	
	
	
	}
	
	
	//授权页
	public function access(){
	if(!empty($_GET['id'])) {
	
		//显示授权菜单
		$menu = M('Node'); 
		//$where['level_node']=2; //二级菜单
		//$where['status_node']=1;//状态可用
		//$Mlist = $menu->where($where)->order('sort asc')->select(); 
		$Mlist = $menu->order('sort asc')->select(); 
		$this->assign('selectMenu',$Mlist);
		
		//取授权表
		//roleId_access 
		$Access = M('Access'); 
		$wherer['role_id']=$_GET['id']; 
		//$where['status_node']=1;//状态可用
		$Alist = $Access->where($wherer)->field('node_id')->select(); 
	
		$this->assign('access',$Alist);
		
		
		$this->display();
		
	}else{
			exit('编辑项不存在！');
		}
	
	}
	//授权保存
	public function accessRole(){
	if(!empty($_POST['id'])) {
	
	//先删除以前的权限
		$Access = M('Access'); 
		$where['role_id'] = $_POST['id'];
		$Access->where($where)->delete();
		
		for($i=0;$i<count($_POST["id_node"]);$i++)
			{
			$Node = M('Node');
			$wheren['id']=$_POST["id_node"][$i];
			$vo= $Node->where($wheren)->find();
			
			$Access->role_id = $_POST["id"];
			$Access->node_id = $vo["id"];
			$Access->level = $vo["level"];
			$Access->pid = $vo["pid"];
			
			$Access->add();
			}
		 $this->ajaxReturn($_POST["id"],'权限设置成功！',1); 
	
	}else{
			exit('编辑项不存在！');
		}
	
	
	
	}
	//取编辑角色数据
	public function edit() {
		if(!empty($_GET['id'])) {
 
		 
		$Role	=	M("Role");
		$condition['id']	=	$_GET['id'];
		$vo = $Role->where($condition)->find(); // 查询数据   
		$list= $Role->order('id asc')->select();
		$this->assign('oRole',$list);
		
					
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
	
	
	
	
	//更新角色
	public function updateRole(){
		if(!empty($_POST['id'])) {
		
			$Role	=	D("Role");
			$auto = array ( 
		 // array('creatTime','time',2,'function'), 
		 array('updateTime','time',2,'function') //自动添加时间
		);
		  $Role -> setProperty("_auto",$auto);
		  
			if($vo = $Role->create()) {
				$list=$Role->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Role->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	
	//更新角色状态
	public function updateStatus(){
	
		if(!empty($_GET['id'])) {
		
			$Role	=	D("Role");
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
	//添加角色
	public function addRole() {	
	
	  $Role    =    D("Role"); 
	  $auto = array ( 
		  array('creatTime','time',1,'function'), //自动添加时间
		 array('updateTime','time',1,'function') //自动添加时间
		);
		  $Role -> setProperty("_auto",$auto);
        if($vo = $Role->create()) { 
            if(false!==$Role->add()){ 
                $vo['name']     =    nl2br($vo['name']);
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'添加角色成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($Role->getError()); 
        }
		
	}

}
?>
