<?php
 session_start();
 
//Load Composer's autoloader
require './mail/phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;

 require_once 'auth.php';
 $user = new Auth();

 //Registration Handle Ajax 
 if(isset($_POST['action'])&& $_POST['action']=='register'){
    $name = $user->test_input($_POST['name']);
    $email = $user->test_input($_POST['email']);
    $pass = $user->test_input($_POST['password']);

    $hpass = password_hash($pass, PASSWORD_DEFAULT);

    if($user->user_exist($email)){
        echo $user->showMessage('warning', 'This E-Mail is already registered!');
    }
    else{
        if($user->register($name,$email,$hpass)){
            echo 'register';
            $_SESSION['user'] = $email;
        }
        else{
            echo $user->showMessage('warning', 'Something went wrong! try again later!');
        }
    }
 }


//Login Handle Ajax 

 if(isset($_POST['action'])&& $_POST['action'] == 'login'){
    $email =$user->test_input($_POST['email']);
    $pass =$user->test_input($_POST['password']);

    $loggedInUser = $user->login($email);

    if($loggedInUser != null){
        if(password_verify($pass, $loggedInUser['password'])){
            if(!empty($_POST['rem'])){
                setcookie("email",$email, time()+(30*24*60*60), '/');
                setcookie("password",$pass, time()+(30*24*60*60), '/');
            }
            else{
                setcookie("email","",1, '/');
                setcookie("password", "", 1, '/');
            }

            echo 'login';
            $_SESSION['user']=$email;
        }
        else{
            echo $user->showMessage('warning','Password is incorrect');
        }
    }
    else{
        echo $user->showMessage('warning', 'User is not registered');
    }
 }

 // Handle forgot password ajax request
 if(isset($_POST['action']) && $_POST['action']=='forgot'){
    
    $email=$user->test_input($_POST['email']);

    $user_found = $user->currentUser($email);

    if($user_found != null){
        $token = uniqid();
        $token = str_shuffle($token);

        $user->forgot_password($token, $email);

        try{

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = Database::USERNAME;
            $mail->Password = Database::PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom(Database::USERNAME, 'CollegeMitra');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = '<h3> Click the below link to reset your Password.<br><br> <a href="http://localhost/user-system/reset-pass.php?email='.$email.' &token= '.$token.' ">http://localhost/user-system/reset-pass.php?email='.$email.' &token= '.$token.'</a><br>Regards<br>CollegeMitra!</h3>';

            $mail->send();
            echo $user->showMessage('success', 'We have sent you the reset link in your e-mail ID, please check your email!');
        }
        catch(Exception $e){
            echo $user->showMessage('danger', 'Something went wrong, Please try again later!');
        }
        }
        else{
            echo $user->showMessage('info', 'This e-mail is not registered!');
    }
}
 


?>
