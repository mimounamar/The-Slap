<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require '../vendor/autoload.php'; 

	$mail = new PHPMailer(true);

	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	if (isset($_POST["reg_submit_x"]) and isset($_POST["reg_submit_y"]) && preg_match('/^[a-zA-Z\s]*$/', $_POST['name'])==1){
		echo "string";
		include 'db.php';
        $sql = "SELECT * FROM users WHERE username='".$_POST["username"]."' OR mail='".$_POST["mail"]."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)==0)
        {
        	$hashed_password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        	$_POST['name'] = mysqli_real_escape_string($conn, $_POST['name']);
        	$_POST['username'] = mysqli_real_escape_string($conn, $_POST['username']);
        	$_POST['mail'] = mysqli_real_escape_string($conn, $_POST['mail']);
        	$_POST['birthday'] = mysqli_real_escape_string($conn, $_POST['birthday']);
        	$_POST['pronom'] = mysqli_real_escape_string($conn, $_POST['pronom']);
        	$sql = "INSERT INTO `users`(`name`, `username`, `password`, `mail`, `birthday`, `pronouns`) VALUES ('".$_POST["name"]."','".$_POST["username"]."','".$hashed_password."','".$_POST["mail"]."','".$_POST["birthday"]."','".$_POST["pronom"]."')";
        	$result = mysqli_query($conn, $sql);

        	$generated_id = generateRandomString();
        	$sql = "INSERT INTO `mail_verification`(`id`, `mail`, `date`) VALUES ('".$generated_id."','".$_POST['mail']."','".date("Y-m-d")."')";
        	$result = mysqli_query($conn, $sql);

        	$mail->isSMTP();
        	$mail->Host = 'smtp.sendgrid.net';  
        	$mail->SMTPAuth = true; 
        	$mail->Username = 'apikey';  
        	$mail->Password = '#APIKEY_NOTHING_TO_SEE';

        	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     
		    $mail->Port       = 465;                                    

		    $mail->setFrom('noreply@pleaseslap.me', 'noreply');
		    $mail->addAddress($_POST["mail"]);    

		    $mail->isHTML(true);                               
		    $mail->Subject = 'Confirmez votre adresse mail sur The Slap !';
		    $mail->Body    = '
		    <h2>Bienvenue sur The Slap !</h2>
		    <p>Validez votre adresse mail en cliquant sur le lien suivant :</p>
		    <p>https://pleaseslap.me/register/?message=verified&id='.$generated_id.'
		    <p>Ce lien est valable pendant 24 heures uniquement.</p>
		    <strong>À bientôt sur The Slap !</strong>
		    ';

		    $mail->send();
		    header("Location: /register/?message=verify");
		   }
		else{
			header("Location: /register");
		}        
	}
	else
	{
		header("Location: /register");
	}
?>