<?php

  require_once 'session.php';

  //profile update ajax request
    if(isset($_FILES['image'])){
        $jee_rank = $cuser->test_input($_POST['jee_rank']);
        $gender = $cuser->test_input($_POST['gender']);
        $phone = $cuser->test_input($_POST['phone']);
        $state = $cuser->test_input($_POST['state']);
        $category = $cuser->test_input($_POST['category']);

        $oldImage = $_POST['oldimage'];
        $folder = 'uploads/';

        if(isset($_FILES['image']['name'])&&($_FILES['image']['name'] != "")){
            $newImage = $folder.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $newImage);

            if($oldImage != null){
                unlink($oldImage);
            }
        }
        else{
            $newImage = $oldImage;
        }
        $cuser->update_profile($jee_rank, $phone, $gender, $newImage, $category, $state, $cid);
        $cuser->notification($cid, 'admin', 'Profile Updated', $counselling);

        // Return a success message
        echo json_encode(array('message' => 'The form was submitted successfully'));
    }

    //handle ajax request for change password
    if(isset($_POST['action'])&& $_POST['action'] == 'change_pass'){
        $currentPass = $_POST['curpass'];
        $newPass = $_POST['newpass'];
        $cnewPass = $_POST['cnewpass'];

        $hnewPass = password_hash($newPass, PASSWORD_DEFAULT);

        if($newPass != $cnewPass){
            echo $cuser->showMessage('danger', 'Password did not matched!');
        }
        else{
            if(password_verify($currentPass, $cpass)){
                $cuser->change_password($hnewPass, $cid);
                $cuser->notification($cid, 'admin', 'Password changed!', $counselling);
                echo $cuser->showMessage('success', 'Password Changed Successfully!');
            }
            else{
                echo $cuser->showMessage('danger', 'Current Password is Wrong!');
            }
        }
    }

    //Handle send feedback to mentor ajax request
    if(isset($_POST['action']) && $_POST['action']=='feedback'){
        $subject = $cuser->test_input($_POST['subject']);
        $feedback = $cuser->test_input($_POST['feedback']);

        $cuser->send_feedback($subject, $feedback, $cid, $counselling);
        $cuser->notification($cid, 'admin', 'Feedback Written', $counselling);
    }
 
    //handle ajax request for choice filling
    if(isset($_POST['action']) && $_POST['action']=='submit'){
        $name = $cuser->test_input($_POST['name']);
        $rank = $cuser->test_input($_POST['rank']);
        $counselling = $cuser->test_input($_POST['counselling']);
        $gender = $cuser->test_input($_POST['gender']);
        $category =$cuser->test_input($_POST['category']);

        $cuser->choice_filling($name,$rank,$gender,$counselling,$category,$cid);
        $cuser->notification($cid, 'admin', 'Choice Filling Request', $counselling);
    }

    //handle ajax request for calling
    if(isset($_POST['action'])&&$_POST['action']=='request_call'){
        

        $cuser->calling($cid, $cname, $cphone, $cjee_rank, $category, $cmentor_name, $counselling);
        $cuser->notification($cid, 'admin', 'Call Request', $counselling);
    }


    //handle ajax request for counselling field
if(isset($_POST['counselling'])){
    
    $counselling = $cuser->test_input($_POST['counselling']);
    print_r($counselling);

    
    if($counselling=='UPTU'){

         $cuser->counselling($counselling, $cid, $cname, $cjee_rank, $category, $cphone, $cemail, $cstate, $cphoto, $cgender, 'Aditya Singh | ...');
         $cuser->premium_users($counselling, 1, $cid,'You Have Purchased Counselling Service For UPTU', 'Aditya Singh', '999');
         $cuser->notification($cid, 'admin', 'New Premium Purchased', $counselling);
    }


else if($counselling=='HSTES'){
    
         $cuser->counselling($counselling, $cid, $cname, $cjee_rank, $category, $cphone, $cemail, $cstate, $cphoto, $cgender, 'Gautam kumar | ...');
         $cuser->premium_users($counselling, 1, $cid,'You Have Purchased Counselling Service For HSTES', 'Gautam Kumar', '999');
         $cuser->notification($cid, 'admin', 'New Premium Purchased', $counselling);
    }


else if($counselling=='REAP'){
    
        $cuser->counselling($counselling, $cid, $cname, $cjee_rank, $category, $cphone, $cemail, $cstate, $cphoto, $cgender, 'Aaditya Ranjan | ...');
        $cuser->premium_users($counselling, 1, $cid,'You Have Purchased Counselling Service For REAP', 'Aaditya Ranjan', '999');
        $cuser->notification($cid, 'admin', 'New Premium Purchased', $counselling);
   }


else if($counselling=='UGEAC'){

        $cuser->counselling($counselling, $cid, $cname, $cjee_rank, $category, $cphone, $cemail, $cstate, $cphoto, $cgender, 'Rajan Kushwaha | ...');
        $cuser->premium_users($counselling, 1, $cid,'You Have Purchased Counselling Service For UGEAC', 'Rajan Kushwaha', '999');
        $cuser->notification($cid, 'admin', 'New Premium Purchased', $counselling);
   }


else if($counselling=='JOSAA'){
    
        $cuser->counselling($counselling, $cid, $cname, $cjee_rank, $category, $cphone, $cemail, $cstate, $cphoto, $cgender, 'Adarsh Ranjan | ...');
        $cuser->premium_users($counselling, 1, $cid,'You Have Purchased Counselling Service For JOSAA', 'Adarsh Ranjan', '999');
        $cuser->notification($cid, 'admin', 'New Premium Purchased', $counselling);
   }

else{
    echo 'none';
}

}

//Handle ajax request for displaying all the updates
if(isset($_POST['action'])&& $_POST['action']=='fetchAllUpdates'){
    $output='';
    $data = $cuser->fetchAllUpdates();
    $path = '../../../user-system/mentor/assets/php/';
    if($data){
        $output .= '<table class="table tablle-striped table-bordered text-center">
                    <thead>
                    <tr>
                       <th>#</th>
                       <th>Title</th>
                       <th>Updates</th>
                       <th>PDF</th>
                       <th>Counselling</th>
                       <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>';
                    foreach($data as $row){
                        if($row['pdf']=='uploads/'){
                            $updf = 'mentor/assets/php/photo/dummy-image.jpeg';
                        }
                        else {
                            $updf = $path.$row['pdf'];
                        }
                        $output .= '<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['title'].'</td>
                        <td>'.substr($row['update'],0, 75).'</td>
                        <td><embed src="'.$updf.'" width="70%" height="100px"></embed></td>
                        <td>'.$row['counselling'].'</td>
                        <td>
                        <a href="#" id="'.$row['id'].'" title="View Details" class="text-success infoBtn"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;

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

//Fetch updates in detail ajax request
if(isset($_POST['info_id'])){
    $id = $_POST['info_id'];

    $row = $cuser->fetch_updates_detail($id);

    echo json_encode($row);

 }

//Handle fetch notification
if(isset($_POST['action'])&& $_POST['action']=='fetchNotification'){
    $notification = $cuser->fetchNotification($cid);
    $output = '';
    if($notification){
        foreach($notification as $row){
            $output .= '<div class="alert alert-danger" role="alert">
            <button class="close" id="'.$row['id'].'" type="button" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="alert-heading">New Notification</h4>
            <p class="mb-0 lead">'.$row['message'].'</p>
            <hr class="my-2">
            <p class="mb-0 float-left">Reply of Feedback from admin</p>
            <p class="mb-0 float-right">'.$cuser->timeInAgo($row['created_at']).'</p>
            <div class="clearfix"></div>
          </div>';
        }
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary mt-5">No any new notification</h3>';
    }
}

//Check notification
if(isset($_POST['action'])&& $_POST['action']== 'checkNotification'){
    if($cuser->fetchNotification($cid)){
        echo '<i class="fas fa-circle fa-sm text-danger"></i>';
    }
    else{
        echo '';
    }
}

//Remove notification
if(isset($_POST['notification_id'])){
    $id = $_POST['notification_id'];
    $cuser->removeNotification($id);
}

//Get Choice filling sent by admin
if(isset($_POST['action'])&& $_POST['action']== 'getChoiceFilling'){
    $id = $cid;

    $data = $cuser->get_choice_filling($id);

    echo json_encode($data);
}


?>