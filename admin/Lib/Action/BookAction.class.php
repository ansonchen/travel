<?php
class BookAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {

        $key = $_GET['key'];
        
		import("ORG.Util.Page");

		$Type = D('BookView');
		$count = $Type->where("orderNumber like '%".$key."%' or name like '%".$key."%' or  mobile like '%".$key."%'")->count();//计算总数

		$p = new Page ( $count, 10 );
/*		$where['id_type'] = array('neq',1);
		$where['buildId_type']=  $_SESSION [C ( 'USER_AUTH_KEY' )];*/
		//$Mlist=$Type->where($where)->limit($p->firstRow.','.$p->listRows)->order('belongType_type asc')->findAll();
        
            
		$Mlist=$Type->where("orderNumber like '%".$key."%' or name like '%".$key."%' or  mobile like '%".$key."%'")->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll();

		$p->setConfig('header','个预订');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
		$this->assign('books',$Mlist);
        $this->assign('key',$key);
		$this->display(); // 输出模板

		}


    
	//取编辑数据
	public function show() {
		if(!empty($_GET['id'])) {

		$Type	=	M("Book");
		$condition['id']	=	$_GET['id'];
		$vo = $Type->where($condition)->find(); // 查询数据

			if($vo) {
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('预订不存在！');
			}
		}else{
			exit('预订不存在！');
		}
	}
    
    	//搜索
	public function searchGo(){
        
	if(!empty($_POST['key'])) {
	
		$data['key'] = $_POST['key'];
		//Session::set('key', $data['key']);
		//$this->ajaxReturn($data,'正在搜索: <b>'.Session::get('key').'</b>',1);
        $this->ajaxReturn($data,'正在搜索: <b>'.$_POST['key'].'</b>',1);
		}else{
            $this->ajaxReturn('','没有输入关键字!',2);
		}
	
	}


}
?>
