<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Radio Station | <?php echo SITE_NAME; ?></title>        
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
                                <h3>Create and Manage Radio Station</h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Add Radio Station</h2>                                
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">

                                        <form action="<?php echo base_url(); ?>radio_station" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                            <?php if (is_city_mode_enabled() == 1) { ?>
                                                <div class="form-group row">
                                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">City</label>
                                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                                        <select name="city_id" id="city_id" class="form-control" required>
                                                            <option value="">Select City</option>
                                                            <?php
                                                            foreach ($city as $city1) {
                                                                echo '<option value="' . $city1->id . '">' . $city1->city_name . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div> 

                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Category</label>
                                                <div class="col-md-4 col-sm-10 col-xs-12">
                                                    <select name="cat_id" id="cat_id" class="form-control">
                                                        <option value="0">Select Category</option>
                                                        <?php
                                                        foreach ($cate as $cate1) {
                                                            echo '<option value="' . $cate1->id . '">' . $cate1->category_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Radio Name</label>
                                                <div class="col-md-4 col-sm-10 col-xs-12">
                                                    <input type="text" name="radio_name" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Radio Stream Url</label>
                                                <div class="col-md-4 col-sm-10 col-xs-12">
                                                    <input type="url" name="radio_url" class="form-control" required>
                                                </div>

                                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Image</label>
                                                <div class="col-md-4 col-sm-10 col-xs-12">
                                                    <input type="file" name="file" class="form-control" required>
                                                    <small class="text-danger">Only png, jpg and jpeg image allow</small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-12 col-xs-12">Description</label>
                                                <div class="col-md-10 col-sm-12 col-xs-12">
                                                    <textarea name="description" class="form-control"></textarea>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-2 col-sm-2 col-xs-12 pull-right">
                                                    <input name="btnadd" value="Submit" type="submit" class="form-control btn btn-primary">
                                                </div>
                                            </div>
                                            <div class="form-group"> 
                                                <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-2">
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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2 id="mydesc">View Radio Station</h2>                                
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-1">
                                            <p id="delete_msg" style="display:none;" class="alert alert-success"></p>
                                        </div>

                                        <table aria-describedby="mydesc"  class='table-striped' id='radio_station_list'
                                               data-toggle="table"
                                               data-url="<?php echo base_url() . 'Table/radio_station' ?>"
                                               data-click-to-select="true"
                                               data-side-pagination="server"
                                               data-pagination="true"
                                               data-page-list="[5, 10, 20, 50, 100, 200]"
                                               data-search="true" data-show-columns="true"
                                               data-show-refresh="true" data-trim-on-search="false"
                                               data-sort-name="id" data-sort-order="desc"
                                               data-mobile-responsive="true"
                                               data-toolbar="#toolbar" data-show-export="true"
                                               data-maintain-selected="true"
                                               data-export-types='["txt","excel"]'
                                               data-export-options='{
                                               "fileName": "categoty-list-<?= date('d-m-y') ?>",
                                               "ignoreColumn": ["state"]	
                                               }'
                                               data-query-params="queryParams"
                                               >
                                            <thead>
                                                <tr>
                                                    <th scope="col" data-field="id1" data-sortable="true">Sr. No</th>
                                                    <th scope="col" data-field="id" data-sortable="true" data-visible='false'>ID</th>
                                                    <?php if (is_city_mode_enabled() == 1) { ?>
                                                        <th scope="col" data-field="city_id" data-sortable="true" data-visible="false">City ID</th>
                                                        <th scope="col" data-field="city_name" data-sortable="true">City</th>
                                                    <?php } ?>
                                                    <th scope="col" data-field="cat_id" data-sortable="true" data-visible='false'>Category id</th>
                                                    <th scope="col" data-field="category_name" data-sortable="true">Category Name</th>
                                                    <th scope="col" data-field="radio_name" data-sortable="true">Name</th>
                                                    <th scope="col" data-field="radio_url" data-sortable="true">Radio Stream Url</th>
                                                    <th scope="col" data-field="image" data-sortable="true">Image</th>
                                                    <th scope="col" data-field="description" data-sortable="true">Description</th>
                                                    <th scope="col" data-field="operate" data-sortable="true" data-events="actionEvents">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->

                <!-- modal -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Edit Radio Station
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </h4>   
                            </div>

                            <form id="profileForm" action="<?php echo base_url(); ?>radio_station" method="post" enctype="multipart/form-data"> 
                                <div class="modal-body">
                                    <?php if (is_city_mode_enabled() == 1) { ?>
                                        <div class="form-group">
                                            <label class="control-label">City</label>                                    
                                            <select name="update_city_id" id="update_city_id" class="form-control" required>
                                                <?php
                                                foreach ($city as $city1) {
                                                    echo '<option value="' . $city1->id . '">' . $city1->city_name . '</option>';
                                                }
                                                ?>
                                            </select>                                 
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label class="control-label">Category</label>                                    
                                        <select name="update_cat_id" id="update_cat_id" class="form-control">
                                            <!--<option value="0">Select Category</option>-->
                                            <?php
                                            foreach ($cate as $cate1) {
                                                echo '<option value="' . $cate1->id . '">' . $cate1->category_name . '</option>';
                                            }
                                            ?>
                                        </select>                                 
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Radio Name</label>
                                        <input type="text" name='update_name' id="update_name" class="form-control" autocomplete="off" required>                             
                                        <input type="hidden" value="" name='radio_station_id' id="radio_station_id">
                                        <input type="hidden" value="" name='image_url' id="image_url">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Radio Stream Url</label>
                                        <input type="url" name='update_radio_url' id="update_radio_url" class="form-control" autocomplete="off" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Image</label>
                                        <input type="file" name='update_file' id="update_file" class="form-control">
                                        <small class="text-danger">Only png, jpg and jpeg image allow</small>
                                    </div>

                                    <div class="form-group oldimage"></div> 

                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <textarea name='update_description' id="update_description" class="form-control" autocomplete="off"></textarea>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <input type="submit" value="Close" class="btn btn-default" data-dismiss="modal">
                                    <input name="btnupdate" type="submit" value="Save changes" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php base_url() . include 'footer.php'; ?>  

        <script>
<?php if (is_city_mode_enabled() == 1) { ?>
                $('#city_id').on('change', function (e) {
                    var city_id = $('#city_id').val();
                    var base_url = "<?php echo base_url(); ?>";
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'Dashboard/get_category_by_city',
                        data: 'city_id=' + city_id,
                        beforeSend: function () {
                            $('#cat_id').html('Please wait..');
                        },
                        success: function (result) {
                            $('#cat_id').html(result);
                        }
                    });
                });

                $('#update_city_id').on('change', function (e, row_city, row_category) {
                    var city_id = $('#update_city_id').val();
                    var base_url = "<?php echo base_url(); ?>";
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'Dashboard/get_category_by_city',
                        data: 'city_id=' + city_id,
                        beforeSend: function () {
                            $('#update_cat_id').text('Please wait..');
                        },
                        success: function (result) {
                            $('#update_cat_id').html(result);
                            if (city_id == row_city && row_category != 0)
                                $('#update_cat_id').val(row_category);
                        }
                    });
                });
    category_options = '';
    <?php
    $category_options = "<option value=''>Select Category</option>";
    foreach ($cate as $cate1) {
        $category_options .= "<option value='".$cate1->id."'>".$cate1->category_name."</option>";
    }
    ?>
   category_options = "<?= $category_options; ?>";
<?php } ?>
        </script>

        <script>
            $(document).ready(function () {
                $('#error_msg').delay(3000).fadeOut();
                $('#success_msg').delay(3000).fadeOut();
            });
        </script>
        <script>
            function queryParams(p) {
                return {
                    limit: p.limit,
                    sort: p.sort,
                    order: p.order,
                    offset: p.offset,
                    search: p.search
                };
            }
        </script>
        <script>
            $('#editModal').on('hidden.bs.modal', function () {

                $('#update_cat_id').empty();
            });

        </script>
        <script>
            window.actionEvents = {
                'click .edit-data': function (e, value, row, index) {
//                    alert('You click remove icon, row: ' + JSON.stringify(row));

                    var id = $(this).data("id");
                    var image = $(this).data("image");

                    $('#radio_station_id').val(id);
<?php if (is_city_mode_enabled() == 1) { ?>
                        if (row.city_id == 0) {
                            $('#update_city_id').val(row.city_id);
                            $('#update_cat_id').html(category_options);
                            $('#update_cat_id').val(row.cat_id);
                        } else {
                            $('#update_city_id').val(row.city_id).trigger("change", [row.city_id, row.cat_id]);
                        }
<?php } else { ?>
                        $('#update_cat_id').val(row.cat_id);
<?php } ?>
                    $('#update_name').val(row.radio_name);
                    $('#update_radio_url').val(row.radio_url);
                    $('#image_url').val(image);
                    $('div.oldimage').html("<img id='oldimage' src=" + image + " height='60' width='150'>");
                    $('#update_description').text(row.description);
                }
            };
        </script>
        <script>
            $(document).on('click', '.delete-data', function () {
                if (confirm('Are you sure? Want to delete radio_station? All related Slider will also be deleted')) {
                    var base_url = "<?php echo base_url(); ?>";
                    id = $(this).data("id");
                    image = $(this).data("image");
                    $.ajax({
                        url: base_url + 'Dashboard/delete_radio_station',
                        type: "POST",
                        data: 'id=' + id + '&image_url=' + image,
                        success: function (result) {
                            if (result) {
                                $('#delete_msg').html(result);
                                $('#delete_msg').show().delay(4000).fadeOut();
                                $('#radio_station_list').bootstrapTable('refresh');
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