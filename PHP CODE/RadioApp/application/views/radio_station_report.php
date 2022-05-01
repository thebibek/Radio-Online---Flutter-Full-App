<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Report | <?php echo SITE_NAME; ?></title>        
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
                                        <h2 id="mydesc">View Radio Station Reported by User</h2>                                
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-1">
                                            <p id="delete_msg" style="display:none;" class="alert alert-success"></p>
                                         </div>

                                        <table aria-describedby="mydesc"  class='table-striped' id='categoty_list'
                                               data-toggle="table"
                                               data-url="<?php echo base_url() . 'Table/report' ?>"
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
                                                    <th scope="col" data-field="name" data-sortable="true">Radio Station</th>
                                                    <th scope="col" data-field="message" data-sortable="true">Message</th>
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

<!--            </div>
        </div>-->

        <?php base_url() . include 'footer.php'; ?>  

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
            $(document).on('click', '.delete-data', function () {
                if (confirm('Are you sure? Want to delete Report?')) {
                    var base_url="<?php echo base_url();?>";
                    id = $(this).data("id");
//                    image = $(this).data("image");
                    $.ajax({
                        url: base_url + 'Dashboard/delete_report',
                        type: "POST",
                        data: 'id=' + id ,
                        success: function (result) {
                            if (result) {
                                $('#delete_msg').html(result);
				$('#delete_msg').show().delay(4000).fadeOut();
                                $('#categoty_list').bootstrapTable('refresh');
                            }
                        },
                        error: function (result) {
                             alert("Error "+result);
                        }
                    });
                }
            });
        </script>
    </body>
</html>