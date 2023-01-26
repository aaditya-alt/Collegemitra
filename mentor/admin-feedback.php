<?php 
  require_once 'assets/php/admin-header.php';

?>

<div class="row">
<div class="col-lg-12">
        <div class="card my-2 border-warning">
            <div class="card-header bg-warning text-white d-flex justify-content-between">
                <h4 class="m-0">Total Feedback From Students</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllFeedback">
                    <p class="text-center align-self-center lead">Please Wait...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reply feedback modal -->
<div class="modal fade" id="showReplyModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reply This Feedback</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="px-3" id="feedback-reply-form">
                    <div class="form-group">
                        <textarea name="message" id="message" class="form-control" rows="6" placeholder="Write your message here..." required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Send Reply" class="btn btn-primary btn-block" id="feedbackReplyBtn">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!--Footer area -->
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script>
    $(document).ready(function(){
        $("#open-nav").click(function(){
            $(".admin-nav").toggleClass('animate');
        });

         //Fetch all feedback of users ajax request
         fetchAllFeedback();
        function fetchAllFeedback(){
            $.ajax({
                url:'assets/php/admin-action.php',
                method: 'post',
                data: {action: 'fetchAllFeedback'},
                success: function(response){
                    $("#showAllFeedback").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    })
                }
            });
        }

        //Get the current row user id and feedback id
        var uid;
        var fid;
        $("body").on("click", ".replyFeedbackIcon", function(e){
            uid = $(this).attr('id');
            fid = $(this).attr('fid');
        });

        //Send ajax request for feedback reply to user 
        $("#feedbackReplyBtn").click(function(e){
            if($("#feedback-reply-form")[0].checkValidity()){
                let message = $("#message").val();
                e.preventDefault();
                $("#feedbackReplyBtn").val('Please Wait...');

                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {uid: uid, message: message, fid: fid},
                    success: function(response){
                        $("#feedbackReplyBtn").val('Send Reply');
                        $("#showReplyModal").modal('hide');
                        $("#feedback-reply-form")[0].reset();
                        Swal.fire(
                            'Sent!',
                            'Reply sent successfully to the user!',
                            'success'
                        )
                        fetchAllFeedback();
                    }
                });
            }
        });

    });
</script>
</body>
</html>