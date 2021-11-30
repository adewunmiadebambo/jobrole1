<?php
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

if(!$firstname || !$lastname || !$email || !$phone || !$message)
{
	$error = 'formerror';
	include('index.php');
	exit;
}

elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$error = 'emailerror';
	include('index.php');
	exit;
}



// MailChimp API credentials
$apiKey = 'b001c8e56c81ef77356bb17531b99869-us17'; 
$listID = '7cc82c6d10';
 
// MailChimp API URL
$memberID = md5(strtolower($email));
$dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
 
// member information
$json = json_encode([
'email_address' => $email,
'status'        => 'subscribed',
// 'merge_fields'  => [
//     'FNAME'     => $firstname,
//     'LNAME'     => $lastname
//     ]
]);
 
// send a HTTP POST request with curl
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
 
// store the status message based on response code



	$to = 'info@jobroleng.com';
	$subject = 'Career Support Services';
	$from = "From: noreply@jobroleng.com";
	
	$content = 'Below are the details of the client who sent you a message'."\n"
				.'Firstname: '.$firstname."\n"
				.'Lastname: '.$lastname."\n"
				.'Email: '.$email."\n"
				.'Phone: '.$phone."\n"
				.'Message: '.$message."\n";
	
	mail($to,$subject,$content,$from);


{
	include('thankyou.php');
}

?>