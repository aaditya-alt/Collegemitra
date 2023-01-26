<?php 
  require_once 'assets/php/admin-header.php';

?>

<div class="row">
<div class="col-lg-12">
        <div class="card my-2 border-info">
            <div class="card-header bg-info text-white d-flex justify-content-between">
                <h4 class="m-0">Total Choice Filling Request</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllChoiceFilling">
                    <p class="text-center align-self-center lead">Please Wait...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reply choice filling modal -->
<div class="modal fade" id="sendChoiceFillingModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send Choice Filling</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="px-3" id="send-choice-filling-form">
                    <div class="form-group">
                        <label for="">CID :</label>
                        <input type="text" name="cid" value="" id="cid">
                    </div>
                    <div class="form-group">
                        <label for="">UID :</label>
                        <input type="text" name="uid" value="" id="uid">
                    </div>
                    <div class="form-group">
                        <textarea name="note" id="note" class="form-control" rows="6" placeholder="Write your message here..." required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" name="pdf" id="pdf" placeholder="Upload PDF Here :" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Send Now" class="btn btn-primary btn-block" id="sendChoiceFillingBtn">
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

<script type="text/javascript">

    $(document).ready(function(){
        $("#open-nav").click(function(){
            $(".admin-nav").toggleClass('animate');
        });

         //Fetch all feedback of users ajax request
         fetchAllChoiceFilling();
        function fetchAllChoiceFilling(){
            $.ajax({
                url:'assets/php/admin-action.php',
                method: 'post',
                data: {action: 'fetchAllChoiceFilling'},
                success: function(response){
                    $("#showAllChoiceFilling").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    })
                }
            });
        }


        //Send choice filling to the user
        var uid;
        var fid;
        $("body").on("click", ".sendChoiceFilling", function(e){
            uid = $(this).attr('id');
            cid = $(this).attr('fid');
            $("#cid").val(cid);
            $("#uid").val(uid);
        });

        $("#send-choice-filling-form").submit(function(e){
            if($("#send-choice-filling-form")[0].checkValidity()){
                e.preventDefault();
                $("#sendChoiceFillingBtn").val('Please Wait...');

                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: new FormData(this),
                    success: function(response){
                        console.log(response);
                        $("#sendChoiceFillingBtn").val('Send Now');
                       $("#send-choice-filling-form")[0].reset();
                       $("#sendChoiceFillingModal").modal('hide');
                       Swal.fire({
                        title: 'Update added Successfully!',
                        type: 'success',
                       });
                       location.reload();
                    }
                });
            }
        });

    });


</script>