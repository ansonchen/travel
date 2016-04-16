<?php
class GetorderAction extends CommonAction{


    public function index(){

    $number = $_GET['order'];

     $this->assign('order',$number);

	$this->display();
    }


}
?>
