<?php
import('ViewModel');
class BookViewModel extends ViewModel {
    protected $viewFields = array(
        'Book'=>array('id','name','time','orderNumber','mobile','taobaoid','taobaoorder'),
    );
}
?>
