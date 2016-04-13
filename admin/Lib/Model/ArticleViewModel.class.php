<?php
import('ViewModel');
class ArticleViewModel extends ViewModel {
    protected $viewFields = array(
        'Article'=>array('id_article','title_article','subtitle_article','summary_article','content_article','writer_article','writerId_article','updateTime_article'), 
		'Type'=>array('name_type'=>'nameType', '_on'=>'Article.typeIds_article=Type.id_type'), 
    );
}
?>
