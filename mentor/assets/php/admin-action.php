<?php
session_start();
require_once 'admin-db.php';

$admin_name = $_SESSION['username'];


$admin = new Admin();
$data = $admin->currentUser($admin_name);
$counselling = $data['counselling'];
$cid = $data['id'];



// Handle admin login ajax request
if(isset($_POST['action'])&&$_POST['action']=='adminLogin'){
    $username = $admin->test_input($_POST['username']);
    $password = $admin->test_input($_POST['password']);

    $hpassword = sha1($password);

    $LoggedInAdmin = $admin->admin_login($username, $hpassword);
    
    if($LoggedInAdmin != null){
        echo 'admin_login';
        $_SESSION['username'] = $username;
    }
    else{
        echo $admin->showMessage('danger','Username or Password is Incorrect!');

    }
}

//handle fetch all users ajax request

//Mentor 1 student details


if(isset($_POST['action'])&&$_POST['action']=='fetchAllUsers'){
    $output = '';
    $data = $admin->fetchAllUsers($counselling);
    $path = '../assets/php/';
    if($data){
        $output .= '<table class="table tablle-striped table-bordered text-center">
                    <thead>
                    <tr>
                       <th>#</th>
                       <th>Image</th>
                       <th>Name</th>
                       <th>E-Mail</th>
                       <th>Rank</th>
                       <th>Phone</th>
                       <th>Category</th>
                       <th>State</th>
                       <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>';
                    foreach($data as $row){
                        if($row['photo'] != ''){
                            $uphoto = $path.$row['photo'];
                        }
                        else{
                            $uphoto = 'assets/php/photo/dummy-image.jpeg';
                        }
                        $output .= '<tr>
                        <td>'.$row['id'].'</td>
                        <td><img src="'.$uphoto.'" class="rounded-circle" width="40px"</td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['rank'].'</td>
                        <td>'.$row['phone'].'</td>
                        <td>'.$row['category'].'</td>
                        <td>'.$row['state'].'</td>
                        <td>
                           <a href="#" id=" '.$row['id'].' " title="View Details" class="text-primary userDetailsIcon" data-toggle="modal" data-target="#showUserDetailsModal"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;

                           <a href="#" id=" '.$row['id'].' " title="Delete User" class="text-danger userDetailsIcon"><i class="fas fa-trash-alt"></i></a>&nbsp;&nbsp;
                        </td>
                        </tr>';
                    }

                    $output .= '</tbody>
                    </table>';

                    echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:(No any user registered yet!)</h3>';
    }
}

//Handle displayusers in details ajax 

if(isset($_POST['details_id'])){
    $id = $_POST['details_id'];

    $data = $admin->fetchUserDetailsByID($id, $counselling);

    echo json_encode($data);
}

//Handle add update ajax request

if(isset($_FILES['updatePDF'])){
    
    $title = $admin->test_input($_POST['title']);
    $update = $admin->test_input(($_POST['update']));

    $folder = 'uploads/';

    $newPDF = $folder.$_FILES['updatePDF']['name'];
    move_uploaded_file($_FILES['updatePDF']['tmp_name'], $newPDF);

    $admin->add_new_update($cid,$counselling, $title, $update, $newPDF);
    
}

//handle ajax request for display all updates
if(isset($_POST['action'])&&$_POST['action']=='display_updates'){
    $output = '';

    $updates = $admin->get_updates($cid);
    $pdfpath = 'assets/php/';
    if($updates){
        $output .= '<table class="table table-striped table-sm text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Update</th>
                <th>PDF</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($updates as $row){
            if($row['pdf']=='uploads/'){
                $updf = 'assets/php/photo/dummy-image.jpg';
            }
            else {
                $updf = $pdfpath.$row['pdf'];
            }

            $output .= '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['title'].'</td>
            <td>'.substr($row['update'],0, 75).'...</td>
            <td><embed src="'.$updf.'" width="70%" height="100px"></embed></td>
            <td>
                <a href="#" id="'.$row['id'].'" title="View Details" class="text-success infoBtn"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;

                <a href="#" id="'.$row['id'].'" title="Edit Updates" class="text-primary editBtn"><i class="fas fa-edit fa-lg" data-toggle="modal" data-target="#editUpdateModal"></i></a>&nbsp;

                <a href="#" id="'.$row['id'].'" title="Delete Updates" class="text-danger deleteBtn"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;
            </td>
        </tr>';
        }
        $output .='</tbody></table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( You Have Not Written any Updates Yet!</h3>';
    }
}

 //Handle ajax request of edit update
 if(isset($_POST['edit_id'])){
    $id = $_POST['edit_id'];

    $row = $admin->edit_update($id);
    echo json_encode($row);
 }

 //handle edit update ajax request
 if(isset($_FILES['editPDF'])){
    
    $id = $admin->test_input($_POST['id']);
    $title = $admin->test_input($_POST['title']);
    $update = $admin->test_input(($_POST['editUpdate']));

    $folder = 'uploads/';

    $newPDF = $folder.$_FILES['editPDF']['name'];
    move_uploaded_file($_FILES['editPDF']['tmp_name'], $newPDF);

    $admin->update($id,$title,$update,$newPDF);

 }

 //handle delete update ajax request
 if(isset($_POST['del_id'])){
    $id = $_POST['del_id'];

    $admin->delete_update($id);
 }

 //handle ajax request for display update in detail

 if(isset($_POST['info_id'])){
    $id = $_POST['info_id'];

    $row = $admin->edit_update($id);

    echo json_encode($row);

 }

 //Handle ajax request for adding user 
 if(isset($_POST['action'])&&$_POST['action']=='addUser'){

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $rank = $_POST['rank'];

    $admin->add_user($name, $counselling, $phone, $rank);
 }


 //Handle ajax request for show calls data 

 if(isset($_POST['action'])&&$_POST['action']=='display_calls'){
    $output = '';
    $data = $admin->display_calls($counselling);
    if($data){
        $output .= '<table class="table table-striped table-sm text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>JEE Rank</th>
                <th>Category</th>
                <th>Phone</th>
                <th>Requested At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';
        foreach($data as $row){
            $date = date('d M Y  g:i A', strtotime($row['request_at']));
            $output .= '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['rank'].'</td>
            <td>'.$row['category'].'</td>
            <td>'.$row['phone'].'</td>
            <td>'.$date.'</td>
            <td>
                <a href="#" id="'.$row['id'].'" title="Call Done" class="text-danger callDoneBtn"><i class="fas fa-check-circle"></i></a>&nbsp;
            </td>
        </tr>';
        }
        
        $output .='</tbody></table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( You Have No Call Requests Yet!</h3>';
    }
}

//Handle ajax request for deleting call data
if(isset($_POST['del_id'])){
    $id = $_POST['del_id'];
    $data = $admin->display_calls($counselling);
    foreach ($data as $row){
        $uid = $row['uid'];
    }

    $admin->call_done($id);
    $admin->call_notification($uid, 'Your Mentor Has Called You!');
 }

//Handle fetch all feedback of users ajax request
if(isset($_POST['action'])&&$_POST['action']=='fetchAllFeedback'){
    $output = '';

    $feedback = $admin->fetchFeedback($counselling);
    $pdfpath = 'assets/php/';
    if($feedback){
        $output .= '<table class="table table-striped table-sm text-center">
        <thead>
            <tr>
                <th>FID</th>
                <th>UID</th>
                <th>User Name</th>
                <th>User E-Mail</th>
                <th>Subject</th>
                <th>Feedback</th>
                <th>Sent On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($feedback as $row){

            $output .= '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['uid'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['subject'].'</td>
            <td>'.$row['feedback'].'</td>
            <td>'.$row['created_at'].'...</td>
            <td>
                <a href="#" fid="'.$row['id'].'" id="'.$row['uid'].'" title="Reply" class="text-primary replyFeedbackIcon" data-toggle="modal" data-target="#showReplyModal"><i class="fas fa-reply fa-lg"></i></a>&nbsp;
            </td>
        </tr>';
        }
        $output .='</tbody></table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( No any Feedback Written Yet!</h3>';
    }
}

//Handle reply feedback to user ajax request
if(isset($_POST['message'])){
    $uid = $_POST['uid'];
    $message = $admin->test_input($_POST['message']);
    $fid = $_POST['fid'];

    $admin->replyFeedback($uid, $message);
    $admin->feedbackReplied($fid);
}
 
//fetch notification ajax request
if(isset($_POST['action'])&& $_POST['action']=='fetchNotification'){
    $notification = $admin->fetchNotification($counselling);
    $output = '';
    if($notification){
        foreach($notification as $row){
            $output .= '<div class="alert alert-dark" role="alert">
            <button class="close" id="'.$row['id'].'" type="button" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="alert-heading">New Notification</h4>
            <p class="mb-0 lead">'.$row['message'].' by '.$row['name'].'</p>
            <hr class="my-2">
            <p class="mb-0 float-left"><b>User E-Mail :</b>'.$row['email'].' </p>
            <p class="mb-0 float-right">'.$admin->timeInAgo($row['created_at']).'</p>
            <div class="clearfix"></div>
          </div>';
        }
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary mt-5">No any new notification</h3>';
    }
}

//Handle remove notification
if(isset($_POST['notification_id'])){
    $id = $_POST['notification_id'];
    $admin->removeNotification($id);
}

//Handle export all users in excel
if(isset($_GET['export'])&&$_GET['export']=='excel'){

    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename =users.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $data = $admin->exportAllUsers($counselling);
    echo '<table border="1" align-center>';

    echo '<tr>
             <th>#</th>
             <th>Name</th>
             <th>E-Mail</th>
             <th>Phone</th>
             <th>Gender</th>
             <th>State</th>
             <th>Category</th>
             <th>Joined On</th>
        </tr>';
        foreach($data as $row){
            echo '<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['gender'].'</td>
                    <td>'.$row['state'].'</td>
                    <td>'.$row['category'].'</td>
                    <td>'.$row['created_at'].'</td>
                </tr>';
        }
      echo  '</table>';
}


//Handle fetch all choice filling request of users ajax request
if(isset($_POST['action'])&&$_POST['action']=='fetchAllChoiceFilling'){
    $output = '';

    $choice_filling = $admin->fetchAllChoiceFilling($counselling);
    $pdfpath = 'assets/php/';
    if($choice_filling){
        $output .= '<table class="table table-striped table-sm text-center">
        <thead>
            <tr>
                <th>CID</th>
                <th>UID</th>
                <th>User Name</th>
                <th>Category</th>
                <th>JEE Rank</th>
                <th>Gender</th>
                <th>Sent On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($choice_filling as $row){
            $date = date('d M Y  g:i A', strtotime($row['created_at']));

            $output .= '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['uid'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['category'].'</td>
            <td>'.$row['rank'].'</td>
            <td>'.$row['gender'].'</td>
            <td>'.$date.'...</td>
            <td>
                <a href="#" fid="'.$row['id'].'" id="'.$row['uid'].'" title="Reply" class="text-primary sendChoiceFilling" data-toggle="modal" data-target="#sendChoiceFillingModal"><i class="fas fa-reply fa-lg"></i></a>&nbsp;
            </td>
        </tr>';
        }
        $output .='</tbody></table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( No any Choice Filling Request!</h3>';
    }
}

if(isset($_FILES['pdf'])){

    $message = $admin->test_input($_POST['note']);
    $uid = $_POST['uid'];
    $cid = $_POST['cid'];
    print_r($_POST);

    $folder = 'uploads/choice_filling/';

    $newPDF = $folder.$_FILES['pdf']['name'];
    move_uploaded_file($_FILES['pdf']['tmp_name'], $newPDF);

    $time = date("Y-m-d H:i:s");


    

    $admin->sendChoiceFilling($uid, $cid, $message, $newPDF, $time);
    $admin->call_notification($uid, 'You Have Got Your Choice Filling!');
    
    
}




?>