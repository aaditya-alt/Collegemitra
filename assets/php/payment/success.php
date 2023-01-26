<?php

require_once '../header.php';
require_once '../session.php';
require '../mail/phpmailer/PHPMailerAutoload.php';
$email = $cemail;
$mail = new PHPMailer;

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
    $mail->Subject = 'Welcome Message';
    $mail->Body = '<h3> Welcome to Collegemitra</h3>';

    $mail->send();
    echo $cuser->showMessage('success', 'We have sent you the reset link in your e-mail ID, please check your email!');
}
catch(Exception $e){
    echo $cuser->showMessage('danger', 'Something went wrong, Please try again later!');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>
<body>

<p>Checking Payment.....</p>
<p id="payment1"></p>
<p id="payment2"></p>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

<script>
$(document).ready(function(){
  
  checkPayment();
  function checkPayment(){
    $.ajax({
        url: 'payment.php',
        method: 'post',
        data: { action: 'payment_status' },
        success: function(response){
            console.log(response);
            $("#payment1").html(response);
            data = JSON.parse(response);
            console.log(data);
            $("#payment2").html(data);
            let counselling = data.productinfo;
            if(data.status === "success"){
                $.ajax({
                    url: '../process.php',
                    method: 'post',
                    data: {counselling: counselling, action: 'counselling_submit'},
                    success: function(response){
                        console.log(response);
                        window.location = "../../../home.php";
                    }
                });
            }
        }
    });
}

});


</script>
    
</body>
</html>

