<?php 
/**
 * 自定义 Redis SESSION处理机制
 */
Class SessionRedis{
	private $reids;
	public function execute(){
		session_set_save_handler(
			array($this,'open'),
			array($this,'close'),
			array($this,'read'),
			array($this,'write'),
			array($this,'destory'),
			array($this,'gc')
			);
	}

	public function open($path,$name){
		$this->redis = new Redis();
		return $this->redis->connect(C('REDIS_HOST'),C('REDIS_PORT'));

	}
	public function close(){

	}
	public function read($id){

	}
	public function write($id,$data){

	}
	public function destory($id){

	}
	public function gc($maxLifeTime){

	}
}


 ?>