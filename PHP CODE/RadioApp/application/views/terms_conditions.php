<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Terms Conditions | <?php echo SITE_NAME; ?></title>        
        <?php base_url() . include 'include.php'; ?>  
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container"> 
                <?php base_url() . include 'header.php'; ?>  
                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">                       

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Terms Conditions<small>Terms for App Usage</small></h2>   
                                        <div class="col-md-4 pull-right">
                                            <a href="<?php echo base_url(); ?>play_store_terms_conditions" rel="noopener noreferrer" target='_blank' class='btn btn-primary'>Terms Conditions Page for Play Store</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">

                                        <form method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">

                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Terms Conditions</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <?php
                                                    if ($setting) {
                                                        foreach ($setting as $value) {
                                                            ?>
                                                            <textarea name='message' id='message' class='form-control'><?= $value->message; ?></textarea>
                                                        <?php }
                                                    }
                                                    ?>
                                                </div>                                                
                                            </div>
                                            <div class="form-group pull-right">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
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
            $(document).ready(function () {
                if ($("#message").length > 0) {
                    tinymce.init({
                        selector: "textarea#message",
                        theme: "modern",
                        height: 300,
                        plugins: [
                            'advlist autolink lists link charmap print preview anchor textcolor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime table contextmenu paste code help wordcount'
                        ],
                        toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                        style_formats: [
                            {title: 'Bold text', inline: 'b'},
                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                            {title: 'Table styles'},
                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                        ]
                    });
                }
            });
        </script>
    </body>
</html>