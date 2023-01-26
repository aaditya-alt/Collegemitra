<?php
    require_once './assets/php/header.php';

?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card rounded-0 mt-3 border-primary">
          <div class="card-header border-primary">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a href="#profile" class="nav-link active font-weight-bold" data-toggle="tab">Profile</a>
              </li>

              <li class="nav-item">
                <a href="#editProfile" class="nav-link font-weight-bold" data-toggle="tab">Edit Profile</a>
              </li>

              <li class="nav-item">
                <a href="#changePass" class="nav-link font-weight-bold" data-toggle="tab">Change Password</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">

            <!--Profile tab content start-->
              <div class="tab-pane container active" id="profile">
                <div class="card-deck">
                  <div class="card border-primary">
                    <div class="card-header bg-primary text-light text-center lead">
                      User ID : <?= $cid; ?>
                    </div>
                    <div class="card-body">
                      <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Name : </b><?= $cname; ?></p>

                      <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>E-mail : </b><?= $cemail; ?></p>

                      <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Gender : </b><?= $cgender; ?></p>

                      <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>JEE Mains Rank : </b><?= $cjee_rank; ?></p>

                      <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Phone : </b><?= $cphone; ?></p>

                      <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Registered On : </b><?= $reg_on; ?></p>

                      <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Premium Plan : </b><b style="color:red;"> <?= $premium; ?></b>
                    
                      <?php if($premium=='Not Subscribed!'):?>
                        <a style="font-size: 75%;" href="services.php" id="subscribe" class="float-right">Subscribe Now</a>
                        <?php endif; ?>
                    </p>
                    <div class="clearfix"></div>
                    </div>
                  </div>
                  <div class="card border-primary align-self-center">
                    <?php if(!$cphoto):?>
                      <img src="./assets/php/uploads/dummy-image.jpeg" alt="dummy_image" class="img-thumbnail img-fluid" width="408px">
                      <?php else: ?>
                        <img src="<?='./assets/php/'.$cphoto; ?>" class="img-thumbnail img-fluid" width="408px">
                      <?php endif; ?>
                  </div>
                </div>
              </div>
              <!--Profile tab content start-->
              <!--Edit Profile tab content start-->
              <div class="tab-pane container fade" id="editProfile">
                <div class="card-deck">
                  <div class="card border-danger align-self-center">
                  <?php if(!$cphoto):?>
                      <img src="./assets/php/uploads/dummy-image.jpeg" class="img-thumbnail img-fluid" width="408px">
                      <?php else: ?>
                        <img src="<?='./assets/php/'.$cphoto; ?>" class="img-thumbnail img-fluid" width="408px">
                      <?php endif; ?>
                  </div>
                  <div class="card border-danger">
                    <form action="" method="post" class="px-3 mt-2" enctype="multipart/form-data" id="profile-update-form">
                      <input type="hidden" name="oldimage" value="<?= $cphoto; ?>">
                      <div class="form-group m-0">
                        <label for="profilePhoto" class="m-1">Upload Profile image</label>
                        <input type="file" name="image" id="image">
                      </div>

                      <div class="form-group m-0">
                        <label for="jee" class="m-1">JEE Mains Rank</label>
                        <input type="text" name="jee_rank" id="jee_rank" class="form-control" value="<?=$cjee_rank;?>">

                      <div class="form-group m-0">
                        <label for="gender" class="m-1">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                          <option value=""disabled<?php if($cgender==null){echo 'selected';}?>>Select</option>
                          <option value="Male" <?php if($cgender== 'Male'){
                            echo 'selected';
                          } ?>>Male</option>
                          <option value="Female" <?php if($cgender== 'Female'){
                            echo 'selected';
                          } ?>>Female</option>
                        </select>
                      </div>

                      <div class="form-group m-0">
                        <label for="phone" class="m-1">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?=$cphone;?>">
                      </div>

                      <div class="form-group m-0">
                        <label for="category" class="m-1">Category</label>
                        <select name="category" id="category" class="form-control">
                          <option value=""disabled<?php if($category==null){echo 'selected';}?>>Select</option>
                          <option value="General" <?php if($category== 'General'){
                            echo 'selected';
                          } ?>>General</option>
                          <option value="Gen-EWS" <?php if($category== 'Gen-EWS'){
                            echo 'selected';
                          } ?>>Gen-EWS</option>
                          <option value="OBC_NCL" <?php if($category== 'OBC-NCL'){
                            echo 'selected';
                          } ?>>OBC-NCL</option>
                          <option value="SC" <?php if($category== 'SC'){
                            echo 'selected';
                          } ?>>SC</option>
                          <option value="ST" <?php if($category== 'ST'){
                            echo 'selected';
                          } ?>>ST</option>
                        </select>

                      <div class="form-group m-0">
                        <label for="state" class="m-1">Home State</label>
                        <input type="text" name="state" id="state" class="form-control" value="<?=$cstate;?>">
                      </div>
                    
                      <div class="form-group mt-2">
                        <input type="submit" name="profile_update" value="Update Profile" class="btn btn-danger btn-block" id="profileUpdateBtn">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
              <!-- Edit Profile tab content end -->

              <!-- Change password tab content start -->

            <div class="tab-pane container fade" id="changePass">
              <div id="changepassAlert"></div>
              <div class="card-deck">
                <div class="card border-success">
                  <div class="card-header bg-success text-white text-center lead">
                    Change Password
                  </div>
                  <form action="#" method="post" class="px-3 mt-2" id="change-pass-form">
                    <div class="form-group">
                      <label for="curpass">Enter Your Current Password</label>
                      <input type="password" name="curpass" placeholder="Current Password" class="form-control form-control-lg" id="curpass" required minlength="5">
                    </div>

                    <div class="form-group">
                      <label for="newpass">Enter New Password</label>
                      <input type="password" name="newpass" placeholder="New Password" class="form-control form-control-lg" id="newpass" required minlength="5">
                    </div>
          
                    <div class="form-group">
                      <label for="cnewpass">Confirm New Password</label>
                      <input type="password" name="cnewpass" placeholder="Confirm New Password" class="form-control form-control-lg" id="cnewpass" required minlength="5">
                    </div>
                    <div class="form-group">
                      <p id="changepassError" class="text-danger"></p>
                    </div>
                     <div class="form-group">
                      <input type="submit" name="changepass" value="Change Password" class="bt btn-success btn-block btn-lg" id="changePassBtn">
                     </div>
                    
                  </form>
                </div>
                <div class="card border-success align-self-center">
                  <img src="./assets/php/photo/change_pass.jpg" class="img-thumbnail img-fluid" width="408px">
                </div>
              </div>
            </div>
              <!-- Change password tab content end -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

    <script type="text/javascript" src="assets/js/script.js"></script>
    <script>
      $(document).ready(function(){
         //Check notification
         checkNotification();
        function checkNotification(){
          $.ajax({
            url: 'assets/php/process.php',
            method: 'post',
            data: {action: 'checkNotification'},
            success: function(response){
              $("#checkNotification").html(response);
            }
          });
        }
      });
    </script>

  </body>
  </html>