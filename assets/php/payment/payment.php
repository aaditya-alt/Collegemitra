<?php


namespace APITestCode;
require_once '../session.php';
require_once('PayU.php');
$cuser = new PayU();
$cuser->env_prod = 0;
$cuser->key = 'gMBh5o';
$cuser->salt = 'dBUXALRJ0BEhgQM1xIYEwcqVzgrwBbnv';
<?php if($premium == 'Not Subscribed!'):
$transaction = $cid.$fname.$cid;
?>
<?php else: 
$transaction = $cid.$cid.$fname;
?>
<?php endif; ?>


if(isset($_POST['action']) && $_POST['action'] == 'counselling_submit1'){
  $counselling =$_POST['counselling'];

$param['txnid'] = $transaction;
$param['firstname'] = $fname;
$param['lastname'] = 'Test';
$param['amount'] = 200;
$param['email'] = $cemail;
$param['productinfo'] = $counselling;
$param['phone'] = $cphone;
$param['address1'] = 'address1';
$param['city'] = 'delhi';
$param['state'] = 'Delhi';
$param['country'] = 'India';
$param['zipcode'] = 'zipcode';
//$param['api_version'] = '1';
$param['udf1'] = 'test';

$ini = $cuser->initGateway();
$ini = $cuser->showPaymentForm($param);
print_r($ini);





  
}
if(isset($_POST['action'])&& $_POST['action'] == 'payment_status'){

$param['txnid'] = $transaction;
$param['firstname'] = $fname;
$param['lastname'] = 'Test';
$param['amount'] = 200;
$param['email'] = $cemail;
$param['productinfo'] = $counselling;
$param['phone'] = $cphone;
$param['address1'] = 'address1';
$param['city'] = 'delhi';
$param['state'] = 'Delhi';
$param['country'] = 'India';
$param['zipcode'] = 'zipcode';
//$param['api_version'] = '1';
$param['udf1'] = 'test';

$ini = $cuser->verifyPayment($param);
echo json_encode($ini);

}




?>
