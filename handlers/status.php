<?php
session_start();
$lifetime = 365*24*3600;
setcookie(session_name(),session_id(),time()+$lifetime);
function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
if (isset($_POST) && isset($_SESSION)) 
{
        if ($_FILES['publish_attachement']['size'] <= 15000000 && $_FILES['publish_attachement']['size']!=0)
        {
            	$new_name = generateRandomString()."_".basename($_FILES['publish_attachement']['name']);
                move_uploaded_file($_FILES['publish_attachement']['tmp_name'], '../user_assets/attachements/' .$new_name);
                $attachement = $new_name;
        }
        else
        {
                $attachement = "";
        }
	include 'db.php';
        $sql = "SELECT * FROM `sessions` WHERE `id`='".$_SESSION["id"]."'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_row($result);
        $_POST['publish_query'] = mysqli_real_escape_string($conn, $_POST['publish_query']);
        $sql = "INSERT INTO `statuses`(`user`, `content`, `mood_text`, `mood_icon`, `date`, `attachement_type`, `attachement`) VALUES ('".$data[1]."','".$_POST['publish_query']."','".$_POST['mood_query']."','".$_POST["mood_selector"]."','".date("Y-m-d")."','".$_POST["type_attachement"]."','".$attachement."')";
        $result = mysqli_query($conn, $sql);
        //header("Location: /timeline");
        echo "Done";
}


?>