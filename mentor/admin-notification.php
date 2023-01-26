<?php 
  require_once 'assets/php/admin-header.php';

?>

<div class="row">
    <div class="col-lg-6 mt-4" id="showNotification">

    </div>
</div>



<!--Footer area -->
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

<script>
    $(document).ready(function(){
        $("#open-nav").click(function(){
            $(".admin-nav").toggleClass('animate');
        });

        //fetch Notification ajax request
        fetchNotification();

        function fetchNotification(){
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {action: 'fetchNotification'},
                success: function(response){
                    $("#showNotification").html(response);
                }
            });
        }

        //Remove notification ajax request
        $("body").on("click", ".close", function(e){
            e.preventDefault();

            notification_id = $(this).attr('id');
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {notification_id: notification_id},
                success: function(response){
                    fetchNotification();
                }
            });
        });
    });
</script>
</body>
</html>