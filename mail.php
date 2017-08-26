<?php

	if(!is_dir('email_log'))
	{
		mkdir('email_log', 0777);
	}

$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$emailErr = "Invalid email format. Your message has not been sent.<br />";
	echo "<p>";echo "$emailErr";echo "</p>";
	echo ("\n<script type='text/javascript'> ");
	echo ("\nsetTimeout(function(){history.back();}, 5000);");
	echo ("\n</script>");
	echo ("\n<p>You are being redirected back...</p>");
	echo ("\n</body>");
	die();
}
else
{
	// this part of code sets maximum limit of email messages per day
	// it prevents robots and evil-minded people from abusing this script

	$max=20; // maximum emails per day

	$date=date('dmy');
	$file = fopen("email_log/$date.txt", "a"); // it will create file if does not exist
	fclose($file);
	$file = fopen("email_log/$date.txt", "r");
	$counter=fread($file,10000);
	// echo $counter;
	fclose($file);

	$file = fopen("email_log/$date.txt", "w");
	$addone = $counter + 1;
	fwrite($file,$addone);
	fclose($file);

		if ($addone > $max)
		{
			echo ("Unknown error. Contact with page administrator for more details.");
			echo ("\n</body>");
			die();
		}

	$name = $_POST['name'];
	$message = $_POST['message'];
	$wrap = wordwrap($message, 60, "\n", false);
	$formcontent="Od: \n$name, $email \n\nWiadomosc: \n$wrap";
	$recipient = "darbyconstructionltd@gmail.com";
	$subject = "Wiadomosc z darbyconstruction.co.uk";
	$mailheader = "From: $email \r\n";
	mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
	echo "Thank you for your message!";

	// Save IP number of email sender and log email to file in case of sending errors
	function getUserIP()
	{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
	}

	$sender_ip = getUserIP(); // get sender's IP
	$send_date = date ("d/m/Y G:i:s");
	$emails_dir = "emails";

	if(!is_dir($emails_dir))
	{
		mkdir($emails_dir, 0777);
	}

	$send_date_file = date('Gi-d-m-Y');
	$file = fopen("$emails_dir/$send_date_file.txt", "w");
	$break = ' ---- ';
	fwrite($file,"$sender_ip".$break."$send_date".$break."$formcontent");
	fclose($file);
	// end log sender ip
}

?>
