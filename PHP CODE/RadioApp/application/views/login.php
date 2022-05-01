<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login | <?php echo SITE_NAME; ?></title>

        <?php base_url() . include 'include.php'; ?>  

    </head>

    <body class="login">
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">

                        <form id="login_form" action="<?php echo base_url(); ?>loginMe" method="POST">
                            <h1>Login</h1>
                            <div>
                                <input type="text" name="Username" class="form-control" placeholder="Username" required/>
                            </div>

                            <div>
                                <input type="password" name="Password" class="form-control" placeholder="Password" required/>
                            </div>

                            <div>
                                <input name="btnadd" id="btnadd" value="Log in" type="submit" style="margin-left: 40%;" class="btn btn-default">
                            </div>                              

                            <div class="clearfix"></div>

                           <?php if ($this->session->flashdata('error')) { ?>
                                <p id="error_msg" class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
                           <?php } ?>
                                
                            <div class="separator">
                                <div class="clearfix"></div><br>
                                <img src="<?= base_url(); ?>images/profile/<?= $full['message']; ?>" alt="logo" width='300'>
                                <p><br>© <?= date('Y') ?> WRTeam</p>
                            </div>
                        </form>                      
                    </section>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="<?php echo base_url(); ?>assets/jquery/dist/jquery.min.js"></script>

        <script>
            $(document).ready(function () {  
                $('#error_msg').delay(3000).fadeOut();              
            });
        </script>

    </body>
</html>

