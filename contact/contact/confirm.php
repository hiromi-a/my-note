<?php
header('X-FRAME-OPTIONS: SAMEORIGIN');

session_start();

if(!($_POST['token'] == $_SESSION['token'] && !empty($_POST['token']))) {
//if(!(hash_equals($_POST['token'], $_SESSION['token']) && !empty($_POST['token']))) {
	echo 'Error: 通信エラーにより中断されました。<br><a href=contact.php>戻って再入力をお願いします。</a>';
    exit();
}









$html = file_get_contents("_confirm.html");


foreach ($_POST as $key => $value) {
	if(is_array($value)){
		$value = implode(", ",$value);
	}
	$html = str_replace('%'.$key.'%',mySafeString($value),$html);
}


echo $html;




function mySafeString($str){
	$str = preg_replace('/\"/','”',$str);
	$str = preg_replace('/\\\/','￥',$str);
	$str = preg_replace('/&/','＆',$str);
	$str = preg_replace('/\$/','＄',$str);
	$str = preg_replace('/<|>|\{|\}|\[|\]/','',$str);
	$str = preg_replace('/\!/','！',$str);
	$str = preg_replace('/\?/','？',$str);
	$str = preg_replace('/\*/','＊',$str);
	return $str;
}

?>