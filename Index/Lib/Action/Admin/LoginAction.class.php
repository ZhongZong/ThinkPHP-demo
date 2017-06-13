<?php 
/**
 * 登录控制器
 */
Class LoginAction extends Action{
/**
 * 展示登录页
 */
	public function index(){
		$this->display();
	}
/**
 * 检测登录
 */
	public function login(){
		if(!IS_POST) halt('页面不存在');

		if(I('verify','','md5') != session('verify')){
			$this->error('验证码错误,请刷新验证码后重新输入');
		}
		$data['username']=I('username');
		$data['password']=I('password','','md5');
		$data['logintime']=time();
		$data['date']=date('Y-m-d',$data['logintime']);
		$data['loginip']=get_client_ip();
		$users=M('users');
		$re=$users->where(array('username'=>$data['username']))->order('id desc')->limit(1)->find();
		if(!$re||$re['password']!=$data['password']){
			$this->success('帐号不存在或密码错误',U('Admin/Login/index'));
			die;
		}
		session('uid',$re['id']);
		session('username',$re['username']);
		$re=$users->add($data);
		if($re){
			$this->success('登录成功',U('Admin/Index/index'));
		}else{
			$this->error('登录失败');
		}
		
	}
/**
 * 修改密码
 */
	public function change_password(){
		if(!isset($_SESSION['uid']) ||!isset($_SESSION['username'])){
			$this->redirect('Admin/Login/index');
		}
		
		$this->display();
	}
/**
 * 验证密码修改
 */
	public function pwd_check(){
		if(!IS_POST) halt('页面不存在');
		if(I('verify','','md5') != session('verify')){
			$this->error('验证码错误,请刷新验证码后重新输入');
		}
		$data['username']=$_SESSION['username'];
		$data['password']=I('oldpwd','','md5');
		$data['newpwd']=I('newpwd','','md5');
		$users=M('users');
		$re=$users->where(array('username'=>$data['username'],'password'=>$data['password']))->order('id desc')->limit(1)->find();
		// var_dump($_POST);
		// var_dump($data);
		// var_dump($re);
		// die;
		if(!$re||$re['password']!=$data['password']){
			$this->success('帐号不存在或旧密码错误',U('Admin/Index/change_password'));
			die;
		}
		$new['password']=$data['newpwd'];
		$r=$users->where(array('username'=>$data['username'],'password'=>$data['password']))->order('id desc')->limit(1)->save($new);
		if($r){
			$this->success('修改成功',U('Admin/Index/index'));
		}else{
			$this->error('修改失败');
		}

	}



/**
 * 验证码
 */
	public function verify(){
		import('ORG.Util.Image');
		Image::buildImageVerify(4,1,'png');
	}



}

 ?>