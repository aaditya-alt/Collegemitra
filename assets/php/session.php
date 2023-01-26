<?php

  session_start();
  require_once 'auth.php';
  $cuser = new Auth();

  if(!isset($_SESSION['user'])){
    $user=$_SESSION['user'];
    header('location:index.php');
    die;
    
  }

  $cemail = $_SESSION['user'];

  $data = $cuser->currentUser($cemail);

  $cid = $data['id'];
  $cname = $data['name'];
  $cpass = $data['password'];
  $cphone = $data['phone'];
  $cgender = $data['gender'];
  $cjee_rank = $data['jee_rank'];
  $cphoto = $data['photo'];
  $created = $data['created_at'];
  $cservice = $data['service'];
  $cmentor_name = $data['mentor_name'];
  $cmentor_phone = $data['mentor_phone'];
  $premium = $data['premium'];
  if($premium==0){
    $premium='Not Subscribed!';
  }
  else{
    $premium='Subscribed!';
  }

  $reg_on = date('d M Y',strtotime($created));
  $verified = $data['verified'];

  if($verified==0){
    $verified='Not Verified!';
  }
  else{
    $verified='Verified!';
  }
  $counselling = $data['counselling'];
  $category = $data['category'];
  $cstate =$data['state'];


  $fname = strtok($cname, " ");


?>