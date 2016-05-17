<?php
class GimgAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		import("ORG.Util.Page"); 
	
		$Type = D('GimgView'); 
		$count = $Type->count();//计算总数
		
		$p = new Page ( $count, 30 );
/*		$where['id_type'] = array('neq',1); 
		$where['buildId_type']=  $_SESSION [C ( 'USER_AUTH_KEY' )];*/
		//$Mlist=$Type->where($where)->limit($p->firstRow.','.$p->listRows)->order('belongType_type asc')->findAll();
		$Mlist=$Type->limit($p->firstRow.','.$p->listRows)->order('id asc')->findAll();
		
		$p->setConfig('header','个图片');

		$p->setConfig('prev',"&laquo; 上一页");
		$p->setConfig('next','下一页 &raquo;');
		$p->setConfig('first','&laquo; 第一页');
		$p->setConfig('last','最后一页 &raquo;');
		$page = $p->show ();
		$this->assign( "page", $page );
		$this->assign('gimg',$Mlist);
		$this->display(); // 输出模板   
		
		}
	public function build(){
        
        $DB = D('GimgView'); 
        $DBlist = $DB->order('sort asc')->select(); 
		//$this->assign('menub',$DBlist);
        //$code =  str_replace("\\/", "//",json_encode($DBlist));
        $code = json_encode($DBlist);
        $content = 'var indexdb ='.$code.';';
        
       
                         
       // $content = file_get_contents("http://localhost/a.php");//得到文件执行的结果
        $of = fopen('../Public/indexDB.js','w');//创建并打开dir.txt
        if($of){
         fwrite($of,$content);//把执行文件的结果写入txt文件
         $this->ajaxReturn('','成功！',1);   
        }
        fclose($of);
        //$this->display(); // 输出模板 

    }
		//添加分类
	public function addGimg() {
	
	  $Type    =    D("Gimg"); 
	  
	  

	  
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
 
		 
		$Type	=	M("Gimg");
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
	
		//更新分类
	public function updateGimg(){
		if(!empty($_POST['id'])) {
		
			$Type	=	D("Gimg");
			

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
 
		 
		$Type	=	M("Gimg");
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
	// 删除分类
	public function delGimg() {
		if(!empty($_POST['id'])) {
			$Type	=	M("Gimg");
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
