<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login V9</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->	
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/bootstrap/css/bootstrap.min.css"); ?>">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/"); ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/fonts/iconic/css/material-design-iconic-font.min.css"); ?>">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/animate/animate.css"); ?>">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/css-hamburgers/hamburgers.min.css"); ?>">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/animsition/css/animsition.min.css"); ?>">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/select2/select2.min.css"); ?>">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/daterangepicker/daterangepicker.css"); ?>">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/util.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/main.css"); ?>">
        <!--===============================================================================================-->
    </head>
    <body>


        <div class="container-login100" style="background-image: url('<?php echo base_url("assets/images/bg-01.jpg"
);
?>');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
                 <?php echo print_flash_message();   ?>
                <form action="<?php echo base_url('login'); ?>" class="login100-form validate-form" autocomplete="off" method="post" name="login" accept-charset="utf-8">
                    
                    <span class="login100-form-title p-b-37">
                        Sign In
                    </span>
                      <input type="hidden" name="login" value="submit">
                    <div class="wrap-input100 validate-input m-b-20" data-validate="Enter username or email">
                        <input class="input100" required type="email" name="email" value="<?php echo !empty($_POST['email'])?$_POST['email']:''; ?>" placeholder="username or email">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-25" data-validate = "Enter password">
                        <input class="input100" required type="password" name="password" value="" placeholder="password">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            
                            Sign In
                        </button>
                    </div>
                </form>
            </div>



        </div>
    </div>



    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="<?php echo base_url("assets/vendor/jquery/jquery-3.2.1.min.js"); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url("assets/vendor/animsition/js/animsition.min.js"); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url("assets/vendor/bootstrap/js/popper.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendor/bootstrap/js/bootstrap.min.js"); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url("assets/vendor/select2/select2.min.js"); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url("assets/vendor/daterangepicker/moment.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendor/daterangepicker/daterangepicker.js"); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url("assets/vendor/countdowntime/countdowntime.js"); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url("assets/js/main.js"); ?>"></script>

</body>
</html>