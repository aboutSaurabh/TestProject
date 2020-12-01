<?php
$Id = !empty($_GET["id"]) ? $_GET["id"] : '';
?>
<?php $this->load->view("header"); ?>
<div class="container">
    <main class="main_content users_list_contents" role="main">

        <div class="col-sm-12">
            <div class="form_outer">
                <form class="form custom_form" action="<?php echo base_url("/uploadfile"); ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="form_header d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <h4 class="form_heading">Uploaded File Details</h4>

                    </div>
                    <div class="text-right ml-3">
                        <a class="btn btn_common btn-danger" href="<?php echo base_url('/logout'); ?>">Logout</a>

                    </div>
                    <hr>
                    <?php print_flash_message(); ?>
                    <div class="form_content">
                        <div class="row justify-content-center">
                            <div class="col-sm-6 form-group">
                                
                                <div class="img_input_cont">
                                    <span class="img_icon">

                                    </span>
                                    
                                </div>
                                
                            </div>
                          
                           
                        </div>
                    </div>
                </form>        </div>
            <div class="filter_section">
                <div class="table_caption mb-4">

                    <div class="row no-gutters align-items-center justify-content-between">
                        <a class="btn btn_common btn-secondary" href="<?php echo base_url("downloadExcel?id=" . $Id); ?>">Download Data</a>
                    </div>

                </div>
            </div>
             <div class="text-right ml-3">
                        <a class="btn btn_common btn-info" href="<?php echo base_url('/dashboard'); ?>">Back</a>

                    </div>
            <div class="records_section">

                <div class="table_cont">

                    <table class="table">
                        <thead class="thead-default">
                            <tr>
                                <th>Name</th>
                                <th>description</th>
                                <th>Uploaded On</th>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($records): ?>
                                <?php
                                //echo '<pre>'; print_r($number_of_record); echo "</pre>";
                                foreach ($records as $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $value->name; ?></td>
                                        <td><?php echo $value->description; ?></td>
                                        <td><?php echo $value->created_on; ?></td>
                                        <td><?php echo print_status($value->status); ?></td>
                                    </tr>
                                    <?php
                                }
                            else:
                                ?>
                                <tr><td colspan=7 class="text-center">Record Not found </td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="pagination_section mt-4">
                        <div class="row">
                            <?php if ($records): ?>
                                <div class="col-auto ml-3">
                                    <p class="pagination_heading"><?php echo!empty($result_summary) ? $result_summary : ''; ?></p>
                                    <?php echo $this->pagination->create_links(); ?>   
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php $this->load->view("footer"); ?>