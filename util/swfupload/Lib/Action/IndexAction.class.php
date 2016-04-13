<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action{
    public function index(){
        header("Content-Type:text/html; charset=utf-8");
		
//		if(!isset($_SESSION['file_info'])){
//		 Session::set('file_info',array());
//		}
		
     	$this->display();
    }
	
	 public function upload() { 
        if(!empty($_FILES)) { 
            //如果有文件上传 上传附件 
            $this->_upload(); 
            //$this->forward(); 
        } 
    } 

		
		// 文件上传 
    protected function _upload() 
    { 
        import("ORG.Net.UploadFile"); 
        $upload = new UploadFile(); 
        //设置上传文件大小 
        $upload->maxSize  = 3292200 ; 
        //设置上传文件类型 
		
		$upload->allowExts  =array('jpg', 'gif', 'png', 'jpeg');
        //$upload->allowExts  = explode(',','jpg,gif,png,jpeg'); 
        //设置附件上传目录 
        $upload->savePath =  '../Uploads/';
		
        //是否子目录保存
		$upload->autoSub = true;
	    $upload->subType = 'date';
	    $upload->dateFormat = 'Ymd';
		
		//设置需要生成缩略图，仅对图像文件有效 
       $upload->thumb =  true; 
       //设置需要生成缩略图的文件后缀 
        $upload->thumbPrefix   =  'm_,s_';  //生产2张缩略图 
       //设置缩略图最大宽度 
        $upload->thumbMaxWidth =  '120,60'; 
       //设置缩略图最大高度 
        $upload->thumbMaxHeight = '140,60'; 
       //设置上传文件规则 
       $upload->saveRule = uniqid; 
       //删除原图 
      // $upload->thumbRemoveOrigin = true; 
        if(!$upload->upload()) { 
            //捕获上传异常 
            $this->error($upload->getErrorMsg()); 
        }else { 
            //取得成功上传的文件信息 
            $uploadList = $upload->getUploadFileInfo(); 
            $name  = $uploadList[0]['name']; 
			$savename  = $uploadList[0]['savename']; 
			$savepath =  $uploadList[0]['savepath'];//此处要增加USE_ID
			$size =  $uploadList[0]['size'];
			
			//保存当前数据对象
			$model = M ('Picture'); 
			$data['explain_picture'] = $name; //默认将原始名称写入说明
			$data['name_picture']=$name; 
			$data['path_picture']=$savepath.$savename; 
			$data['size_picture']=$size; 
			$data['time_picture']=time() ; 
			$list=$model->add ($data);
			 
			if($list!==false){ 
				$this->success ('上传图片成功！'); 
			}else{ 
				$this->error ('上传图片失败!'); 
			} 
			
			$this->success ($fileName .'上传图片成功！'); 
        } 
        
    } 
		
		
}
?>