<?php
header('X-FRAME-OPTIONS: SAMEORIGIN');

session_start();

if(!($_POST['token'] == $_SESSION['token'] && !empty($_POST['token']))) {
//if(!(hash_equals($_POST['token'], $_SESSION['token']) && !empty($_POST['token']))) {
	unset($_SESSION['token']);
    header('Location: '.($_SERVER['HTTPS'] ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/thanks.html');
	exit();
}

unset($_SESSION['token']);








$masterMail = 'ishida@arrival-quality.com';



$to = $masterMail;
$header = 'From: '.$masterMail."\r\n";
$subject = 'お問い合わせがありました';

$messageTop = ''."\n\n";





$returnSubject = 'お問い合わせが完了しました';

$returnMessageTop = <<<_returnMessageTopEnd
お問い合わせいただきありがとうございました。
お問い合わせを受け付けました。

折り返し、担当者よりご連絡いたしますのでお待ち下さい。


ご記入内容

_returnMessageTopEnd;


$returnMessageBottom = <<<_returnMessageBottomEnd



会社名
ishida@arrival-quality.com
_returnMessageBottomEnd;






$returnTo = '';
$message = '';
foreach ($_POST as $key => $value) {
	if($key == 'token'){
		continue;
	}
	if($key == 'メールアドレス'){
		$returnTo = $value;
	}
	
	$message .= $key . ":\n";
	$message .= mySafeString($value);
	$message .= "\n\n";
}


if($message != "" && $returnTo != ""){
	ini_set("mbstring.internal_encoding","UTF-8");
	mb_language("uni");

	$status = mb_send_mail($to, $subject, $messageTop.$message, $header);

	$returnHeader = 'From: '.$masterMail."\r\n";
	$returnMessage = $returnMessageTop."\n".$message."\n".$returnMessageBottom;
	$returnStatus = mb_send_mail($returnTo, $returnSubject, $returnMessage, $returnHeader);

	header('Location: '.($_SERVER['HTTPS'] ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/thanks.html');
	exit();
}
else
{
	echo "<!-- -->";
}

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