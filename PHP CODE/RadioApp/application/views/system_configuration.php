<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>System Settings | <?php echo SITE_NAME; ?></title>        
        <?php base_url() . include 'include.php'; ?>  
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container"> 
                <?php base_url() . include 'header.php'; ?>  
                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>System Settings</h2>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">

                                        <form action="<?php echo base_url(); ?>system_configurations" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">

                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-1 col-xs-12">City Mode</label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <?php
                                                    if ($setting) {
                                                        foreach ($setting as $value) {
                                                            ?>
                                                            <input type="checkbox" id="city_mode_btn" class="js-switch" <?php
                                                            if (!empty($value->message) && $value->message == '1') {
                                                                echo 'checked';
                                                            }
                                                            ?>>
                                                                   <?php
                                                               }
                                                           }
                                                           ?>
                                                    <input type="hidden" id="city_mode" name="city_mode" value="<?= (!empty($value->message)) ? $value->message : 0; ?>">

                                                </div>
                                            </div>
                                            <br/>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input name="btnadd" value="Submit" type="submit" class="form-control btn btn-primary">
                                                </div>
                                            </div>
                                            <div class="form-group"> 
                                                <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-2">
                                                    <?php if ($this->session->flashdata('success')) { ?>
                                                        <p id="success_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
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
                $('#success_msg').delay(3000).fadeOut();
            });
        </script>
        <script>
            /* on change of language mode btn - switchery js */
            var changeCheckbox = document.querySelector('#city_mode_btn');
            changeCheckbox.onchange = function () {
                // alert(changeCheckbox.checked);
                if (changeCheckbox.checked)
                    $('#city_mode').val(1);
                else
                    $('#city_mode').val(0);
            };
        </script>
    </body>
</html>
