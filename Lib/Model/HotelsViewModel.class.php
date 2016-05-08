<?php
import('ViewModel');
class HotelsViewModel extends ViewModel {
    protected $viewFields = array(
        'Hotels'=>array('id','name','enname','type','zone_id','star','picturePath_goods','sort','htype','roomnum','theme','acttype','actgroup'), 
		//'Zone'=>array('name'=>'zname', '_on'=>'Hotels.zone_id=Zone.id'), 
    );
}
?>