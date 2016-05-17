<?php
import('ViewModel');
class RoomsViewModel extends ViewModel {
    protected $viewFields = array(
        'Rooms'=>array('id','name','enname','picturePath','bed','person','other','sort','hotels_id'), 
    );
}
?>
