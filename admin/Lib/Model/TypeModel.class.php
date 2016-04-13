<?php
class TypeModel extends Model { 

    // 自动验证设置 
    protected $_validate     =     array( 
         array('name_type','require','名称不能为空！',1),
//        array('email','email','邮箱格式错误！',2), 
//        array('content','require','内容必须'), 
//        array('title','','标题已经存在',0,'unique',self::MODEL_INSERT), 
        ); 

}
?>  