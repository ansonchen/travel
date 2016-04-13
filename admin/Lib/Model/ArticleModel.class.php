<?php
// 用户模型 CommonModel
class ArticleModel extends Model {

	public $_validate	=	array(
		array('title_article','require','标题不能为空'),
		array('subtitle_article','require','副标题不能为空'),
		array('summary_article','require','摘要不能为空'),
		array('content_article','require','内容不能为空'),
		
		);

	public $_auto		=	array(
		array('time_article','time',self::MODEL_INSERT,'function'),
		array('updateTime_article','time',3,'function'),
		);

}
?>