<?php 
$errors = '';
$myemail = 'imssarl@gmail.com';//<-----Put To email address here.
if(empty($_POST['email']))
{
    $errors .= "\n Error: all fields are required";
}

$email_address = $_POST['email']; 


if (!eregi(
"^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", 
$email_address))
{
    $errors .= "\n Error: Invalid email address";
}

if( empty($errors))

{
	$to = $myemail; 
	$Cc = $Ccemail;
	$email_subject = "Someone has request for a Newsletter";
	$email_body = " You have received new request for Newsletter through spiralps.com website.".
	"\n Here are the details of Sender:\n Email: $email_address"; 
	
	// Put From email address here.
	$headers .= 'From: mail@spiralps.com' . "\r\n";
	//Put CC email address here.
	$headers .= 'Cc: ethiccash@gmail.com' . "\r\n";
	
	
	mail($to,$email_subject,$email_body,$headers);
	//redirect to the 'thank you' page
	header('Location: ../thank-you.html');
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Spiralps</title>
</head>

<body>
<!-- This page is displayed only if there is some error -->
<?php
echo nl2br($errors);
?>


</body>
</html>