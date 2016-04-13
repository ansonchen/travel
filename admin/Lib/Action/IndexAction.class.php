<?php
class IndexAction extends CommonAction {

	protected function checkUser() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('jumpUrl','Public/login');
			$this->error('没有登录');
		}
	}
	

    
	// 框架首页 CommonAction
	public function index() {
        $this->checkUser();
		
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
            //显示菜单项
            $menu  = array();
            if(isset($_SESSION['menu'.$_SESSION[C('USER_AUTH_KEY')]])) {

                //如果已经缓存，直接读取缓存
                $menu   =   $_SESSION['menu'.$_SESSION[C('USER_AUTH_KEY')]];
            }else {
                //读取数据库模块列表生成菜单项
                $node    =   M("Node");
				$id	=	$node->getField("id");
				$where['level']=2;
				$where['status']=1;
				$where['show_status']=1;
				$where['pid']=$id;
                $list	=	$node->where($where)->field('id,name,group_id,title')->order('sort asc')->select();
                $accessList = $_SESSION['_ACCESS_LIST'];
                foreach($list as $key=>$module) {
                     if(isset($accessList[strtoupper(APP_NAME)][strtoupper($module['name'])]) || $_SESSION['administrator']) {
                        //设置模块访问权限
                        $module['access'] =   1;
                        $menu[$key]  = $module;
                    }
                }
                //缓存菜单访问
                $_SESSION['menu'.$_SESSION[C('USER_AUTH_KEY')]]	=	$menu;
            }

			//dump($menu);
            $this->assign('leftMenu',$menu);
		}
		
		$info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
           // 'ThinkPHP版本'=>THINK_VERSION.' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'=>round((@disk_free_space(".")/(1024*1024)),2).'M',
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
            );
        $this->assign('info',$info);
		
		//显示未读信息数量
		$Msg = M("Message");
		$count = $Msg->where('receive_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].' and status=0')->count();//计算总数
		$this->assign('msgCount',$count);
	//	C('SHOW_RUN_TIME',false);			// 运行时间显示
	//	C('SHOW_PAGE_TRACE',false);
		$this->display();
	}

	
	
	// 用户登出
    public function logout()
    {
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
            $this->assign("jumpUrl",__URL__.'/login/');
            $this->success('登出成功！');
        }else {
            $this->error('已经登出！');
        }
    }
	
	//修改当前用户密码
	public function changePassword(){
		$this->checkUser();
        //对表单提交处理进行处理或者增加非表单数据

		$map	=	array();
        $map['password']= pwdHash($_POST['oldpassword']);
        $map['id']		=	$_SESSION[C('USER_AUTH_KEY')];

        //检查用户
        $User    =   D("User");
		$result = $User->create();   

		if (!$result){ 
		$this->error($User->getError());
		}
		else{
			if(!$User->where($map)->field('id')->find()) {
				$this->error('旧密码错误！');
			}else {
				$User->password	=	pwdHash($_POST['password']);
				$User->save();
				$this->success('密码修改成功！');
			 }
		 }
    }
	
	
	//搜索
	public function searchGo(){
	if(!empty($_POST['key'])) {
	
		$data['key'] = $_POST['key'];
		$data['dataBase'] = $_POST['dataBase'];
		Session::set('key', $data['key']);
		$this->ajaxReturn($data,Session::get('key').'正在搜索',1);
		//$this->display();
		}else{
			$this->error('没有输入关键字！');
		}
	
	}
	//搜索
	public function search(){
	
	$key = Session::get('key');
	
	$db = $_GET['DB'] ? $_GET['DB'] : $_POST['dataBase'];
	
	//$key = preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $key);//输出中文
	$this->assign( "nid", $_SESSION [C ( 'USER_AUTH_KEY' )]);
	$this->assign("key",Session::get('key'));
	switch($db){
		case 'all'://所有
				//订单
				$Order = M("Order");
				$list    =    $Order->where("no_order like '%".$key."%'")->select(); 
				$count = $Order->where("no_order like '%".$key."%'") ->count();//计算总数
				$this->assign('Order',$list); 
				//分类 
				$Type    = D("TypeView"); 
				$list    =    $Type->where("name_type like '%".$key."%'")->select(); 
				$count += $Type->where("name_type like '%".$key."%'") ->count();//计算总数 
				$this->assign('type',$list); 
				//商品分类
				$Gtype    = M("GoodsType"); 
				$list    =    $Gtype->where("name like '%".$key."%'")->select(); 
				$count += $Gtype->where("name like '%".$key."%'") ->count();//计算总数
				$this->assign('gtype',$list); 
				//商品 
			 	$Goods    = M("Goods"); 
				$list    =    $Goods->where("name_goods like '%".$key."%'")->select(); 
				$count += $Goods->where("name_goods like '%".$key."%'") ->count();//计算总数
				$this->assign('Goods',$list); 
				//优惠码
				$Rebate    = M("Rebate"); 
				$list    =    $Rebate->where("rebateCode like '%".$key."%' or price ='".$key."'")->select(); 
				$count += $Rebate->where("rebateCode like '%".$key."%' or price ='".$key."'") ->count();//计算总数
				$this->assign('Rebate',$list); 
				//文章
				$Article    = D("ArticleView"); 
				if(!$_SESSION['administrator'])
				{
				$list    =    $Article->where("bORn_article = 'b' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or summary_article like '%".$key."%' ) and ( writerId_article = ".$_SESSION [C ( 'USER_AUTH_KEY' )].")")->select(); 
				$count += $Article->where("bORn_article = 'b' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or summary_article like '%".$key."%' ) and ( writerId_article = ".$_SESSION [C ( 'USER_AUTH_KEY' )].")") ->count();//计算总数
				}else{
				$list    =    $Article->where("bORn_article = 'b' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or summary_article like '%".$key."%' )")->select(); 
				$count += $Article->where("bORn_article = 'b' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or summary_article like '%".$key."%' )") ->count();//计算总数
				}
				$this->assign('Article',$list); 
				//新闻
				$News    = D("ArticleView"); 
				if(!$_SESSION['administrator'])
				{
				$list    =    $News->where("bORn_article = 'n' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or subtitle_article like '%".$key."%' ) and ( writerId_article = ".$_SESSION [C ( 'USER_AUTH_KEY' )].")")->select(); 
				$count += $News->where("bORn_article = 'n' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or subtitle_article like '%".$key."%' ) and ( writerId_article = ".$_SESSION [C ( 'USER_AUTH_KEY' )].")") ->count();//计算总数
				}
				else{
				$list    =    $News->where("bORn_article = 'n' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or subtitle_article like '%".$key."%' )")->select(); 
				$count += $News->where("bORn_article = 'n' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or subtitle_article like '%".$key."%' )") ->count();//计算总数
				}
				$this->assign('News',$list);
				//信息
				$Message    = D("MessageView"); 
				$list    =    $Message->where('(receive_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].' and form_type="Message" or send_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].') and (trueName like "%'.$key.'%" or name  like "%'.$key.'%" or content like "%'.$key.'%")')->select(); 
				$count += $Message->where('(receive_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].' and form_type="Message" or send_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].') and (trueName like "%'.$key.'%" or name like "%'.$key.'%" or content like "%'.$key.'%")') ->count();//计算总数
				$this->assign('Message',$list);
				//菜单
				$Node    = M("Node"); 
				$list    =    $Node->where("name like '%".$key."%' or title like '%".$key."%'")->select(); 
				$count += $Node->where("name like '%".$key."%' or title like '%".$key."%'") ->count();//计算总数
				$this->assign('Menus',$list); 
				//用户
				$User    = M("User"); 
				$list    =    $User->where("account like '%".$key."%' or trueName like '%".$key."%' or tel like '%".$key."%' or qq like '%".$key."%' or nickname like '%".$key."%'")->select(); 
				$count += $User->where("account like '%".$key."%' or trueName like '%".$key."%' or tel like '%".$key."%' or qq like '%".$key."%' or nickname like '%".$key."%'") ->count();//计算总数
				$this->assign('User',$list);

			 $this->assign('count',$count); 
			 $this->assign("db",'all');
		break;
		case 'Comment'://评论
			 $this->assign("db",'Comment');
		break;
		case 'Order'://订单搜索
			 $Order = M("Order");
			 $list    =    $Order->where("no_order like '%".$key."%'")->select(); 
			 $count = $Order->where("no_order like '%".$key."%'") ->count();//计算总数
			 $this->assign('count',$count); 
			 $this->assign('Order',$list); 
			 $this->assign("db",'Order');
			 
		break;
		case 'Type'://分类
			$Type    = D("TypeView"); 
			$list    =    $Type->where("name_type like '%".$key."%'")->select(); 
			$count = $Type->where("name_type like '%".$key."%'") ->count();//计算总数
			$this->assign('count',$count); 
			$this->assign('type',$list); 
			$this->assign("db",'Type');
		break;
		case 'Gtype'://商品分类
			$Gtype    = M("GoodsType"); 
			$list    =    $Gtype->where("name like '%".$key."%'")->select(); 
			$count = $Gtype->where("name like '%".$key."%'") ->count();//计算总数
			$this->assign('count',$count); 
			$this->assign('gtype',$list); 
			$this->assign("db",'Gtype');
		break;
		case 'Goods'://商品
		
			    $Goods    = M("Goods"); 
				$list    =    $Goods->where("name_goods like '%".$key."%'")->select(); 
				$count = $Goods->where("name_goods like '%".$key."%'") ->count();//计算总数
				$this->assign('count',$count); 
				$this->assign('Goods',$list); 
			 	$this->assign("db",'Goods');
				
		break;
		case 'Rebate'://优惠码
				//优惠码
				$Rebate    = M("Rebate"); 
				$list    =    $Rebate->where("rebateCode like '%".$key."%' or price ='".$key."'")->select(); 
				$count = $Rebate->where("rebateCode like '%".$key."%' or price ='".$key."'") ->count();//计算总数
				$this->assign('count',$count);
				$this->assign('Rebate',$list);
				$this->assign("db",'Rebate');
		break;
				
		case 'Article'://文章
				$Article    = D("ArticleView"); 
				if(!$_SESSION['administrator'])
				{
				$list    =    $Article->where("bORn_article = 'b' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or summary_article like '%".$key."%' ) and ( writerId_article = ".$_SESSION [C ( 'USER_AUTH_KEY' )].")")->select(); 
				$count = $Article->where("bORn_article = 'b' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or summary_article like '%".$key."%' ) and ( writerId_article = ".$_SESSION [C ( 'USER_AUTH_KEY' )].")") ->count();//计算总数
				}else{
				$list    =    $Article->where("bORn_article = 'b' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or summary_article like '%".$key."%' )")->select(); 
				$count = $Article->where("bORn_article = 'b' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or summary_article like '%".$key."%' )") ->count();//计算总数
				}
				
				$this->assign('count',$count); 
				$this->assign('Article',$list); 
			 $this->assign("db",'Article');
		break;
		case 'News'://新闻
				$News    = D("ArticleView"); 
				if(!$_SESSION['administrator'])
				{
				$list    =    $News->where("bORn_article = 'n' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or subtitle_article like '%".$key."%' ) and ( writerId_article = ".$_SESSION [C ( 'USER_AUTH_KEY' )].")")->select(); 
				$count = $News->where("bORn_article = 'n' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or subtitle_article like '%".$key."%' ) and ( writerId_article = ".$_SESSION [C ( 'USER_AUTH_KEY' )].")") ->count();//计算总数
				}
				else{
				$list    =    $News->where("bORn_article = 'n' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or subtitle_article like '%".$key."%' )")->select(); 
				$count = $News->where("bORn_article = 'n' and ( writer_article like '%".$key."%' or title_article like '%".$key."%' or subtitle_article like '%".$key."%' )") ->count();//计算总数
				}
				$this->assign('count',$count); 
				$this->assign('News',$list); 
			 $this->assign("db",'News');
		break;
		case 'Message'://信息
		
				$Message    = D("MessageView"); 
				$list    =    $Message->where('(receive_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].' and form_type="Message" or send_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].') and (trueName like "%'.$key.'%" or name like "%'.$key.'%" or content like "%'.$key.'%")')->select(); 
				$count = $Message->where('(receive_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].' and form_type="Message" or send_id='.$_SESSION [C ( 'USER_AUTH_KEY' )].') and (trueName like "%'.$key.'%" or name like "%'.$key.'%" or content like "%'.$key.'%")') ->count();//计算总数
				$this->assign('count',$count);
				$this->assign('Message',$list);
				$this->assign("db",'Message');
				
		break;
		case 'User'://用户
		
				$User    = M("User"); 
				$list    =    $User->where("account like '%".$key."%' or trueName like '%".$key."%' or tel like '%".$key."%' or qq like '%".$key."%' or nickname like '%".$key."%'")->select(); 
				$count = $User->where("account like '%".$key."%' or trueName like '%".$key."%' or tel like '%".$key."%' or qq like '%".$key."%' or nickname like '%".$key."%'") ->count();//计算总数
				$this->assign('count',$count);
				$this->assign('User',$list);
			 	$this->assign("db",'User');
		break;
		case 'Menus'://菜单
			$Node    = M("Node"); 
			$list    =    $Node->where("name like '%".$key."%' or title like '%".$key."%'")->select(); 
			$count = $Node->where("name like '%".$key."%' or title like '%".$key."%'") ->count();//计算总数
			$this->assign('count',$count); 
			$this->assign('Menus',$list); 
			 $this->assign("db",'Menus');
		break;
		
		default:
			 $this->assign("db",'No DateBase!');
		
		
		}
		
	//$this->ajaxReturn($key,$key.'搜索完成',1);
	$this->display();
	
	
	}

}
?>
