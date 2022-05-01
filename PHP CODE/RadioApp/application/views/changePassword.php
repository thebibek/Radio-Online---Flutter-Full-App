<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reset Password | <?php echo SITE_NAME; ?></title>        
        <?php base_url() . include 'include.php'; ?>  
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container"> 
                <?php base_url() . include 'header.php'; ?>  
                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">

                        <div class="page-title">
                            <div class="title_left">
                                <h3>Reset Password</h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content"><br />

                                        <form id="password_form" action="<?php echo base_url(); ?>resetpassword" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Old Password <span class="required">*</span></label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="password" id="old_password" name="oldpassword" class="form-control col-md-7 col-xs-12" required>
                                                </div>
                                                <label id="old_status"></label>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Password <span class="required">*</span></label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="password" id="new_password" name="newpassword" class="form-control col-md-7 col-xs-12" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <span class="required">*</span></label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="password" id="confirm_password" name="confirmpassword" class="form-control col-md-7 col-xs-12" required>
                                                </div>
                                            </div>

                                            <div class="ln_solid"></div>

                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    <input name="btnchange" value="Submit" type="submit" style="margin-left: 30%;" class="btn btn-primary">
                                                </div>
                                            </div>
                                            <div class="form-group"> 
                                                <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-3">
                                                    <?php if ($this->session->flashdata('success')) { ?>
                                                        <p id="success_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
                                                    <?php } ?>
                                                    <?php if ($this->session->flashdata('error')) { ?>
                                                        <p id="error_msg" class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- /page content -->

        <?php base_url() . include 'footer.php'; ?>  
        <script>
            $(document).ready(function () {
                $('#error_msg').delay(3000).fadeOut();
                $('#success_msg').delay(3000).fadeOut();
            });
        </script>


        <script>
            $(document).ready(function () {
                $('#old_password').on('blur input', function () {
                    var old_password = $(this).val();
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "checkOldPass",
                        data: {oldpass: old_password},
                        beforeSend: function () {
                            $('#old_status').html('Checking..');
                        },
                        success: function (result) {
                            if (result == 'True') {
                                $('#old_status').html("<i class='fa fa-check-circle fa-2x text-success'></i>");
                            } else {
                                $('#old_status').html("<i class='fa fa-times-circle fa-2x text-danger'></i>");
                                $('#old_password').focus();
                            }
                        },
                        error: function (result) {
                            $('#old_status').html("Error" + result);
                        }
                    });
                });
            });

        </script>

    </body>
</html>