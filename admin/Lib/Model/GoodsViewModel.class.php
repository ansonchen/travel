<?php
import('ViewModel');
class GoodsViewModel extends ViewModel {
    protected $viewFields = array(
        'Goods'=>array('id_goods','name_goods','price_goods','stock_goods','buys_goods','updateTime_goods','picturePath_goods','status_goods','sort_goods'), 
		'Type'=>array('name_type'=>'nameType', '_on'=>'Goods.typeId_goods=Type.id_type'), 
    );
}
?>