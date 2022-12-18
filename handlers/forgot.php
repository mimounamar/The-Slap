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
	include 'db.php';
    $sql = "SELECT * FROM users WHERE mail='".$_POST["mail"]."'";
    $result = mysqli_query($conn, $sql);
	if (isset($_POST["mail"]) && mysqli_num_rows($result)!=0) 
	{
		$_POST['mail'] = mysqli_real_escape_string($conn, $_POST['mail']);
		$data = mysqli_fetch_row($result);
		$generated_id = generateRandomString();
        $sql = "INSERT INTO `credentials_forgot`(`id`, `mail`, `date`) VALUES ('".$generated_id."','".$_POST['mail']."','".date("Y-m-d")."')";
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
		    $mail->Subject = "Oubli d'identifiants sur The Slap";
		    $mail->Body    = '
		    <h2>Vous avez demandé à réinitialiser vos identifiants sur The Slap</h2>
		    <p>Bonjour '.$data[2].',</p>
		    <p>Modifiez votre mot de passe en cliquant sur le lien suivant :</p>
		    <p>https://pleaseslap.me/login/?task=edit_password&id='.$generated_id.'
		    <p>Ce lien est valable pendant 24 heures uniquement.</p>
		    <strong>À bientôt sur The Slap !</strong>
		    ';

		    $mail->send();
		    header("Location: /login/?message=sent");
	}
?>