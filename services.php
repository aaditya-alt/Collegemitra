<?php

require_once './assets/php/header.php';
require_once 'assets/php/session.php';

?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

    <script type="text/javascript" src="./assets/js/script.js"></script>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <card class="card rounded-0 mt-3 border-primary">
            <div class="card-header border-success bg-success text-light text-center lead">
              Hi <?=$cname;?>! Welcome to CollegeMitra Premium Services
            </div>
            <div class="card-body">
                 <div class="tab-content">

                 <!--HSTES CONTENT START -->
                 <div class="tab-pane container active">
                  <div class="card-deck">
                    <div class="card border-info">
                      <div class="card-header bg-info text-light text-center lead">
                        <b>Premium Features</b>
                      </div>
                      <div class="card-body">
                        <p class="card-text p-2 m-2 rounded border-info" style="border: 1px solid #008000;">1. 100 Page EBOOK Will be given to Premium Users.</p>
                        <p class="card-text p-2 m-2 rounded border-info" style="border: 1px solid #008000;">2. Website Chat feature will be active 24*7</p>
                        <p class="card-text p-2 m-2 rounded border-info" style="border: 1px solid #008000;">3. You Can request Choice Filling Once You Join Us.</p>
                        <p class="card-text p-2 m-2 rounded border-info" style="border: 1px solid #008000;">4. You Can request call anytime to your mentdark</p>
                        <p class="card-text p-2 m-2 rounded border-info" style="border: 1px solid #008000;">5. Your Every Step in Counselling Process will be displayed on your profile</p>
                        <p class="card-text p-2 m-2 rounded border-info" style="border: 1px solid #008000;">6. Google Meet will be conducted in Every 10 Days</p>
                        
                        <input type="submit" name="hstes_counselling" value="Proceed Now" class="bt btn-info btn-block btn-lg" id="proceed-now">
                        <button id="hide-btn-services" class="btn btn-info" style="display: none;">Hide</button>
                        
                        <div class="wrapper" id="services-box">
                        <form action="#" method="post" class="px-3" id="services-form" name="services-form" style="display: none;">
                        <p class="card-text p-2 m-2 rounded border-dark" style="border: 1px solid #008000;">Counselling Name :<select name="counselling" id="counselling" class="form-control">
                          <option>HSTES</option>
                          <option>UPTU</option>
                          <option>MPDTE</option>
                          <option>REAP</option>
                          <option>UGEAC</option>
                          <option>JOSAA</option>
                        </select></p>
                        <input type="text" class="" name="amount" value="299" id="amount" hidden>

                        <input type="submit" id="services-btn" value="Submit" name="submit" class="btn btn-primary btn-lg btn-block myBtn"/>
                        <div class="payment" id="payment"></div>

                        </form>
                      
                      </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                    <div class="card border-info align-self-center">
                      <img src="./assets/php/photo/cropped-COLLEG-1.png" class="img-thumbnail img-fluid" width="408px">
                    </div>
                  </div>
                 </div>

                 </div>
            </div>
          </card>
        </div>
      </div>
    </div>
  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
      $("#proceed-now").click(function(){
        $("#services-form").show();
        $("#hide-btn-services").show();
      });

      $("#hide-btn-services").click(function(){
        $("#services-form").hide();
        $("#hide-btn-services").hide();
      });

      // services ajax request 
      $("#services-form").submit(function(e){
        e.preventDefault();

        $.ajax({
          url: 'assets/php/payment/payment.php',
          method: 'post',
          data: $("#services-form").serialize()+'&action=counselling_submit1',
          success: function(response){
           $("#payment").html(response);
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
      </script>
  </body>
  </html>