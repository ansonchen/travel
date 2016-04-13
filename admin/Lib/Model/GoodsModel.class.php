<?php
class GoodsModel extends Model { 

    // 自动验证设置 
    protected $_validate     =     array( 
         array('name_goods','require','商品名称不能为空！',1),
		 array('price_goods','require','价格不能为空！',1),
//        array('email','email','邮箱格式错误！',2), 
//        array('content','require','内容必须'), 
//        array('title','','标题已经存在',0,'unique',self::MODEL_INSERT), 
        ); 
	public $_auto		=	array(
		array('time_goods','time',self::MODEL_INSERT,'function'),
		array('updateTime_goods','time',self::MODEL_UPDATE,'function'),
		);
}
?>  