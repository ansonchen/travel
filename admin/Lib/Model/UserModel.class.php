<?php
// 用户模型 CommonModel
class UserModel extends Model {
	public $_validate	=	array(
		array('account','/^[a-z]\w{3,}$/i','帐号格式错误'),
		array('account','','帐号已经存在',self::EXISTS_VAILIDATE,'unique',self::MODEL_INSERT),
		array('oldpassword','require','旧密码不能为空'),
		array('password','require','密码不能为空'),
		array('repassword','require','确认密码不能为空'),
		array('repassword','password','确认密码不一致',0,'confirm'),
		array('nickname','require','昵称不能为空'),
		array('trueName','require','真实姓名不能为空'),
		);

	public $_auto		=	array(
		array('password','pwdHash',self::MODEL_BOTH,'callback'),
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_UPDATE,'function'),
		);

	protected function pwdHash() {
		if(isset($_POST['password'])) {
			return pwdHash($_POST['password']);
		}else{
			return false;
		}
	}
}
?>