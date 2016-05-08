<?php
class ZoneAction extends CommonAction {

     function _initialize() {
         
         $zonelist = array(
            
            '酒店-地点','酒店-星级',
            '别墅-地点','别墅-主题','别墅-卧室数量',
            '活动-地点','活动-类型','活动-适合人群','活动-主题'
        );
         
         $this->assign( "pzlist", $zonelist );
         
                 
        //站点信息
		$site = M('site'); // 实例化模型类  
		 
		$condition['id_site']	=	1;
		
		$siteD = $site->where($condition)->find(); // 查询数据   
		
		$this->assign('site',$siteD); // 模板变量赋值
         
     }
	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Type = D('ZoneView'); 
		$count = $Type->count();//计算总数
        
        
        
        
		
		$p = new Page ( $count, 100 );
/*		$where['id_type'] = array('neq',1); 
		$where['buildId_type']=  $_SESSION [C ( 'USER_AUTH_KEY' )];*/
		//$Mlist=$Type->where($where)->limit($p->firstRow.','.$p->listRows)->order('belongType_type asc')->findAll();
		$Mlist=$Type->limit($p->firstRow.','.$p->listRows)->order('pid asc')->findAll();
		
		$p->setConfig('header','个区域');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
        
		$this->assign( "page", $page );
		$this->assign('zone',$Mlist);
		$this->display(); // 输出模板   
		
		}
	
		//添加区域
	public function addZone() {
	
	  $Type    =    D("Zone"); 
	  
        if($vo = $Type->create()) { 
            if(false!==$Type->add()){ 
               // $vo['name_type']     =    nl2br($vo['name_type']);
				   //date('Y-m-d H:i:s',$vo['create_time']); 
                $this->ajaxReturn($vo,'表单数据保存成功！',1); 
            }else{ 
               $this->error('数据写入错误！'); 
            } 
        }else{ 
            $this->error($Type->getError()); 
        }
		
	}
	
		
	//取编辑数据
	public function edit() {
		if(!empty($_GET['id'])) {
 
		 
		$Type	=	M("Zone");
		$condition['id']	=	$_GET['id'];
		$vo = $Type->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$Node->getById($_GET['id_node']);
			
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
	
		//更新区域
	public function updateZone(){
		if(!empty($_POST['id'])) {
		
			$Type	=	D("Zone");
			

			if($vo = $Type->create()) {
				$list=$Type->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Type->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	
	
	
	//取删除菜单数据
	public function delete() {
		if(!empty($_GET['id'])) {
 
		 
		$Type	=	M("Zone");
		$condition['id']	=	$_GET['id'];
		$vo = $Type->where($condition)->find(); // 查询数据   
		
					
			//$vo	=	$Node->getById($_GET['id_node']);
			
			if($vo) {
				$this->assign('vo',$vo);
				$this->display();
			}else{
				exit('删除项不存在！');
			}
		}else{
			exit('删除项不存在！');
		}
	}
	// 删除区域
	public function delZone() {
		if(!empty($_POST['id'])) {
			$Type	=	M("Zone");
			$result	=	$Type->delete($_POST['id']);
			if(false !== $result) {
				$this->ajaxReturn($_POST['id'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	

	
	


}
?>