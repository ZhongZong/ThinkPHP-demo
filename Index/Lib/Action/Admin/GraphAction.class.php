<?php 
//图像统计图
Class GraphAction extends CommonAction{

	//3D饼图
	public function graph1(){
		import('ORG.Util.Chart');
        $chart = new Chart();
        $title = "3D饼图"; //标题
        $data = array(20,27,45,75,90,10,20,40); //数据
        $size = 140; //尺寸
        $width = 750; //宽度
        $height = 350; //高度
        $legend = array("aaaa ","bbbb","cccc","dddd ","eeee ","ffff ","gggg ","hhhh ");//说明
        $chart->create3dpie($title,$data,$size,$height,$width,$legend);
	}

	//柱状图 
    public function graph2(){
	    import('ORG.Util.Chart');
	    $chart = new Chart();
	    $title = "柱状图"; //标题
	    $data = array(20,27,45,75,90,10,80,100); //数据
	    $size = 140; //尺寸
	    $width = 750; //宽度
	    $height = 350; //高度
	    $legend = array("aaaa ","bbbb","cccc","dddd ","eeee ","ffff ","gggg ","hhhh ");//说明
	    $chart->createcolumnar($title,$data,$size,$height,$width,$legend);
    }

    //线图 
    function graph3(){
        import('ORG.Util.Chart');

        //获取数据库中的数据
        $database = M('users');
        $data=$database->order('logintime desc')->limit(1)->find();
        $date1 = $data['date'];
        $time['0']=strtotime($date1);
        $time['1']=$time['0']-86400;
        $time['2']=$time['0']-86400*2;
        $time['3']=$time['0']-86400*3;
        $time['4']=$time['0']-86400*4;
        $time['5']=$time['0']-86400*5;
        $time['6']=$time['0']-86400*6;
        for($i=0;$i<7;$i++){
            $date[$i]=date('Y-m-d',$time[$i]);
            
        }
        for($y=0;$y<7;$y++){
            $date2=$date[$y];
            $times[$y]=$database->where("date='$date2'")->count();
        }

        $chart = new Chart();
        $title = "最近一周登录次数统计"; //标题
        //$data = array(20,27,45,75,90,10,80,100); //数据
        $data=$times;
        $size = 140; //尺寸
        $width = 800; //宽度
        $height = 450; //高度
        //$legend = array("aaaa ","bbbb","cccc","dddd ","eeee ","ffff ","gggg ","hhhh ");//说明
        //$legend=array("2016-05-11","2016-05-10","2010-05-12","2010-05-13","2010-05-14","2010-05-15","2010-05-16");
        $legend=$date;
        $chart->createmonthline($title,$data,$size,$height,$width,$legend);
    }

    //环状图
    public function graph4(){
	    import('ORG.Util.Chart');
	    $chart = new Chart();
	    $title = "柱状图"; //标题
	    $data = array(20,27,45,75,90,10,80,100); //数据
	    $size = 140; //尺寸
	    $width = 750; //宽度
	    $height = 350; //高度
	    $legend = array("aaaa ","bbbb","cccc","dddd ","eeee ","ffff ","gggg ","hhhh ");//说明
	    $chart->createring($title,$data,$size,$height,$width,$legend);
    }

    //横柱图
    public function graph5(){
        import('ORG.Util.Chart');
        $chart = new Chart();
        $title = "柱商务图"; //标题
        $subtitle = "2012 年6月";
        $data = array(20,27,45,75,90,100,80,100,300,500,1000,200,300,100,400,600); //数据
        $size = 140; //尺寸
        $width = 750; //宽度
        $height = 350; //高度
        $legend = array("张三1","张三2","张三3","张三4","张三5","张三6","张三7","张三8");//说明
        $chart = new Chart();
        $chart->createhorizoncolumnar($title,$subtitle,$data,$size,$height,$width,$legend);
    }


}



 ?>