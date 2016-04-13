<?php
class CommonAction extends Action {
		function _initialize() {
		
		
		//站点信息
		$site = M('site'); // 实例化模型类  
		 
		$condition['id_site']	=	1;
		
		$siteD = $site->where($condition)->find(); // 查询数据   
		
		$this->assign('site',$siteD); // 模板变量赋值
		
		//下拉列表用的菜单信息
		$menu = M('Node'); 
		$where['level']= array(2,1,'or'); 
		$where['status']=1;
	//	$where['show_status']=1;
		$Mlist = $menu->where($where)->order('id asc')->select(); 
		//$Mlist = $menu->order('sort asc')->select(); 
		//$this->assign('leftMenu',$Mlist);
		
		//用于下拉列表数据
		//$olist=$menu->order('sort asc')->select();
		$this->assign('omenu',$Mlist);
		
		
		$menub = M('Menu'); 
		$Mlistb = $menub->order('id asc')->select(); 
		$this->assign('menub',$Mlistb);
		
		$Type = M('Type'); 
		$twhere['buildId_type'] = $_SESSION [C ( 'USER_AUTH_KEY' )];
		$Tlist=$Type->where($twhere)->order('belongType_type asc')->select();		
		$this->assign('otype',$Tlist);
		
		

		
		
		
		
		// 用户权限检查
		if (C ( 'USER_AUTH_ON' ) && !in_array(MODULE_NAME,explode(',',C('NOT_AUTH_MODULE')))) {
			//import ( '@.ORG.RBAC' );
			import("ORG.Util.RBAC");
			if (! RBAC::AccessDecision ()) {
				//检查认证识别号
				if (! $_SESSION [C ( 'USER_AUTH_KEY' )]) {
					//跳转到认证网关
					redirect ( PHP_FILE . C ( 'USER_AUTH_GATEWAY' ) );
				}
				// 没有权限 抛出错误
				if (C ( 'RBAC_ERROR_PAGE' )) {
					// 定义权限错误页面
					redirect ( C ( 'RBAC_ERROR_PAGE' ) );
				} else {
				
					if (C ( 'GUEST_AUTH_ON' )) {
						$this->assign ( 'jumpUrl', PHP_FILE . C ( 'USER_AUTH_GATEWAY' ) );
					}
					// 提示错误信息
					
					$this->error ( L ( '_VALID_ACCESS_' ) );
				}
			}
		}
	}
	
		function tb_json_encode($value, $options = 0){

			return json_encode(tb_json_convert_encoding($value, "GBK", "UTF-8"));
		
		}
		
		//转化函数，用它代替原本的json_encode函数，可以对汉字进行转化，排除了出现null的问题
		
		function tb_json_decode($str, $assoc = false, $depth = 512) {
		
			return tb_json_convert_encoding(json_decode($str, $assoc), "UTF-8", "GBK");
		
		} //同上，他是把原本转化成字符串的函数重新转化为数组（在使用时参数$assoc应为true，才是数组），转化后编码格式变为GBK
		
		function tb_json_convert_encoding($m, $from, $to) {
			
			switch(gettype($m)) {
			
			case 'integer':
			
			case 'boolean':
			
			case 'float':
			
			case 'double':
			
			case 'NULL':
			
			return $m;
			
			case 'string':
			
			return mb_convert_encoding($m, $to, $from);
			
			case 'object':
			
			$vars = array_keys(get_object_vars($m));
			
			foreach($vars as $key) {
			
			$m->$key = tb_json_convert_encoding($m->$key, $from ,$to);
			
			}
			
			return $m;
			
			case 'array':
			
			foreach($m as $k => $v) {
			
			$m[tb_json_convert_encoding($k, $from, $to)] = tb_json_convert_encoding($v, $from, $to);
			
			}
			
			return $m;
			
			default:
			
			}
			
			return $m;
		
		}//编码转化函数，主要用于进行编码的转化


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