<?php
class MessageAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Msg = D('MessageView'); 
		
		$count = $Msg->where('receive_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].' and form_type="Message" or send_id='.$_SESSION [C ( 'USER_AUTH_KEY' )])->count();//计算总数
		$p = new Page ( $count, 10 );
		
		$Mlist=$Msg->where('receive_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].' and form_type="Message" or send_id='.$_SESSION [C ( 'USER_AUTH_KEY' )])->limit($p->firstRow.','.$p->listRows)->order('time desc,status asc')->findAll();
		
		$p->setConfig('header','个对话');

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
	public function sendMsg() {
	
	  $Msg    =    D("Message"); 
	  
	  
	  $auto = array ( 
		 array('time','time',1,'function') //自动添加时间
		);
	  $Msg -> setProperty("_auto",$auto);
	  
	  
        if($vo = $Msg->create()) { 
            if(false!==$Msg->add()){ 
                $vo['content']     =    nl2br($vo['content']);
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
		if(!empty($_GET['uid'])) {
 
		 
		$Msg	=	M("Message");
		
		$vo = $Msg->where('((send_id='.$_GET["uid"].' and receive_id='.$_SESSION[C('USER_AUTH_KEY')].') or ( send_id='.$_SESSION[C('USER_AUTH_KEY')].' and receive_id='.$_GET["uid"].' )) and form_type="Message"')->order('time asc')->select(); // 查询数据
		$data['status'] = 1; 
		$Msg->where('send_id='.$_GET["uid"])->save($data);
		
		if($vo) {
				//取用户数据
				$Member = M('User'); 
				$Mlist = $Member->order('id asc')->select(); 
				$this->assign('users',$Mlist);
				$this->assign('cid',$_GET["uid"]);
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
	public function delMsg() {
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
