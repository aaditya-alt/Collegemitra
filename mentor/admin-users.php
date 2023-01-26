<?php 
  require_once 'assets/php/admin-header.php';

?>

<div class="row">
    <div class="col-lg-12">
        <div class="card my-2 border-success">
            <div class="card-header bg-success text-white d-flex justify-content-between">
                <h4 class="m-0">Total Registered Users</h4>
                <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add New User</a>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllUsers">
                    <p class="text-center align-self-center lead">Please Wait...</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Display user's details -->
<div class="modal fade" id="showUserDetailsModal">
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
                            <p id="getEmail"></p>
                            <p id="getPhone"></p>
                            <p id="getCreated"></p>
                            <p id="getGender"></p>
                            <p id="getRank"></p>
                        </div>
                    </div>
                    <div class="card align-self-center" id="getImage"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!--Add new user modal -->

<div class="modal fade" id="addUserModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
               <h4 class="modal-title text-light">Add New User</h4>
               <button class="close text-light" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="add-user-form" class="">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter Name " required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control form-control-lg" placeholder="Enter Phone No. " required>
                    </div>
                    <div class="form-group">
                    <input type="text" name="rank" class="form-control form-control-lg" placeholder="Enter JEE Rank " required>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="addUser" value="Add User" id="addUserBtn" class="btn btn-success btn-block btn-lg">
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
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">

     $(document).ready(function(){

        //Fetch all users ajax request
        fetchAllUsers();
        function fetchAllUsers(){
            $.ajax({
                url:'assets/php/admin-action.php',
                method: 'post',
                data: {action: 'fetchAllUsers'},
                success: function(response){
                    $("#showAllUsers").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    })
                }
            });
        }

        //Display User in Details Ajax request
        $("body").on("click", ".userDetailsIcon", function(e){
            e.preventDefault();

            details_id = $(this).attr("id");
            $.ajax({
                url: 'assets/php/admin-action.php',
                type: 'post',
                data: {details_id: details_id},
                success: function(response){
                    data = JSON.parse(response);
                    console.log(data);
                    $("#getName").text(data.name+' '+ '(ID: '+data.id+')');
                    $("#getEmail").text('Email : '+data.email);
                    $("#getPhone").text('Phone : '+data.phone);
                    $("#getGender").text('Gender : '+data.gender);
                    $("#getCreated").text('Joined On : '+data.created_at);

                    if(data.photo != ''){
                        $("#getImage").html('<img src="../assets/php/'+data.photo+'"class="img-thumbnail img-fluid align-self-center width="280px">');
                    }
                    else{
                        $("#getImage").html('<img src="../assets/php/photo/dummy-image.jpg'+data.photo+'"class="img-thumbnail img-fluid align-self-center width="280px">');
                    }
                }
            });
        });

        //Add new user in counselling
        $("#add-user-form").submit(function(e){
            if($("#add-user-form")[0].checkValidity()){
                e.preventDefault();

                $("#addUserBtn").val('Please Wait...');

                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: $("#add-user-form").serialize()+'&action=addUser',
                    success: function(response){
                        console.log(response);
                    }
                });
            }
        });
    });
</script>
</body>
</html>