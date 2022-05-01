<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>City | <?php echo SITE_NAME; ?></title>        
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
                                <h3>Create and Manage City</h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Add City</h2>                                
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">

                                        <form action="<?php echo base_url(); ?>city" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">

                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-1 col-xs-12">Name</label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>

                                               
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input name="btnadd" value="Submit" type="submit" class="form-control btn btn-primary">
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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2 id="mydesc">View City</h2>                                
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                         <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-1">
                                            <p id="delete_msg" style="display:none;" class="alert alert-success"></p>
                                         </div>
                                        <table aria-describedby="mydesc" class='table-striped' id='city_list'
                                               data-toggle="table"
                                               data-url="<?php echo base_url() . 'Table/city' ?>"
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
                                                    <th scope="col" data-field="name" data-sortable="true">City</th>
                                                   
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
                                <h4 class="modal-title" id="myModalLabel">Edit City
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </h4>   
                            </div>

                            <form id="profileForm" action="<?php echo base_url(); ?>city" method="post" enctype="multipart/form-data"> 
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text" name='update_name' id="update_name" class="form-control" autocomplete="off" required>                             
                                        <input type="hidden" value="" name='city_id' id="city_id">
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

        <?php base_url() . include 'footer.php'; ?>  
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
            window.actionEvents = {
                'click .edit-data': function (e, value, row, index) {
//                    alert('You click remove icon, row: ' + JSON.stringify(row));
                    var id = $(this).data("id");
                    $('#city_id').val(id);
                    $('#update_name').val(row.name);                  
                }
            };
        </script>
        <script>
            $(document).on('click', '.delete-data', function () {
                if (confirm('Are you sure? Want to delete city?')) {
                    var base_url = "<?php echo base_url(); ?>";
                    id = $(this).data("id");
                    image = $(this).data("image");
                    $.ajax({
                        url: base_url + 'Dashboard/delete_city',
                        type: "POST",
                        data: 'id=' + id + '&image_url=' + image,
                        success: function (result) {                           
                            if (result) {
                                $('#delete_msg').html(result);
				$('#delete_msg').show().delay(4000).fadeOut();
                                $('#city_list').bootstrapTable('refresh');
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