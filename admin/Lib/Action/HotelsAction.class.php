<?php
class HotelsAction extends CommonAction {

    function _initialize() {
		
	
		$Zone = M("Zone");
		$ZoneDB = $Zone->order('id asc')->select(); 
		$this->assign('zone',$ZoneDB);
		
        $Rooms = M("Rooms");
		$Roomsdb = $Rooms->order('id asc')->select(); 
		$this->assign('rooms',$Roomsdb);
        
        }
	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Hotels = D('HotelsView'); 

//		$where['bORn_article'] = 'b';
//		if(!$_SESSION['administrator'])
//		{
//		$where['writerId_article']=  $_SESSION [C ( 'USER_AUTH_KEY' )];
//		}
		$count = $Hotels->count();//计算总数
		$p = new Page ( $count, 10 );
		$Mlist=$Hotels->limit($p->firstRow.','.$p->listRows)->order('id desc')->select();//findAll
		$p->setConfig('header','个酒店');

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
                
                //删除房间
                $HotelsRooms = M('HotelsRooms'); 
                $hwhere['hotel_id'] = $_POST['id'];
                $HotelsRooms->where($hwhere)->delete();
                
                
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

		$HotelsRooms = M("HotelsRooms");
        $hroom['hotel_id'] = $_GET['id'];
		$HotelsRoomsdb = $HotelsRooms->where($hroom)->select();
		if($HotelsRoomsdb){
		$this->assign('roomsList',$HotelsRoomsdb);
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
						}
						
                        
						
				
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
		$Hotels    =    D("Hotels"); 
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
            
            $Room    =    M("HotelsRooms");
			for($i=0;$i<count($_POST["room"]);$i++)
			{
			$Room->hotel_id	 =  $id;
			$Room->room_id = $_POST["room"][$i];
			$Room->add();
			}
                
			

			
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
