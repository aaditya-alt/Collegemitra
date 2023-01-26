<?php
    require_once './assets/php/header.php';

?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 mt-3">
        <?php if($premium == 'Subscribed!'): ?>
          <div class="card border-primary">
            <div class="card-header lead text-center bg-primary text-white">
              Send Feedback to Your Mentor!
            </div>
            <div class="card-body">
              <form action="#" method="post" class="px-4" id="feedback-form">
               
              <div class="form-group">
                <input type="text" name="subject" placeholder="Write Your Subject" class="form-control-lg form-control rounded-0" required>
              </div>

              <div class="form-group">
                <textarea name="feedback" rows="8" class="form-control-lg form-control rounded-0" placeholder="Write Your Message Here..." required></textarea>
              </div>

              <div class="form-grou">
                <input type="submit" name="feedbackBtn" id="feedbackBtn" value="Send Message" class="btn btn-primary btn-block btn-lg rounded-0">
              </div>


              </form>
            </div>
          </div>
          <?php else: ?>
            <h1 class="text-center text-secondary mt-5">Purchase Our <b style="color: red;">Premium Plan</b> First to Send Feedback to Mentor!</h1>
            <button class="btn btn-success btn-block btn-lg"><a style="color: inherit;" href="services.php">Purchase Now</a></button>
            <?php endif; ?>
      </div>
    </div>
  </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script>
      $(document).ready(function(){
    
    $("#feedbackBtn").click(function(e){
        if($("#feedback-form")[0].checkValidity()){
            e.preventDefault();
            $(this).val('Please Wait...');

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: $("#feedback-form").serialize()+'&action=feedback',
                success:function(response){
                    $("#feedback-form")[0].reset();
                    $("#feedbackBtn").val('Send Feedback');
                     Swal.fire({
                        title: 'Feedback Successfully sent to the Mentor!',
                        type: 'success'
                     })
                }
            });
        }
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

});
    </script>

  </body>
  </html>