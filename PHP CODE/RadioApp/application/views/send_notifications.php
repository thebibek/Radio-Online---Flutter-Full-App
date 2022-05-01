<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Send Notifications | <?php echo SITE_NAME; ?></title>        
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
                                        <h2 id="mydesc">Send Notifications</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class='row'>
                                            <div class='col-md-6 col-sm-12'>
                                                <form id="notification_form" method="POST" action="<?php echo base_url(); ?>send_notifications" data-parsley-validate="" class="form-horizontal form-label-left" enctype="multipart/form-data">                                                

                                                    <div class="form-group">
                                                        <input name="include_category" id="include_category"  type="checkbox"> Include Category
                                                    </div>
                                                    <div class="form-group">
                                                        <select name="cat_id" id="cat_id" class="form-control" style='display:none;'>
                                                            <option value="0">Select Category</option>
                                                            <?php
                                                            foreach ($cate as $cate1) {
                                                                echo '<option value="' . $cate1->id . '">' . $cate1->category_name . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select name="radio_sation" id="radio_sation" class="form-control" style='display:none;'>
                                                            <option value="0">Select Radio Station</option>                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="" for="title">Title</label>
                                                        <input type="text" id="title" name="title" required class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="" for="message">Message</label>
                                                        <textarea id="message" name="message" required class="form-control col-md-7 col-xs-12" ></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="include_image" id="include_image"  type="checkbox"> Include image
                                                    </div>
                                                    <div class="form-group">
                                                        <input type='file' name="image" id="image" class="form-control" style='display:none;'> 
                                                    </div>
                                                    <div class="ln_solid"></div>
                                                    <div id="result"></div>
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input name="btnadd" type="submit" id="submit_btn" value="Send Notification" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                    <div class="form-group"> 
                                                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-2">
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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content">
                                        <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-1">
                                            <p id="delete_msg" style="display:none;" class="alert alert-success"></p>
                                         </div>
                                        <table aria-describedby="mydesc"  class='table-striped' id='notification_list'
                                               data-toggle="table"
                                               data-url="<?php echo base_url() . 'Table/notification' ?>"
                                               data-click-to-select="true"
                                               data-side-pagination="server"
                                               data-pagination="true"
                                               data-page-list="[5, 10, 20, 50, 100, 200]"
                                               data-search="true" data-show-columns="true"
                                               data-show-refresh="true" data-trim-on-search="false"
                                               data-sort-name="id" data-sort-order="desc"
                                               data-mobile-responsive="true"
                                               data-toolbar="#toolbar" 
                                               data-maintain-selected="true"
                                               data-show-export="false" data-export-types='["txt","excel"]'
                                               data-export-options='{
                                               "fileName": "notifications-list-<?= date('d-m-y') ?>",
                                               "ignoreColumn": ["state"]	
                                               }'
                                               data-query-params="queryParams_1"
                                               >
                                            <thead>
                                                <tr>
                                                    <th scope="col" data-field="id" data-checkbox="true"  data-visible="false">Id</th>
                                                    <th scope="col" data-field="cate_id" data-sortable="true" data-visible="false">CategoryId</th>
                                                    <th scope="col" data-field="id1" data-sortable="true">#</th>
                                                    <th scope="col" data-field="category" data-sortable="true">Category</th>  
                                                    <th scope="col" data-field="radio_station" data-sortable="true">Radio Station</th> 
                                                    <th scope="col" data-field="title" data-sortable="true">Title</th>
                                                    <th scope="col" data-field="message" data-sortable="true">Message</th>
                                                    <th scope="col" data-field="image" data-sortable="true">Image</th>
                                                    <th scope="col" data-field="date_sent" data-sortable="true">Date Sent</th>
                                                    <th scope="col" data-field="operate" data-sortable="true">Operate</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
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
        $('#cat_id').on('change', function (e) {
            var category_id = $('#cat_id').val();
            var base_url = "<?php echo base_url(); ?>";
            $.ajax({
                type: 'POST',
                url: base_url + 'Dashboard/get_station_category',
                data: 'category_id=' + category_id,
                beforeSend: function () {
                    $('#radio_sation').html('Please wait..');
                },
                success: function (result) {
//                    alert(result);
//                    $.each(result, function (i, item) {
//                        alert(item);
//                    });
                    $('#radio_sation').append(result);
                }
            });
        });
    </script>

    <script>
        $("#include_category").change(function () {
            if (this.checked) {
                $('#cat_id').show('fast');
                $('#radio_sation').show('fast');
            } else {
                $('#cat_id').hide('fast');
                $('#radio_sation').hide('fast');
            }
        });
        $("#include_image").change(function () {
            if (this.checked) {
                $('#image').show('fast');
            } else {
                $('#image').val('');
                $('#image').hide('fast');
            }
        });
    </script>

    <script>
        function queryParams(p) {
            return {
                "status": $('#filter_status').val(),
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search
            };
        }
    </script>
    <script type="text/javascript">
        $(document).on('click', '.delete-data', function () {
            if (confirm('Are you sure? Want to delete notification?')) {
                var base_url = "<?php echo base_url(); ?>";
                id = $(this).data("id");
                image = $(this).data("image");
                $.ajax({
                    url: base_url + 'Dashboard/delete_notification',
                    type: "post",
                    data: 'id=' + id + '&image_url=' + image,
                    success: function (result) {                       
                        if (result) {
                            $('#delete_msg').html(result);
				$('#delete_msg').show().delay(4000).fadeOut();

                            $('#notification_list').bootstrapTable('refresh');
                        } 
                    },
                    error: function (result) {
                        alert("Error " + result);
                    }
                });
            }
        });
    </script>

</body>
</html>