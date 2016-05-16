<?php
class BooknowAction extends CommonAction{


    public function index(){
	$this->display();
    }

    public function GetRandStr($len)
    {
/*        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        ); */

        $chars = array(

            "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z"
        );

        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = "";
        for ($i=0; $i<$len; $i++)
        {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }

    public function add(){

         $Book    =    D("Book");
	     $return = array();
	 $ordernum = $this->GetRandStr(3).date('mdis');    
        // $ordernum = $this->GetRandStr(4).date('YmdHis').floor(microtime()*1000);
         $_POST['orderNumber'] = $ordernum;
        if($vo = $Book->create()) {
            if(false!==$Book->add()){

                $return['status'] = 1;
                $return['orderno']= $ordernum;
                $return['msg'] = '表单数据保存成功';
                //$this->ajaxReturn($vo,'表单数据保存成功！',1);
            }else{
                $return['status'] = 2;
                $return['msg'] ='数据写入错误，请重试！';
               //$this->error('数据写入错误！');
            }
        }else{
            $return['status'] = 0;
            $return['msg'] = $Book->getError();
            //$this->error($Book->getError());
        }

        echo json_encode($return);


    }

}
?>
