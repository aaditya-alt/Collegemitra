<?php 
  require_once 'assets/php/admin-header.php';

?>

<h4 class="text-center text-primary mt-2">Give All The Updates Regarding Your Counselling Here</h4>
<div class="card border-primary">
    <h5 class="card-header bg-primary d-flex justify-content-between">
        <span class="text-light lead align-self-center"><b>All Updates</b></span>
        <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addUpdateModal"><i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add New Update</a>
    </h5>
    <div class="card-body">
        <div class="table-responsive" id="showUpdate">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Update</th>
                        <th>PDF</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>HSTES</td>
                        <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti nam animi fugiat exercitationem aliquid tempora omnis id quas nihil, accusantium, qui, saepe beatae est eveniet deserunt non totam minima ipsam.</td>
                        <td></td>
                        <td>
                            <a href="#" title="View Details" class="text-success infoBtn"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;

                            <a href="#" title="Edit Updates" class="text-primary editBtn"><i class="fas fa-edit fa-lg" data-toggle="modal" data-target="#editUpdateModal"></i></a>&nbsp;

                            <a href="#" title="Delete Updates" class="text-danger deleteBtn"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add update modal -->
<div class="modal fade" id="addUpdateModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
               <h4 class="modal-title text-light">Add New Update</h4>
               <button class="close text-light" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="add-update-form" class="">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter Title" required>
                    </div>
                    <div class="form-group">
                        <textarea name="update" class="form-control form-control-lg" placeholder="Write Update Here..." id="" rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                    <label for="updatePDF" class="m-1">Upload PDF </label>
                        <input type="file" name="updatePDF" id="updatePDF">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="addUpdate" value="Add Update" id="addUpdateBtn" class="btn btn-success btn-block btn-lg">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Start edit update modal -->
<div class="modal fade" id="editUpdateModal"> <div class="modal-dialog
modal-dialog-centered"> <div class="modal-content"> <div class="modal-header
bg-info"> <h4 class="modal-title text-light">Edit Update</h4> <button
class="close text-light" type="button" data-dismiss="modal">&times;</button>
</div> <div class="modal-body"> <form action="#" method="post"
id="edit-update-form" class=""> <input type="hidden" name="id" id="id"> <div
class="form-group"> <input type="text" name="title" class=if($row['pdf']=='uploads/')"form-control
form-control-lg" placeholder="Enter Title" id="title" required> </div> <div
class="form-group"> <textarea name="editUpdate" class="form-control
form-control-lg" placeholder="Write Update Here..." rows="6" id="editUpdate"
required></textarea> </div> <div class="form-group"> <label for="updatePDF"
class="m-1">Upload PDF </label> <input type="file" name="editPDF"
id="editPDF"> </div> <div class="form-group"> <input type="submit"
name="submit" value="Update" id="editUpdateBtn" class="btn btn-info btn-block
btn-lg"> </div> </form> </div> </div> </div> </div>


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

        //Add New Update ajax request
        $("#add-update-form").submit(function(e){
            if($("#add-update-form")[0].checkValidity()){
                e.preventDefault();

                $("#addUpdateBtn").val('Please Wait...');

                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: new FormData(this),
                    success: function(response){
                       $("#addUpdateBtn").val('Add Update');
                       $("#add-update-form")[0].reset();
                       $("#addUpdateModal").modal('hide');
                       Swal.fire({
                        title: 'Update added Successfully!',
                        type: 'success',
                       });
                       location.reload();
                    }
                });
            }
        });

        //Edit Update of an mentor ajax request
        $("body").on("click", ".editBtn", function(e){
            e.preventDefault();

            edit_id = $(this).attr('id');
            
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {edit_id: edit_id},
                success: function(response){
                    data = JSON.parse(response);
                    
                    $("#id").val(data.id);
                    $("#title").val(data.title);
                    $("#editUpdate").val(data.update);

                    

                }
            });
        });

        //Update note of a mentor ajax request
        $("#edit-update-form").submit(function(e){
            if($("#edit-update-form")[0].checkValidity()){
                e.preventDefault();

                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: new FormData(this),
                    success: function(response){
                        Swal.fire({
                            title: 'Updates Done Successfully!',
                            type: 'success'
                        });
                        $("#edit-update-form")[0].reset();
                        $("#editUpdateModal").modal('hide');
                        location.reload();
                    }
                    
                });
            }
        });


        //Delete an update of a mentor ajax request
        $("body").on("click", ".deleteBtn", function(e){
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
                        displayAllUpdates();
                    }
                 });
      
            }
            });
        });


        //Display updates in detail ajax request
        $("body").on("click", ".infoBtn", function(e){
            e.preventDefault();

            info_id = $(this).attr('id');

            $.ajax({
                url:'assets/php/admin-action.php',
                method: 'post',
                data: {info_id: info_id},
                success: function(response){
                    data = JSON.parse(response);
                    Swal.fire({
                        title: '<strong>Note : ID('+data.counselling+')</strong>',
                        type: 'info',
                        html: '<b>Title :</b>'+data.title+'<br><br><b>Note : </b>'+data.update+'<br><br><b>File Attached : </b><a href="assets/php/'+data.pdf+'">Download Now</a>'+'<br><br><b>Written On :</b>'+data.created_at+'<br><br><b>Updated On : </b>'+data.updated_at,
                        showcloseButton: true,
                    })
                }

            });

        });

        


        //Display updates of the mentor
        displayAllUpdates();
        function displayAllUpdates(){
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: { action: 'display_updates'},
                success: function(response){
                    $("#showUpdate").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>


</body>
</html>