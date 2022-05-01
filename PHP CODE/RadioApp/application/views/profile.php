<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Profile | <?php echo SITE_NAME; ?></title>        
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
                                <h3>Profile</h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content"><br />

                                        <form action="<?php echo base_url(); ?>profile" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">

                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Full Logo</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="file" id="full_file" name="full_file" class="form-control col-md-7 col-xs-12">
                                                    <input type="hidden" name="full_url" value="images/profile/<?= $full['message']; ?>">
                                                    <small class="text-danger">Only png, jpg and jpeg image allow</small>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-12">                                   
                                                    <img src="<?= base_url(); ?>images/profile/<?= $full['message']; ?>" alt="logo" width="200" height="50">
                                                </div>
                                            </div>                             

                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Half Logo</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="file" id="half_file" name="half_file" class="form-control col-md-7 col-xs-12">
                                                    <input type="hidden" name="half_url" value="images/profile/<?= $half['message']; ?>">
                                                    <small class="text-danger">Only png, jpg and jpeg image allow</small>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <img src="<?= base_url(); ?>images/profile/<?= $half['message']; ?>" alt="logo" width="50" height="50">
                                                </div>
                                            </div>                                

                                            <div class="ln_solid"></div>

                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    <input name="btnchange" value="Submit" type="submit" style="margin-left: 30%;" class="btn btn-primary">
                                                </div>
                                            </div>

                                            <div class="form-group"> 
                                                <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-1">
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

    </body>
</html>