<?php 
//后台控制器
header("content-type:text/html;charset=utf8;");
Class IndexAction extends CommonAction{

//首页展示
	public function index(){
		$weather=$this->tianqi();
		$this->weather = $weather;
		// var_dump($weather);
		// die;
		$this->display();
	}

//展示登录信息
	public function logininfo(){
		import('ORG.Util.Pagelogin');
		$count=M('users')->order('logintime desc')->limit(60)->count();
		$page= new Page($count,10);
		$limit=$page->firstRow.','.$page->listRows;

		$logins=M('users')->order('logintime desc')->limit($limit)->select();
		$this->login=$logins;
		$this->page=$page->show();
		$this->display();
	}
//图标展示登录信息
	public function logininfo1(){
		// //获取数据库中的数据
        // $database = M('users');
        // $data=$database->order('logintime desc')->limit(1)->find();
        // $date1 = $data['date'];
        // $time['0']=strtotime($date1);
        // $time['1']=$time['0']-86400;
        // $time['2']=$time['0']-86400*2;
        // $time['3']=$time['0']-86400*3;
        // $time['4']=$time['0']-86400*4;
        // $time['5']=$time['0']-86400*5;
        // $time['6']=$time['0']-86400*6;
        // for($i=0;$i<7;$i++){
        // 	$date[$i]=date('Y-m-d',$time[$i]);
        	
        // }
        // for($y=0;$y<7;$y++){
        // 	$date2=$date[$y];
        // 	$times[$y]=$database->where("date='$date2'")->count();
        // }
        // var_dump($times);
        // var_dump($date);
        // die;
		// var_dump(time());
		// $date =date('Y-m-d',time());var_dump($date);
		// $time = strtotime($date); 
		// $time1=$time-86400;
		// var_dump(date('Y-m-d',$time1));
		// var_dump($time);
		// die;
		$this->display();
	}

//展示发布新闻
	public function upnews(){
		$this->display();
	}

//展示已发布新闻
	public function newslist(){
		import('ORG.Util.Pagenewslist');
		$count=M('news')->count();
		$page= new Page($count,11);
		$limit=$page->firstRow.','.$page->listRows;

		$allfiles=M('news')->order('time desc')->limit($limit)->select();
		$this->allfiles=$allfiles;
		$this->page=$page->show();
		$this->display();
	}

//展示留言列表
	public function messages(){
		import('ORG.Util.Pagemessages');
		$count=M('messages')->order('time desc')->count();
		$page= new Page($count,10);
		$limit=$page->firstRow.','.$page->listRows;

		$logins=M('messages')->order('time desc')->limit($limit)->select();
		$this->login=$logins;
		$this->page=$page->show();
		$this->display();
	}

//展示上传文件网页
	public function upfile(){
		$this->display();
	}

//查看已上传文件
	public function fileslist(){
		import('ORG.Util.Pagefiles');
		$count=M('files')->count();
		$page= new Page($count,11);
		$limit=$page->firstRow.','.$page->listRows;

		$allfiles=M('files')->order('time desc')->limit($limit)->select();
		$this->allfiles=$allfiles;
		$this->page=$page->show();
		$this->display();
	}

//删除留言
	public function delete_message(){
		$id=I('id','','intval');
		$messages=M('messages');
		$re= $messages->where("id=$id")->delete();
		if($re){
			$this->success('删除留言成功');
		}else{
			$this->success('删除留言失败');
		}
	}



//删除新闻
	public function delete_news(){
		$id = I('id','','intval');
		$news = M('news');
		$result = $news->where("id=$id")->delete();
		if($result){
			$this->success('删除成功');
		}else{
			$this->success('删除失败');
		}

	}

//修改新闻展示
	public function change_news(){
		$id = I('id','','intval');
		$news = M('news');
		$result = $news->where("id=$id")->select();
		$this->result=$result;
		$this->display();
	}

//新闻修改检测
	public function changenews_check(){
		if(!IS_POST) halt('页面不存在');
		$id = I('id');
		$result=M('news')->find($id);

		$myfile['imgname']=$result['imgname'];
		$myfile['imgpath']=$result['imgpath'];
		$myfile['click']=$result['click'];
		$myfile['time']=$result['time'];

		$myfile['title']=trim(I('title'));
	    $myfile['content']=I('content');
	    $myfile['source']=trim(I('source'));
	    $myfile['author']=trim(I('author'));
	    $re=M('news')->where("id=$id")->save($myfile);
	    if($re){
	    	$this->success('修改成功',U('Admin/Index/newslist'));
	    }else{
	    	$this->success('修改失败',U('Admin/Index/newslist'));
	    }
	}

//发布新闻检测
	public function news_check(){
		if(!IS_POST) halt('页面不存在');

		import('ORG.Net.UploadFile');
	    $upload = new UploadFile();// 实例化上传类
	    $upload->maxSize  = C('upload_max_size') ;// 设置附件上传大小
	    $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->savePath =  './Public/Uploads/news/';// 设置附件上传目录

	    $upload->imageClassPath = 'ORG.Util.Image';
	    $myfile['title']=trim(I('title'));
	    $myfile['content']=I('content');
	    $myfile['partnews']=substr($myfile['content'], 0,300);
	    $myfile['source']=trim(I('source'));
	    $myfile['author']=trim(I('author'));
	 	//var_dump($myfile);
		// die;
	    if($myfile['title']==''||$myfile['content']==''||$myfile['source']==''||$myfile['author']==''){
	    	$this->success('文件信息都不能为空');
	    	die;
	    }

	    if(!$upload->upload()) {// 上传错误提示错误信息
	        $this->error($upload->getErrorMsg());
	    }else{// 上传成功
	    	$info = $upload->getUploadFileInfo();
	    	$myfile['imgname']=$info[0]['savename'];
	    	$myfile['imgpath']=$info[0]['savepath'];
	    	$myfile['time']=time();

	    	import('ORG.Util.Image');
			Image::water($info[0]['savepath'].$info[0]['savename'], './public/images/Index/logo.png',$savename=null, $alpha=40); 
	    	$re=M('news')->add($myfile);
	    	if($re){
				$this->success('上传成功！',U('Admin/Index/upnews'));
	    	}else{
	    		$this->success('上传失败');
	    	}
	        
	    }

	}



//上传文件检测
	public function upload_check(){
		if(!IS_POST) halt('页面不存在');
		import('ORG.Net.UploadFile');
	    $upload = new UploadFile();// 实例化上传类
	    $upload->maxSize  = C('upload_max_size') ;// 设置附件上传大小
	    $upload->allowExts  = '';// 设置附件上传类型
	    $upload->savePath =  './Public/Uploads/files/';// 设置附件上传目录

	    $myfile['filename']=trim(I('filename'));
	    $myfile['author']=trim(I('author'));

	    if($myfile['filename']==''||$myfile['author']==''){
	    	$this->success('文件信息都不能为空');
	    	die;
	    }
	    if(!$upload->upload()) {// 上传错误提示错误信息
	        $this->error($upload->getErrorMsg());
	    }else{// 上传成功
	    	$info = $upload->getUploadFileInfo();
	    	$myfile['savename']=$info[0]['savename'];
	    	$myfile['filesize']=$info[0]['size'];
	    	$myfile['filepath']=$info[0]['savepath'];
	    	$myfile['filetype']=$info[0]['type'];
	    	$myfile['time']=time();
	    	$re=M('files')->add($myfile);
	    	if($re){
				$this->success('上传成功！',U('Admin/Index/upfile'));
	    	}else{
	    		$this->success('上传失败');
	    	}
	        
	    }
	}

/**
 * 文件删除
 */
 	public function delete($id=array('id')){
 		$files=M('files');
 		$file=$files->find($id);
 		$wenjian=$file['filepath'].$file['savename'];
 		$re=unlink($wenjian);
 		if($re){
 			$r=$files->where(array('id'=>$id))->delete();
 			if($r){
 				$this->success('删除成功',U('Admin/Index/fileslist'));
 			}else{
 				$this->error('删除失败');
 			}
 		}else{
 			$this->error('删除失败');
 		}

 	} 
/**
 * 文件修改
 */
	public function change(){
		$id=I('id','','intval');
		$file=M('files')->where(array('id'=>$id))->select();
		$this->assign('file',$file);
		$this->display();
	}
/**
 * 文件修改检测
 */
	public function change_check($id=array('id')){
		if(!IS_POST) halt('页面不存在');
		if(trim(I('filename'))=='' ||trim(I('author'))=='' ){
			$this->error('文件信息都不能为空');
		}
		// $id=I('id','','intval');
		//$data['id']=$id;
		$data['filename']=I('filename');
		$data['author']=I('author');
		$data['time']=time();
		$re=M('files')->where(array('id'=>$id))->save($data);
		if($re){
			$this->success('文件信息修改成功',U('Admin/Index/index'));
		}else{
			$this->error('信息修改失败');
		}

	}

//天气查询curl
	public function tianqi(){
        $ch = curl_init();
        $url = 'http://apis.baidu.com/apistore/weatherservice/cityname?cityname='.urlencode('广汉');
        $header = array(
            'apikey:8ac9963c1b0c6c8c80ab5f2adf40476b'
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);
        $arr = json_decode($res, true);
        $data['city'] = $arr['retData']['city'];
        $data['weather'] = $arr['retData']['weather'];
        $data['tianqi']='';
        switch ($data['weather']) {
        	case '阴':
        		$data['tianqi']='&#xe6f8;';
        		break;
        	case '阵雪':
        		$data['tianqi']='&#xe6fa;';
        		break;
        	case '阵雨':
        		$data['tianqi']='&#xe6fb;';
        		break;
        	case '中雪':
        		$data['tianqi']='&#xe6fc;';
        		break;
        	case '中雨':
        		$data['tianqi']='&#xe6fd;';
        		break;
        	case '多云':
        		$data['tianqi']='&#xe6f3;';
        		break;
        	case '雷电':
        		$data['tianqi']='&#xe6f4;';
        		break;
        	case '晴':
        		$data['tianqi']='&#xe6f5;';
        		break;
        	case '小雪':
        		$data['tianqi']='&#xe6f6;';
        		break;
        	case '小雨':
        		$data['tianqi']='&#xe6f7;';
        		break;
        	case '暴雪':
        		$data['tianqi']='&#xe6f1;';
        		break;
        	case '暴雨':
        		$data['tianqi']='&#xe6f2;';
        		break;
        	default:
        		$data['tianqi']='&#xe6ac;';
        		break;
        }
        $data['temp'] = $arr['retData']['temp'];
        $data['l_tmp'] = $arr['retData']['l_tmp'];
        $data['h_tmp'] = $arr['retData']['h_tmp'];
        $data['WD'] = $arr['retData']['WD'];
        $data['WS'] = $arr['retData']['WS'];
        $data['sunrise'] = $arr['retData']['sunrise'];
        $data['sunset'] = $arr['retData']['sunset'];
        return $data;
        die;
        var_dump($data);
        $Content ="城市：". $arr['retData']['city']."\n".'天气：'.$arr['retData']['weather']."\n".'温度：'.$arr['retData']['temp'];
        var_dump($Content);
    }//百度天气查询结束 


}

 ?>