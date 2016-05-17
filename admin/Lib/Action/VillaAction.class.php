<?php
class VillaAction extends CommonAction {

    function _initialize() {
		
	
        //'别墅-地点','别墅-主题','别墅-卧室数量',
		$Zone = M("Zone");
        $zonewhere['pid'] = 2; 
		$ZoneDB = $Zone->where($zonewhere)->order('sort asc')->select(); 
		$this->assign('zone',$ZoneDB);
        
        $newtheme = array();        
        foreach ($ZoneDB as $key => $value)
        {        
            $newtheme[$value['id']] = $value['name'];
        }
        $this->assign('showzone',$newtheme);
        
        
        $zonewhere['pid'] = 3; 
		$ZoneDB = $Zone->where($zonewhere)->order('sort asc')->select(); 
		$this->assign('theme',$ZoneDB);
        
        $newtheme = array();
        foreach ($ZoneDB as $key => $value)
        {        
            $newtheme[$value['id']] = $value['name'];
        }
        $this->assign('showtheme',$newtheme);
        
        
        $zonewhere['pid'] = 4; 
		$ZoneDB = $Zone->where($zonewhere)->order('sort asc')->select(); 
		$this->assign('roomnum',$ZoneDB);
        
        $newtheme = array();
        
        foreach ($ZoneDB as $key => $value)
        {        
            $newtheme[$value['id']] = $value['name'];
        }
        $this->assign('showroomnum',$newtheme);
        
        
        
/*		
        $Rooms = M("Rooms");
		$Roomsdb = $Rooms->order('id asc')->select(); 
		$this->assign('rooms',$Roomsdb);*/
        
        
        //站点信息
		$site = M('site'); // 实例化模型类  
		 
		$condition['id_site']	=	1;
		
		$siteD = $site->where($condition)->find(); // 查询数据   
		
		$this->assign('site',$siteD); // 模板变量赋值
		
        
        
        $croom = array(            
        '浴室'=>['淋浴','泡浴','洗漱用品','毛巾','浴巾','拖鞋','吹风机','浴袍'],
        '卧室'=>['沙发','客厅角','书桌','用餐区','衣柜/衣橱','空调','电壶','微波炉','冰箱'],
        '娱乐/科技'=>['平面电视','DVD播放器','IOP插座播放器','电话','有线频道','收费电视','收音机'],
        '景色'=>['山景','海景','海滩景','悬崖景','市景'],            
        '前台服务'=>['24小时前台','外币兑换','旅游咨询','礼宾服务','行李寄存','储物柜','办理私人入住/退房手续','票务服务','自助提款机（酒店内部）'],                
        '洗衣服务'=>['每日清洁服务','洗衣','干洗','熨衣服务','擦洗服务'],
        '餐饮'=>['餐厅','酒吧','客房早餐','小吃','迷你吧','自助餐厅','节食餐单','特别节日餐单（应要求提供）'],
        '商务服务'=>['传真/复印','会议/宴会设施','商务中心'],
        '家庭服务'=>['婴儿/儿童看护服务'],
        '娱乐活动设施'=>['按摩','SPA水疗','自行车','健身房','泳池','户外BBQ','图书室','儿童游乐场','网球场','桑拿浴','土耳其浴','壁球','夜总会/DJ','游戏室','卡拉OK'],
        '综合服务'=>['客房服务','报纸','禁烟客房','蜜月客房','电梯','无障碍残疾人士设施','租车服务','班车服务（收费）','机场班车（收费）保险箱','唤醒服务 ','贵宾服务','理发/美容中心','礼品店','吸烟区'],
        '网络'=>['免费','提供无线WIFI'],
        '停车场'=>['无需预订','提供公共停车设施'],
        '宠物'=>['客人可携带宠物入住','可能收取额外费用','不允许携带宠物入住'],
        '语言'=>['德语','日语','法语','泰语','英语','西班牙语','荷兰语','中文']
        );
        
            

        $this->assign('croom',$croom);


        }
	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Hotels = D('HotelsView'); 

        $where['htype'] = 1;
//		$where['bORn_article'] = 'b';
//		if(!$_SESSION['administrator'])
//		{
//		$where['writerId_article']=  $_SESSION [C ( 'USER_AUTH_KEY' )];
//		}
		$count = $Hotels->where($where)->count();//计算总数
		$p = new Page ( $count, 10 );
		$Mlist=$Hotels->where($where)->limit($p->firstRow.','.$p->listRows)->order('id desc')->select();//findAll
		$p->setConfig('header','个别墅');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
			
       
       
		//$Mlist = $Node->order('sort_node asc')->select(); 
		
		$this->assign('hotels',$Mlist);
        
		
		$this->display(); // 输出模板   
		
		}
	
	

	// 删除酒店
	public function delHotels() {
		if(!empty($_POST['id'])) {
			$Hotels	=	M("Hotels");
			$result	=	$Hotels->delete($_POST['id']);
			if(false !== $result) {
				//删除图片
				$HotelsPic = M('HotelsPicture'); 
				$where['hotels_id'] = $_POST['id'];
				$HotelsPic->where($where)->delete();
                
/*                //删除房间
                $HotelsRooms = M('HotelsRooms'); 
                $hwhere['hotel_id'] = $_POST['id'];
                $HotelsRooms->where($hwhere)->delete();*/
                
                
//				//删除价格
//				$GoodsPri = M("GoodsPrice");
//				$GoodsPri->where($where)->delete();
						
				$this->ajaxReturn($_POST['id'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	
	//取编辑酒店数据
	public function edit() {
		if(!empty($_GET['id'])) {
 
		 
		$Hotels	=	M("Hotels");
		$condition['id']	=	$_GET['id'];
		$vo = $Hotels->where($condition)->find(); // 查询数据 
		//取图片
		$HotelsPic = M("HotelsPicture");
		$pic['hotels_id'] = $_GET['id'];
		$picVo = $HotelsPic->where($pic)->select();
		if($picVo){
		$this->assign('HotelsPic',$picVo);
		}
		
        //取房间

/*		$HotelsRooms = M("HotelsRooms");
        $hroom['hotel_id'] = $_GET['id'];
		$HotelsRoomsdb = $HotelsRooms->where($hroom)->select();
		if($HotelsRoomsdb){
		$this->assign('roomsList',$HotelsRoomsdb);
		}*/

			//$vo	=	$Node->getById($_GET['id_node']);
			//goodsPic
			if($vo) {
                $vo['attrList'] = explode(",",$vo['attr']);                 
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
	
	//查看酒店
	public function show(){
		
		if(!empty($_GET['id'])) {
 
		 
		$Goods	=	M("Goods");
		$condition['id_goods']	=	$_GET['id'];
		$vo = $Goods->where($condition)->find(); // 查询数据 
		//取图片
		$goodsPic = M("GoodsPicture");
		$pic['goods_id'] = $_GET['id'];
		$picVo = $goodsPic->where($pic)->select();
		if($picVo){
		$this->assign('goodsPic',$picVo);
		}
		//取价格
		$goodsPir = M("GoodsPrice");
		$pirVo = $goodsPir->where($pic)->select();
		if($pirVo){
		$this->assign('goodsPir',$pirVo);
		}
			//$vo	=	$Node->getById($_GET['id_node']);
			//goodsPic
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
	
	
	//更新酒店
	public function updateHotels(){
		if(!empty($_POST['id'])) {
		
             $attr = implode(",",$_POST['attr']); 
             $_POST['attr'] = $attr;
			$Hotels	=	D("Hotels");
			if($vo = $Hotels->create()) {
				$list=$Hotels->save();
				if($list!==false){
						//删除旧图片
						$HotelsPic = M('HotelsPicture'); 
						$where['hotels_id'] = $_POST['id'];
						$HotelsPic->where($where)->delete();
						//添加图片
						for($i=0;$i<count($_POST["path"]);$i++)
						{
						$HotelsPic->hotels_id	 =  $_POST['id'];
						$HotelsPic->path = $_POST["path"][$i];
						$HotelsPic->add();
						}
						
                /*
                        //删除旧房间
						$HotelsRooms = M('HotelsRooms'); 
						$hwhere['hotel_id'] = $_POST['id'];
						$HotelsRooms->where($hwhere)->delete();
						//添加房间
						for($i=0;$i<count($_POST["room"]);$i++)
						{
						$HotelsRooms->hotel_id	 =  $_POST['id'];
						$HotelsRooms->room_id = $_POST["room"][$i];
						$HotelsRooms->add();
						}*/
						
                        
						
				
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Hotels->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	

	//添加酒店
	public function addHotels() {
	//用D才会自动验证
        $attr = implode(",",$_POST['attr']); 
        $_POST['attr'] = $attr;
		$Hotels    =    D("Hotels"); 
        
       
        
       // print_r(implode(",",$_POST['attr']));
       // exit();
        if($vo = $Hotels->create()) {
			$id = $Hotels->add();
            if(false!==$id){ 
			
			//添加图片
			$HotelsPic    =    M("HotelsPicture");
			for($i=0;$i<count($_POST["path"]);$i++)
			{
			$HotelsPic->hotels_id	 =  $id;
			$HotelsPic->path = $_POST["path"][$i];
			$HotelsPic->add();
			}
                
            //添加房间
           /* 
            $Room    =    M("HotelsRooms");
			for($i=0;$i<count($_POST["room"]);$i++)
			{
			$Room->hotel_id	 =  $id;
			$Room->room_id = $_POST["room"][$i];
			$Room->add();
			}*/
                
			

			
           // $vo['id_goods']     =    nl2br($vo['id_goods']);
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'表单数据保存成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($Hotels->getError()); 
        }
		
	}	
	
	//更新上架状态
	public function updateStatus(){
	
		if(!empty($_GET['id_goods'])) {
		
			$Role	=	D("Goods");
			$where['id_goods'] = $_GET['id_goods'];
			$data = array();
			$data['status_goods'] = $_GET['status'];
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
