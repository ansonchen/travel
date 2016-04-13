<?php
import('ViewModel');
class GimgViewModel extends ViewModel {
    protected $viewFields = array(
        'Gimg'=>array('id','name','enname','path','link','g_id','type','sort'), 
    );
}
?>