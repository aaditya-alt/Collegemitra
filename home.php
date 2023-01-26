<?php
    require_once './assets/php/header.php';

?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 mt-3">
          <div class="card border-primary">

            <!--Show Choice Filling Modal-->
            <div class="modal fade" id="showChoiceFillingModal">
      <div class="modal-dialog modal-dialog-centered mw-199 w-50">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="getName"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card-deck">
                    <div class="card border-primary">
                        <div class="card-body">
                            <p id="getSent"></p>
                            <p id="getCounselling"></p>
                            <p id="getCreated"></p>
                            <p id="getMessage"></p>
                            <p id="getRank"></p>
                            </div>
                    </div>
                    <div class="card align-self-center" id="getPdf"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
               <div class="card-header lead text-center bg-primary text-white">Hi <?= $fname; ?>!&nbsp;Welcome to CollegeMitra</div>
               <div class="card-body">
               
               <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Your Service Info : </b><?= $cservice; ?> <?php if($premium=='Not Subscribed!') echo 'None'; ?></p>


               <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Your Mentor Info : </b><?= $cmentor_name; echo '-' ?>&nbsp; <?= $cmentor_phone; ?><?php if($premium=='Not Subscribed!') echo 'None'; ?></p>

               <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Premium Plan : </b><b style="color:red;"> <?= $premium; ?></b></p>
               <?php if($premium=='Subscribed!'):?>
               <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Request Choice Filling : </b><button class="btn btn-danger" id="choice-filling-link" >Request Now</button> <button class="btn btn-success" id="getChoiceFilling" data-toggle="modal" data-target="#showChoiceFillingModal">Get Choice Filling</button> <button id="hide-btn" class="btn btn-secondary" style="display: none;">Hide</button></p>
               <div class="wrapper" id="choice-filling-box" style="display: none;">
               <form action="#" method="post" class="px-3" id="choice-filling-form">
               <input type="text" id="name" name="name" class="form-control rounded-2" placeholder="Full Name" required />
               
               <input type="text" id="rank" name="rank" class="form-control rounded-2" placeholder="JEE Mains Rank" required />

                        <select name="gender" id="gender" class="form-control">
                          <option value=""disabled<?php if($cgender==null){echo 'selected';}?>>Select</option>
                          <option value="Male" <?php if($cgender== 'Male'){
                            echo 'selected';
                          } ?>>Male</option>
                          <option value="Female" <?php if($cgender== 'Female'){
                            echo 'selected';
                          } ?>>Female</option>
                        </select>

                        <select name="counselling" id="counselling"class="form-control">
                          <option value=""disabled>Counselling</option>
                          <option value="HSTES">HSTES</option>
                          <option value="UPTU">UPTU</option>
                          <option value="REAP">REAP</option>
                          <option value="MP-DTE">MP DTE</option>
                          <option value="JOSAA">JOSAA</option>
                          <option value="CSAB">CSAB</option>
                        </select>

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

                    <input type="submit" id="choice-filling-btn" value="Submit" class="btn btn-primary btn-lg btn-block myBtn"/>

               </form>


               </div>
               <?php else: ?>
                <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Request Choice Filling : </b><button class="btn btn-primary">Not Applicable</button></p>
                <?php endif; ?>
               <?php if($premium=='Subscribed!'):?>
              <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Request a Call : </b><button class="btn btn-info" id="calling-link">Request Now</button></p>
              <?php else: ?>
                <p class="card-text p-2 m-2 rounded" style="border:1px solid #0275d8;"><b>Request a Call : </b><button class="btn btn-primary" >Not Applicable</button></p>
                <?php endif; ?>

              <?php if($premium=='Subscribed!'):?>
              <ul class="card-text p-2 m-2 rounded" style="border: 1px solid #0275d8;" ><b>Some Rules Before You Just Go Ahead : </b></ul>
              <li class="card-text p-2 m-2 rounded" style="border: 1px solid #0275d8;"><?=$fname; ?>!&nbsp;Please Update Your Profile to Avail benifits of Premium</li>
              <li class="card-text p-2 m-2 rounded" style="border: 1px solid #0275d8;">You can Contact Your Mentor Anytime or Just You Can Requet Him a Call</li>
              <li class="card-text p-2 m-2 rounded" style="border: 1px solid #0275d8;">After Requesting a Choice filling You Must Contact Your mentor for any kind of suggestions</li>
              <li class="card-text p-2 m-2 rounded" style="border: 1px solid #0275d8;">You Can Send him a Message Using In Built Messaging Feature</li>

              <?php else: ?>
            <h1 class="text-center text-secondary mt-5">Purchase Our <b style="color: red;">Premium Plan</b> First to Explore More!</h1>
            <button class="btn btn-success btn-block btn-lg"><a style="color: inherit;" href="services.php">Purchase Now</a></button>
            <?php endif; ?>
              
          
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script type="text/javascript" src="./assets/js/script.js"></script>
  <script>
    $("#choice-filling-link").click(function(){
     $("#choice-filling-box").show();
     $("#hide-btn").show();
    });

    $("#hide-btn").click(function(){
        $("#choice-filling-box").hide();
        $("#hide-btn").hide();
    });

    

    // choice filling ajax request
    $("#choice-filling-form").submit(function(e){
      e.preventDefault();
      $("#choice-filling-btn").val('Please Wait...');

      $.ajax({
        url: 'assets/php/process.php',
        method: 'post',
        data: $("#choice-filling-form").serialize()+'&action=submit',
        success: function(response){
          $("#choice-filling-form")[0].reset();
                    $("#choice-filling-btn").val('Submit');
                     Swal.fire({
                        title: 'Choice Filling Request Successfully sent to the Mentor!',
                        type: 'success'
                     });
        }
      });
    });
    

  //calling form ajax request
    $("#calling-link").click(function(e){
      e.preventDefault();
      $("#calling-link").val('Please Wait...');

      $.ajax({
        url: 'assets/php/process.php',
        method: 'post',
        data: '&action=request_call',
        success: function(response){
                    $("#calling-btn").val('Submit');
                     Swal.fire({
                        title: 'Calling Request Successfully sent to the Mentor!',
                        type: 'success'
                     });

        }
      });
    });
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

    //Get choice filling ajax request
    $("#getChoiceFilling").click(function(e){

      e.preventDefault();

      $.ajax({
        url: 'assets/php/process.php',
        method: 'post',
        data: {action : 'getChoiceFilling'},
        success: function(response){
                    data = JSON.parse(response);
                    console.log(data);
                    $("#getName").text(data.name+' '+ '(ID: '+data.id+')');
                    $("#getSent").text('Recieved On : '+data.sent_at);
                    $("#getRank").text('Rank : '+data.rank);
                    $("#getCounselling").text('Counselling : '+data.counselling);
                    $("#getMessage").text('Instruction : '+data.message);
                    $("#getCreated").text('Requested at : '+data.created_at);

                    if(data.pdf != ''){
                        $("#getPdf").html('<embed src="../user-system/mentor/assets/php/'+data.pdf+'"width="200" height="300">');
                    }
                    else{
                        $("#getPdf").html('<img src="../assets/php/photo/dummy-image.jpg'+data.pdf+'"class="img-thumbnail img-fluid align-self-center width="280px">');
                    }
                }
      });

    });
  </script>

  </body>
  </html>