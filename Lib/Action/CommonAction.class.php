<?php
class CommonAction extends Action {
		function _initialize() {
		
		if(!$_COOKIE['randomCode']){

		$cartSession = md5(uniqid(rand())); 
		
		setcookie('randomCode', $cartSession, time() + 14400); 
		
		}

		//$randomCode = Session::id();
		//$randomCode = $_COOKIE['randomCode'];
		//$this->assign('shoppingcartid', $_COOKIE['randomCode']);
	
	
		
			//站点数据
		$site = M('site'); 
		$condition['id_site']	=	1;
		$siteList = $site->where($condition)->find(); 
		$this->assign('site',$siteList);  
		
		//分类信息
		$Type = D('Type');
		$goodsType = $Type->where('belongType_type="Goods"')->select();//商品分类
		//$newsType = $Type->where('belongType_type="News"')->select();//新闻分类
		$this->assign('goodsType',$goodsType);
	
		}

	/**
     +----------------------------------------------------------
	 * 取得操作成功后要返回的URL地址
	 * 默认返回当前模块的默认操作
	 * 可以在action控制器中重载
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	function getReturnUrl() {
		return __URL__ . '?' . C ( 'VAR_MODULE' ) . '=' . MODULE_NAME . '&' . C ( 'VAR_ACTION' ) . '=' . C ( 'DEFAULT_ACTION' );
	}
    

}
?>