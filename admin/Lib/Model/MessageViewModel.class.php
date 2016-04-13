<?php
import('ViewModel');
class MessageViewModel extends ViewModel {
    protected $viewFields = array(
        'Message'=>array('id','content','time','name','receive_id','send_id','status','form_type'), 
        'User'=>array('trueName'=>'sendName', '_on'=>'Message.receive_id=User.id'),
    );
}
?>
