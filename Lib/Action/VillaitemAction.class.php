<?php
// 本类由系统自动生成，仅供测试用途
class VillaitemAction extends CommonAction{
    
    
    public function index(){

	//使用utf-8编码    
	//header("Content-Type:text/html; charset=utf-8");
      if(!empty($_GET['id'])) {
        
        
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

            $Hotels = M("Hotels");
            $hotw['id'] = $_GET['id'];
            $HotelsVo = $Hotels->where($hotw)->find();     //find取一条记录
          

            if($HotelsVo){
                $HotelsVo['attrList'] = explode(",",$HotelsVo['attr']);   
                $this->assign('ho',$HotelsVo);              
                
                //取图片
                $HotelsPic = M("HotelsPicture");
                $pic['hotels_id'] = $_GET['id'];
                $picVo = $HotelsPic->where($pic)->select();
                
                foreach($picVo as $k => $v){
                
                    $picVo[$k]['mpath'] = str_replace("xl_","m_",$v['path']);
                
                }
                
                $this->assign('Hpic',$picVo);
                
                //取房间

                $HotelsRooms = D("HotelsRoomsView");
                $hroom['hotel_id'] = $_GET['id'];
                $HotelsRoomsdb = $HotelsRooms->where($hroom)->order('sort asc')->select();
                
                foreach($HotelsRoomsdb as $k => $v){                
                    $HotelsRoomsdb[$k]['mpath'] = str_replace("s_","m_",$v['picturePath']);                
                }
                
                $this->assign('roomsList',$HotelsRoomsdb);
                $this->display();
            }
            else{
                $this->error('页面不存在！');
            }

      }else{
                $this->error('页面不存在！');
            }

	

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