<?php
define('SECRET_KEY', '6LeWl4EfAAAAAG-W1gjT_j_xIGERangwgb24RHnz');

function getCaptcha($recretKey) {
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$recretKey}");
	$return = json_decode($response);
	return $return;
}




if($_POST){
	$return = getCaptcha($_POST['g-recaptcha-response']);

//	echo "<pre>";
//	print_r($return);
//	echo "</pre>";

	if($return->success == true && $return->score > 0.5){
		$c = true;

		$project_name = trim($_POST["project_name"]);
		$admin_email  = trim($_POST["admin_email"]);
		$form_subject = trim($_POST["form_subject"]);

		foreach ( $_POST as $key => $value ) {
			if ( $value != "" && $key != "project_name" && $key != "g-recaptcha-response" && $key != "admin_email" && $key != "form_subject" ) {
				$message .= "
			" . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
				<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
				<td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
				</tr>
			";
			}
		}

		$message = "<table style='width: 100%;'>$message</table>";

		function adopt($text) {
			return '=?UTF-8?B?'.base64_encode($text).'?=';
		}

		$headers = "MIME-Version: 1.0" . PHP_EOL .
			"Content-Type: text/html; charset=utf-8" . PHP_EOL .
			'From: '.adopt($project_name).' <'.$admin_email.'>' . PHP_EOL .
			'Reply-To: '.$admin_email.'' . PHP_EOL;

		$mail_result = mail($admin_email, adopt($form_subject), $message, $headers );
		if($mail_result){
			echo "success";
		}
	}
	else {
		echo "You are Robot!";
	}
}













