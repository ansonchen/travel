<?php
class CommentAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Msg = D('Message'); 
		
		$count = $Msg->where('form_type<>"Message"')->count();//计算总数
		$p = new Page ( $count, 10 );
		
		$Mlist=$Msg->where('form_type<>"Message"')->limit($p->firstRow.','.$p->listRows)->order('time desc,status asc')->findAll();
		
		$p->setConfig('header','个评论');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
		$this->assign('Message',$Mlist);
		//取用户数据
		$Member = M('User'); 
		$Mlist = $Member->order('id asc')->select(); 
		$this->assign('user',$Mlist);
		
		$this->assign( "nid", $_SESSION [C ( 'USER_AUTH_KEY' )]);

		$this->display(); // 输出模板   
		
		}
	
		//发送信息
	public function sendComment() {
	
	  $Msg    =    D("Message"); 
	  
	  
	  $auto = array ( 
		 array('time','time',1,'function') //自动添加时间
		);
	  $Msg -> setProperty("_auto",$auto);
	  
	  
        if($vo = $Msg->create()) { 
            if(false!==$Msg->add()){ 
                $vo['content']     =    htmlspecialchars(nl2br($vo['content']));
				$vo['time']     =   date('Y-m-d H:i:s',$vo['time']); 
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'信息发送成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($Msg->getError()); 
        }
		
	}
	
		
	//取数据
	public function say() {
		if(!empty($_GET['fid'])) {
 
		 
		$Msg	=	M("Message");
		
		$vo = $Msg->where('form_id='.$_GET["fid"].' and form_type="'.$_GET['type'].'"')->order('time asc')->select(); // 查询数据
		$data['status'] = 1; 
		$Msg->where('form_id='.$_GET["fid"])->save($data);
		
		if($vo) {

				$this->assign('fid',$_GET["fid"]);
				$this->assign('say',$vo);
				$this->display();
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
	
	
	
	

	// 删除信息
	public function delComment() {
		if(!empty($_GET['id'])) {
			$Msg	=	M("Message");
			$result	=	$Msg->delete($_GET['id']);
			if(false !== $result) {
				$this->ajaxReturn($_GET['id'],'删除成功！','msgP_'.$_GET['id']);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	

	
	


}
?>
