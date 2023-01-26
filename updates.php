<?php
    require_once './assets/php/header.php';

?>
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card my-2 border-info">
        <div class="card-header bg-info text-white">
          <h4 class="m-0"><b>Updates From The Counselling</b></h4>
        </div>
        <div class="card-body">
          <div class="table-responsive" id="showAllUpdates">
          <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Update</th>
                        <th>PDF</th>
                        <th>Counselling</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>HSTES</td>
                        <td>HSTES</td>
                        <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti nam animi fugiat exercitationem aliquid tempora omnis id quas nihil, accusantium, qui, saepe beatae est eveniet deserunt non totam minima ipsam.</td>
                        <td></td>
                        <td>
                            <a href="#" title="View Details" class="text-success infoBtn"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;

                        </td>
                    </tr>
                </tbody>
            </table>
            
            <p class="text-center align-self-center lead">Please Wait...</p>
          </div>
        </div>
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
      $("table").DataTable();

      //Fetch all updates ajax request
      fetchAllUpdates();
        function fetchAllUpdates(){
            $.ajax({
                url:'assets/php/process.php',
                method: 'post',
                data: {action: 'fetchAllUpdates'},
                success: function(response){
                    $("#showAllUpdates").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }

        //View user details ajax request
        $("body").on("click", ".infoBtn", function(e){
            e.preventDefault();

            info_id = $(this).attr('id');

            $.ajax({
                url:'assets/php/process.php',
                method: 'post',
                data: {info_id: info_id},
                success: function(response){
                    data = JSON.parse(response);
                    Swal.fire({
                        title: '<strong>Note : ID('+data.counselling+')</strong>',
                        type: 'info',
                        html: '<b>Title :</b>'+data.title+'<br><br><b>Note : </b>'+data.update+'<br><br><b>File Attached : </b><a href="assets/php/'+data.pdf+'">Download Now</a>'+'<br><br><b>Written On :</b>'+data.created_at+'<br><br><b>Updated On : </b>'+data.updated_at,
                        showcloseButton: true,
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
     });


    </script>


  </body>
  </html>