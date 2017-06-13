<?php 
header('content-type:text/html;charset=utf-8;');

Class TestAction extends Action{

        public function index(){
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
                $data['temp'] = $arr['retData']['temp'];
                $data['l_tmp'] = $arr['retData']['l_tmp'];
                $data['h_tmp'] = $arr['retData']['h_tmp'];
                $data['WD'] = $arr['retData']['WD'];
                $data['WS'] = $arr['retData']['WS'];
                $data['sunrise'] = $arr['retData']['sunrise'];
                $data['sunset'] = $arr['retData']['sunset'];
                var_dump($data);
                die;
                $Content ="城市：". $arr['retData']['city']."\n".'天气：'.$arr['retData']['weather']."\n".'温度：'.$arr['retData']['temp'];
                var_dump($Content);
        }//百度天气查询结束 

        function index1(){
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
                function test1(){
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
                function test2(){
                import('ORG.Util.Chart');
                $chart = new Chart();
                $title = "柱状图"; //标题
                $data = array(20,27,45,75,90,10,80,100); //数据
                $size = 140; //尺寸
                $width = 750; //宽度
                $height = 350; //高度
                $legend = array("aaaa ","bbbb","cccc","dddd ","eeee ","ffff ","gggg ","hhhh ");//说明
                $chart->createmonthline($title,$data,$size,$height,$width,$legend);
        }

                //环状图
                function test3(){
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
                function test4(){
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