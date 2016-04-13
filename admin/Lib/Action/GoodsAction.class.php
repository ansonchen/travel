<?php
class GoodsAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Goods = D('GoodsView'); 

//		$where['bORn_article'] = 'b';
//		if(!$_SESSION['administrator'])
//		{
//		$where['writerId_article']=  $_SESSION [C ( 'USER_AUTH_KEY' )];
//		}
		$count = $Goods->count();//计算总数
		$p = new Page ( $count, 10 );
		$Mlist=$Goods->limit($p->firstRow.','.$p->listRows)->order('updateTime_goods desc')->select();//findAll
		$p->setConfig('header','个商品');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
			
		//$Mlist = $Node->order('sort_node asc')->select(); 
		
		$this->assign('goods',$Mlist);

		
		$this->display(); // 输出模板   
		
		}
	
	

	// 删除商品
	public function delGoods() {
		if(!empty($_POST['id_goods'])) {
			$Goods	=	M("Goods");
			$result	=	$Goods->delete($_POST['id_goods']);
			if(false !== $result) {
				//删除图片
				$GoodsPic = M('GoodsPicture'); 
				$where['goods_id'] = $_POST['id_goods'];
				$GoodsPic->where($where)->delete();
				//删除价格
				$GoodsPri = M("GoodsPrice");
				$GoodsPri->where($where)->delete();
						
				$this->ajaxReturn($_POST['id_goods'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	
	//取编辑商品数据
	public function edit() {
		if(!empty($_GET['id_goods'])) {
 
		 
		$Goods	=	M("Goods");
		$condition['id_goods']	=	$_GET['id_goods'];
		$vo = $Goods->where($condition)->find(); // 查询数据 
		//取图片
		$goodsPic = M("GoodsPicture");
		$pic['goods_id'] = $_GET['id_goods'];
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
		//取卡密
		$goodsCard = M("GoodsCard");
		$cardVo = $goodsCard->where($pic)->select();
		if($cardVo){
		$this->assign('goodsCard',$cardVo);
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
	
	//查看商品
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
	
	
	//更新商品
	public function updateGoods(){
		if(!empty($_POST['id_goods'])) {
		
			$Goods	=	D("Goods");
			if($vo = $Goods->create()) {
				$list=$Goods->save();
				if($list!==false){
						//删除旧图片
						$GoodsPic = M('GoodsPicture'); 
						$where['goods_id'] = $_POST['id_goods'];
						$GoodsPic->where($where)->delete();
						//添加图片
						for($i=0;$i<count($_POST["path"]);$i++)
						{
						$GoodsPic->goods_id	 =  $_POST['id_goods'];
						$GoodsPic->path = $_POST["path"][$i];
						$GoodsPic->add();
						}
						
						//删除旧价格
						$GoodsPri = M("GoodsPrice");
						$GoodsPri->where($where)->delete();
						
						//添加价格
						for($j=0;$j<count($_POST["price"]);$j++)
						{
						$GoodsPri->goods_id	 =  $_POST['id_goods'];
						$GoodsPri->title = $_POST["title"][$j];
						$GoodsPri->price = $_POST["price"][$j];
						$GoodsPri->param = $_POST["param"][$j];
						$GoodsPri->add();
						}
						//删除旧卡密
						$GoodsCard = M("GoodsCard");
						$GoodsCard->where($where)->delete();
						//添加卡密
						for($k=0;$k<count($_POST["number"]);$k++)
						{
						$GoodsCard->goods_id	 =  $_POST['id_goods'];
						$GoodsCard->number = $_POST["number"][$k];
						$GoodsCard->password = $_POST["password"][$k];
						$GoodsCard->add();
						}
				
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Goods->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	

	//添加商品
	public function addGoods() {
	//用D才会自动验证
		$Goods    =    D("Goods"); 
        if($vo = $Goods->create()) {
			$id = $Goods->add();
            if(false!==$id){ 
			
			//添加图片
			$GoodsPic    =    M("GoodsPicture");
			for($i=0;$i<count($_POST["path"]);$i++)
			{
			$GoodsPic->goods_id	 =  $id;
			$GoodsPic->path = $_POST["path"][$i];
			$GoodsPic->add();
			}
			
			
			//添加价格
			$GoodsPri = M("GoodsPrice");
			for($j=0;$j<count($_POST["price"]);$j++)
			{
			$GoodsPri->goods_id	 =  $id;
			$GoodsPri->title = $_POST["title"][$j];
			$GoodsPri->price = $_POST["price"][$j];
			$GoodsPri->param = $_POST["param"][$j];
			$GoodsPri->add();
			}
			
			//添加卡密
			$GoodsCard = M("GoodsCard");
			for($k=0;$k<count($_POST["number"]);$k++)
			{
			$GoodsCard->goods_id	 =  $id;
			$GoodsCard->number = $_POST["number"][$k];
			$GoodsCard->password = $_POST["password"][$k];
			$GoodsCard->add();
			}
			
           // $vo['id_goods']     =    nl2br($vo['id_goods']);
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'表单数据保存成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($Goods->getError()); 
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
