<?php
import('ViewModel');
class TypeViewModel extends ViewModel {
    protected $viewFields = array(
        'Type'=>array('id_type','name_type','level_type','pId_type','buildId_type','belongType_type','time_type'), 
        'User'=>array('trueName'=>'builder', '_on'=>'Type.buildId_type=User.id'),
    );
}
?>