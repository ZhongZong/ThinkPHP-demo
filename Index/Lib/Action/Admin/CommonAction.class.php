<?php 

Class CommonAction extends Action{

	public function _initialize(){
		if(!isset($_SESSION['uid']) ||!isset($_SESSION['username'])){
			$this->redirect('Index/Index/index');
		}
	}

	public function logout(){
		session_unset();
		session_destroy();
		$this->redirect('Index/Index/index');
	}

}


 ?>