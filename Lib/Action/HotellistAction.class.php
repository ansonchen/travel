<?php
// 本类由系统自动生成，仅供测试用途
class HotellistAction extends CommonAction{
    
    
    public function index(){
    import("ORG.Util.Page"); 
	//使用utf-8编码    
	//header("Content-Type:text/html; charset=utf-8");
    $zone = M('Zone');
    $zonelist = $zone->order('sort asc')->select();         
    $this->assign('zone',$zonelist);
        
    
    $Hotel = D('HotelsView'); 
        
    $where = array();
        if(!empty($_GET['zone']) ){
        $where['zone_id'] = $_GET['zone'];
        $this->assign('zid',$_GET['zone']);    
    }
    
    if(!empty($_GET['star']) ){
        $star = ['无','一','二','三','四','五','无'];
        $where['star'] = $star[$_GET['star']];
        $this->assign('sid',$_GET['star']); 
    }
	
    
    
    $count = $Hotel->where($where)->count();//计算总数
        
        

    $p = new Page ( $count,12 );
        
    $Mlist=$Hotel->where($where)->limit($p->firstRow.','.$p->listRows)->order('sort asc')->findAll();

    $p->setConfig('header','个酒店');

    $p->setConfig('prev',"&laquo; 上一页");
    $p->setConfig('next','下一页 &raquo;');
    $p->setConfig('first','&laquo; 第一页');
    $p->setConfig('last','最后一页 &raquo;');
    $page = $p->show ();
    $this->assign( "page", $page );
    $this->assign('hotels',$Mlist);

		
	
	$this->display();
    }
	
	
	//生成验证码
	public function code() 
    {
		$type	 =	 isset($_GET['type'])?$_GET['type']:'gif';
        import("ORG.Util.Image");
		Image::UPCA('15819817119');
       // Image::buildImageVerify(4,1,$type);
    }

}
?>