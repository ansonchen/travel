<?php
import('ViewModel');
class HotelsRoomsViewModel extends ViewModel {
    protected $viewFields = array(
        'HotelsRooms'=>array('hotel_id','room_id'),
        'Rooms'=>array('id','name','enname','picturePath','bed','person','sort','include', '_on'=>'HotelsRooms.room_id=Rooms.id'),
        
    );
}
?>