<?php
// 本类由系统自动生成，仅供测试用途
class HotelitemAction extends CommonAction{
    
    
    public function index(){

	//使用utf-8编码    
	//header("Content-Type:text/html; charset=utf-8");
      if(!empty($_GET['id'])) {

            $Hotels = M("Hotels");
            $hotw['id'] = $_GET['id'];
            $HotelsVo = $Hotels->where($hotw)->find();     //find取一条记录
          

            if($HotelsVo){
                
                $this->assign('ho',$HotelsVo);              

                //取图片
                $HotelsPic = M("HotelsPicture");
                $pic['hotels_id'] = $_GET['id'];
                $picVo = $HotelsPic->where($pic)->select();
                $this->assign('Hpic',$picVo);
                
                //取房间

                $HotelsRooms = D("HotelsRoomsView");
                $hroom['hotel_id'] = $_GET['id'];
                $HotelsRoomsdb = $HotelsRooms->where($hroom)->order('sort asc')->select();
                $this->assign('roomsList',$HotelsRoomsdb);
                
            }

      }else{
                $this->error('不存在！');
            }

	
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