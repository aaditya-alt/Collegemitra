$(function () {
    $("#register-link").click(function () {
      $("#login-box").hide();
      $("#register-box").show();
    });
    $("#login-link").click(function () {
      $("#login-box").show();
      $("#register-box").hide();
    });
    $("#forgot-link").click(function () {
      $("#login-box").hide();
      $("#forgot-box").show();
    });
    $("#back-link").click(function () {
      $("#login-box").show();
      $("#forgot-box").hide();
    });
     //Register ajax request

    $("#register-btn").click(function(e){
        if($("#register-form")[0].checkValidity()){
            e.preventDefault();
            $("#register-btn").val('Please Wait...');
            if($("#rpassword").val() != $("#cpassword").val()){
                $("#passError").text('*Password did not matched!');
                $("#register-btn").val('Sign Up');
            }
            else{
                $("#passError").text('');
                $.ajax({
                    url: 'assets/php/action.php',
                    method: 'post',
                    data: $("#register-form").serialize()+'&action=register',
                    success: function(response){
                        $("#register-btn").val('Sign Up');
                        if(response === 'register'){
                            window.location = 'home.php';
                        }
                        else{
                            $("#regAlert").html(response);
                        }
                    }
                });
            }
        }
    });

    //Login ajax request
    $("#login-btn").click(function(e){
        if($("#login-form")[0].checkValidity()){
            e.preventDefault();

            $("#login-btn").val('Please Wait...');
            $.ajax({
                url: 'assets/php/action.php',
                method: 'post',
                data: $("#login-form").serialize()+'&action=login',
                success: function(response){
                    $("#login-btn").val('Sign In');
                    if($.trim(response) === 'login'){
                        window.location = 'home.php';
                     }
                    else{
                        $("#loginAlert").html(response);
                    }
                }
            });
        }
    });

    //Forgot Password ajax request
    $("#forgot-btn").click(function(e){
        if($("#forgot-form")[0].checkValidity()){
            e.preventDefault();

            $("#forgot-btn").val('Please Wait...');

            $.ajax({
                url: 'assets/php/action.php',
                method: 'post',
                data: $("#forgot-form").serialize()+'&action=forgot',
                success: function(response){
                    $("#forgot-btn").val("Reset Password");
                    $("#forgot-form")[0].reset();
                    $("#forgotAlert").html(response);
                    
                    
                }

            });
        }
    });

    // Profile Update Form ajax request
    $(document).ready(function(){
    
        $("#profile-update-form").submit(function(e){
            e.preventDefault();
            
            $.ajax({
              url: 'assets/php/process.php',
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(this),
                success: function(response){
                    location.reload();
                }
                
            });
        });
        
    });

    //Change password ajax request
    $("#changePassBtn").click(function(e){
        if($("#change-pass-form")[0].checkValidity()){
            e.preventDefault();
           $("#changePassBtn").val('Please Wait...'); 

           if($("#newpass").val() != $("#cnewpass").val()){
            $("#changepassError").text('* Password did not matched!');
            $("#changePassBtn").val('Change Password'); 
           }
           else{
            $.ajax({
               url: 'assets/php/process.php',
               method: 'post',
               data: $("#change-pass-form").serialize()+'&action=change_pass',
               success: function(response){
                $("#changepassAlert").html(response);
                $("#changePassBtn").val('Change Password');
                
                $("#change-pass-form")[0].reset();

               }
            });
           }
        }
    });

     
    
    
    
    

});

