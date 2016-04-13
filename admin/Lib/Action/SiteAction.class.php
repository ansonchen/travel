<?php
class SiteAction extends CommonAction {

	// 框架首页 CommonAction
	public function index() {
	
		$this->display(); // 输出模板   
		
		}
	
	
	
		//更新站点信息
	public function editSite(){
		if(!empty($_POST['id_site'])) {
		
			$Site	=	D("Site");
	  
			if($vo = $Site->create()) {
				$list=$Site->save();
				if($list!==false){
					$this->success('数据更新成功！');
				}else{
					$this->error("没有更新任何数据!");
				}
			}else{
				$this->error($Site->getError());
			}	
		
		} else{
			exit('编辑项不存在！');
		}
	
	}
	

	

	
	


}
?>
