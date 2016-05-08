<?php
class VillalistAction extends CommonAction{
    
    
    public function index(){
    import("ORG.Util.Page"); 
	//使用utf-8编码    
	//header("Content-Type:text/html; charset=utf-8");
    $zone = M('Zone');
    $zonewhere['pid'] = 2; 
    $zonelist = $zone->where($zonewhere)->order('sort asc')->select();         
    $this->assign('zone',$zonelist);
        
     $newtheme = array();        
    foreach ($zonelist as $key => $value)
        {        
            $newtheme[$value['id']] = $value['name'];
        }
    $this->assign('showzone',$newtheme);
        

         $zonewhere['pid'] = 3; 
    $zonelist = $zone->where($zonewhere)->order('sort asc')->select();         
    $this->assign('theme',$zonelist);
    
        foreach ($zonelist as $key => $value)
        {        
            $newtheme[$value['id']] = $value['name'];
        }
    $this->assign('showtheme',$newtheme);
        
         $zonewhere['pid'] = 4; 
    $zonelist = $zone->where($zonewhere)->order('sort asc')->select();         
    $this->assign('roomnum',$zonelist);
      
          foreach ($zonelist as $key => $value)
        {        
            $newtheme[$value['id']] = $value['name'];
        }
    $this->assign('showroomnum',$newtheme);
        
    
    
    $Hotel = D('HotelsView'); 
        
    $where = array();
    
    if(!empty($_GET['zone']) ){
        $where['zone_id'] = $_GET['zone'];
        $this->assign('zid',$_GET['zone']);    
    }
        
    if(!empty($_GET['theme']) ){
        $where['theme'] = $_GET['theme'];
        $this->assign('themeid',$_GET['theme']);    
    }
        
    if(!empty($_GET['roomnum']) ){
        $where['roomnum'] = $_GET['roomnum'];
        $this->assign('roomnumid',$_GET['roomnum']);    
    }
        

    $where['htype'] = 1;
    
    
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
