<?php 
  require_once 'assets/php/admin-header.php';

?>
<h4 class="text-center text-info mt-2">Call Requests</h4>
<div class="card border-info">
    <h5 class="card-header bg-info d-flex justify-content-between">
        <span class="text-light lead align-self-center"><b>All Call Requests</b></span>
    </h5>
    <div class="card-body">
        <div class="table-responsive" id="showCalls">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>JEE Rank</th>
                        <th>Category</th>
                        <th>Phone</th>
                        <th>Home State</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>aaditya</td>
                        <td>131</td>
                        <td>EWS</td>
                        <td>999</td>
                        <td>Bihar</td>
                        <td>
                            <a href="#" title="Call done" class="text-danger callDoneBtn"><i class="fas fa-call-alt fa-lg"></i></a>&nbsp;
                        </td>
                    </tr>
                </tbody>
            </table>
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
    });
</script>

<script type="text/javascript">
   $(document).ready(function(){
        $("table").DataTable();

       // Display calling list of the counselling mentor
        displayAllCalls();
        function displayAllCalls(){
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: { action: 'display_calls'},
                success: function(response){
                    $("#showCalls").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }

        //Delete an update of a mentor ajax request
        $("body").on("click", ".callDoneBtn", function(e){
            e.preventDefault();
            del_id = $(this).attr('id');

            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
              if (result.value) {
                 $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {del_id: del_id},
                    success: function(response){
                        Swal.fire(
                          'Deleted!',
                          'Your Update has been deleted.',
                          'success'
                          )
                        displayAllCalls();
                    }
                 });
      
            }
            });
        });

    });
</script>

</body>
</html>