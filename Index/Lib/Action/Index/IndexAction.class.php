<?php
header('content-type:text/html;charset=UTF-8;');
// 前台控制器
class IndexAction extends Action {
//首页展示
    public function index(){
    	$news = M('news');
    	$show = $news->order('time desc')->limit(8)->select();
    	$this->news =$show;
		$this->display();
    }

 //更多新闻展示
    public function tongzhi(){
    	import('ORG.Util.PageTongZhi');
		$count=M('news')->count();
		$page= new Page($count,9);
		$limit=$page->firstRow.','.$page->listRows;

		$allnews=M('news')->order('time desc')->limit($limit)->select();
		$this->allnews=$allnews;
		$this->page=$page->show();
    	$this->display();
    }

//文件下载展示
    public function files(){
    	import('ORG.Util.PageIndexFiles');
		$count=M('files')->count();
		$page= new Page($count,11);
		$limit=$page->firstRow.','.$page->listRows;

		$allfiles=M('files')->order('time desc')->limit($limit)->select();
		$this->allfiles=$allfiles;
		$this->page=$page->show();
		$this->display();
    }

//下载文件
    public function download(){
		header('content-type:text/html;charset=UTF-8;');
		$id = I('id','','intval');
		$re=M('files')->find($id);
		$filename=$re['filepath'].$re['savename'];
		// var_dump($re);
		// die;
		// $filename=$_GET['filename'];
		header('content-disposition:attachment;filename='.basename($filename));
		header('content-length:'.filesize($filename));
		readfile($filename);
	}

//留言展示
    public function messages(){
    	$this->display();
    }

//新闻内容展示
    public function details(){
    	$id = I('id','','intval');
    	$re=M('news')->find($id);
    	if($re){
    		$re['click']++;
    		$result=M('news')->save($re);
    		$new=M('news')->where("id=$id")->select();

    	}else{
    		$this->error('未查询到新闻',U('Index/Index/index'));
    	}
    	$this->new=$new;
    	$this->display();
    }

//搜索页展示
    public function Search(){
        //$name=$_REQUEST['search'];
        //var_dump($name);
        //die;
        //if($_REQUEST['search']==null){
         //   $_REQUEST['search']=$_GET['search'];
        //}
        $name=$_REQUEST['search']=trim($_REQUEST['search']);
        $keywords = '%'.$_REQUEST['search'].'%';
        $where['title|content'] = array('like',$keywords); 

        $sear['search'] = array('like','%'.$name.'%');

        $starttime = explode(' ',microtime());//查询前的时间

        import('ORG.Util.PageSearch');
        $count=M('news')->where($where)->order('time desc')->count();
        $page= new Page($count,7);

        //分页跳转的时候保证查询条件  
        foreach($sear as $key=>$val) {
           $page->parameter   .=   "$key=".urlencode($name)."&";//赋值给Page
        }


        $limit=$page->firstRow.','.$page->listRows;

        $allnews=M('news')->where($where)->order('time desc')->limit($limit)->select();

        $endtime = explode(' ',microtime());//查询后的时间
        $thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
        $thistime = round($thistime,3);//计算所花时间，精确到三位小数

        //判断输入是否为空或未查询到结果
        if($_REQUEST['search'] =='' || $allnews==null){
            $this->no='true';
            $this->tip='没有搜索结果!';
            $allnews=null;
        }else{
            $this->page=$page->show();
        }


        $this->allnews=$allnews;
        $this->key=$_REQUEST['search'];
        $this->time=$thistime;
        //$data = M('news')->where($where)->select();

        $this->display();
    }

//留言检测 
    public function message_check(){
        if(!IS_POST) halt('页面不存在');
        if(I('verify','','md5') != session('verify')){
            $this->error('验证码错误,请刷新验证码后重新输入');
            die();
        }
        $database = M('student');
        $messages=M('messages');
        $data['username']=I('username');
        $data['password']=I('password');
        $data['content'] = I('content');
        $data['time']=time();
        $data['email'] = I('email');
        $result = $database->where(array('Sno'=>$data['username']))->find();
        $re= $messages->where(array('username'=>$data['username']))->order('time desc')->limit(1)->select();
        if($result['Spwd']==$data['password']){
            if($data['time']-$re[0][time]>86400){
                $re=$messages->add($data);
                if($re){
                    $this->success('留言成功',U('Index/Index/index'));
                }else{
                    $this->error('留言失败');
                }
            }else{
                $date=date('Y-m-d H:i:s',$re[0]['time']);
                $this->error('留言失败!上次留言时间：'.$date);
            }
        }else{
            $this->error('学号密码错误，留言失败');
            die;
        }

       

    }



    public function time(){
        $starttime = explode(' ',microtime());
         echo microtime();
         /*········以下是代码区·········*/
         for($i=0;$i<1000000;$i++){
          $i;
         }
         /*········以上是代码区·········*/
         //程序运行时间
         $endtime = explode(' ',microtime());
         $thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
         $thistime = round($thistime,3);
         echo "本网页执行耗时：".$thistime." 秒。".time();
    }

}