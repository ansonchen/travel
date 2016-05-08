<?php
import('ViewModel');
class ZoneViewModel extends ViewModel {
    protected $viewFields = array(
        'Zone'=>array('id','name','picturePath','other','sort','pid'), 
    );
}
?>