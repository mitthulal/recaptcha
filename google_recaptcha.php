<?php
require('phpmailer/class.phpmailer.php');
require("phpmailer/class.smtp.php");

session_start();
ini_set('display_errors', 1); 
error_reporting(E_ALL);
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
//echo "<pre>";print_r($_POST);die;
if (!empty($_POST))
{
	$form_name = $_POST['name'];
	$form_phone = $_POST['mobNo'];
	$form_email = $_POST['email'];
    $form_message = $_POST['message'];
    
    
    $secretkey="6Ld4w7UUAAAAAHbow0kjVHmpTAPZff_5nSaRDOSp";
     $responce_key=$_POST['g-recaptcha-response'];
     $user_IP=$_SERVER['REMOTE_ADDR'];
     $url="https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$responce_key&remoteip=$user_IP";
     $response = file_get_contents($url);
     $response = json_decode($response);
     
	$success = true;
	

	
	if($response->success)
	{
		sendMail($form_name, $form_phone, $form_email, $form_message);
	}else{
	   echo'invalid Captcha Please Try Again';
	}
}
function sendMail($form_name, $form_phone, $form_email, $form_message)
{
	
	
	$message='Dear ADMIN,<br /><br />You Have Received Enquiry Request From travelindiaplanet Website<br />From .:'.$form_name.'<br />
	Details Of Online Enquiry Of Visitor Are Below:
	<table width="500px" height="200px" style="border:solid 1px #069" align="justify" cellspacing="0">
	<tr bgcolor="#c01c3a" style="color:#fff;font-weight:bold" align="center"><td colspan="3">ENQUIRY DETAILS</td></tr>
	<tr>
	<td align="justify">Name</td>
	<td align="justify"> :</td>
	<td align="justify"> '.$form_name.'</td>
	</tr>
	<tr>
	<td align="justify">Phone</td>
	<td align="justify"> :</td>
	<td align="justify"> '.$form_phone.'</td>
	</tr>

    <tr>
	<td align="justify">Email</td>
	<td align="justify"> :</td>
	<td align="justify"> '.$form_email.'</td>
	</tr>
	
	 <tr>
	<td align="justify">Message</td>
	<td align="justify"> :</td>
	<td align="justify"> '.$form_message.'</td>
	</tr>
	
	</table>';
	
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = TRUE;
	$mail->SMTPSecure = "tls";
	$mail->Port     = 587;  
	$mail->Username = "noreply@travelindiaplanet.com";
	$mail->Password = "@(Bt!]A1tvR1";
	$mail->Host     = "mail.travelindiaplanet.com";
	$mail->Mailer   = "smtp";
	$mail->SetFrom("noreply@travelindiaplanet.com");
	$mail->AddAddress("info@travelindiaplanet.com");	
	$mail->Subject = "Enquiry from website";
	$mail->WordWrap   = 80;
	$mail->Body = $message;



	$mail->IsHTML(true);
	if(!$mail->Send()) {
		echo "<p class='error'>Problem in Sending Mail.</p>";
	} else {

		?>
		<script>window.location="http://travelindiaplanet.com/thankyou.php"</script>
	<?php
	}

}
?>
<html>
<body>
 </body>
 </html>       		

 
 <!-- form -- ?>
 
 	<form method="POST" action="sendMail_contact.php">
					<div class="form-group">
					  <input type="text" class="form-control" id="name" name="name" placeholder="*Your Name" >
					</div>
					<div class="form-group">
					  <input type="text" class="form-control" id="mobNo" name="mobNo" placeholder="*Contact Number" >
					</div>
					<div class="form-group">
					  <input type="text" class="form-control" id="email" name="email" placeholder="*Email" >
					</div>
					<div class="form-group">
					  <textarea class="form-control" type="textarea" id="message" name="message" placeholder="*Message" maxlength="50" rows="3"></textarea>
					</div>
				<div class="col-md-3">
												<div class="box ">
													<div class="g-recaptcha" data-callback="imNotARobot" data-sitekey="6Ld4w7UUAAAAAKkL52tUsmE27_nVAYPjLTsD2cmb"></div>
												</div>
											</div>
					<button type="submit" id="submit"  class="btn btn-block text-uppercase btn-book submit-now">SUBMIT</button>
				</form>
				
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>