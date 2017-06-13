<?php 
/**
 * 文件大小换算
 */
	function bk($b){
	if($b>1048576){
		$mb=$b/1048576;
		$value=round($mb,3);
		return $value.' M';

	}else{
		$kb=$b/1024;
		$value=round($kb);
		return $value.' K';
	}

}


 ?>