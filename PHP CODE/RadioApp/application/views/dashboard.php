<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard | <?php echo SITE_NAME; ?></title>        
        <?php base_url() . include 'include.php'; ?>  
    </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container"> 
            <?php base_url() . include 'header.php'; ?>  
<!-- page content -->
        <div class="right_col" role="main">
            <div class="">

                <div class="row top_tiles">
                    <?php if(is_city_mode_enabled() == 1){ ?>
                     
                     <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                             <a href="<?php echo base_url(); ?>city">
                            <div class="icon"><em class="fa fa-building-o"></em></div>
                            <div class="count"><?php echo $Count_city; ?></div>
                            <h3>City</h3>
                             <p></p>
                             </a>
                        </div>
                    </div>       
                        
                        <?php }?>   
                    
                     <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                             <a href="<?php echo base_url(); ?>slider">
                            <div class="icon"><em class="fa fa-sliders"></em></div>
                            <div class="count"><?php echo $Count_slider; ?></div>
                            <h3>Slider</h3>
                             <p></p>
                             </a>
                        </div>
                    </div>       

                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                             <a href="<?php echo base_url(); ?>category">
                            <div class="icon"><em class="fa fa-list-alt"></em></div>
                            <div class="count"><?php echo $Count_category; ?></div>
                            <h3>Category</h3>
                            <p></p>
                             </a>
                        </div>
                    </div>

                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                             <a href="<?php echo base_url(); ?>radio_station">
                            <div class="icon"><em class="fa fa-microphone"></em></div>
                            <div class="count"><?php echo $Count_radio_station; ?></div>
                            <h3>Radio Station</h3>
                             <p></p>
                             </a>
                        </div>
                    </div>                   

                </div>

            </div>
        </div>
        <!-- /page content -->
        <?php base_url() . include 'footer.php'; ?>  
  </body>
</html>