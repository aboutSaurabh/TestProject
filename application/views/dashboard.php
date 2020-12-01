<?php
$Id = !empty($_GET["id"])?$_GET["id"]:'';
?>
<?php $this->load->view("header"); ?>
<div class="container">
<main class="main_content users_list_contents" role="main">
    <div class="col-sm-12">
      
        <div class="filter_section">
            <?php //echo form_open($this->uri->uri_string(), array('method' => 'get')); ?>
          
                <div class="form_outer">
                    <form class="form custom_form" action="<?php echo base_url("/uploadfile"); ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        <div class="form_header d-flex flex-wrap align-items-center justify-content-between mb-4">
                            <h4 class="form_heading">Upload File</h4>
                          
                        </div>
                           <div class="text-right ml-3">
                                <a class="btn btn_common btn-danger" href="<?php echo base_url('/logout'); ?>">Logout</a>

                            </div>
                        <hr>
                          <?php print_flash_message(); ?>
                        <div class="form_content">
                            <div class="row justify-content-center">
                                <div class="col-sm-6 form-group">
                                    <label for="input-task-priority">Upload Excel <span class="required-item">*</span></label>
                                    <div class="img_input_cont">
                                        <span class="img_icon">
                                        
                                        </span>
                                        <label for="upload_excel" class="upload_label">Browse...</label>
                                        <input id="upload_excel" class="form-control input-task-title " accept=".xls,.csv" type="file" name="file" size="20" value="" required="">
                                    </div>
                                    <span class="error vlError"></span>
                                    <p class="upload_sm_text">Upload only formate (.xls,.csv) file. </p>
                                </div>
                                 <div class="text-right ml-3">
                                <a class="btn btn_common btn-secondary" href="<?php echo base_url('/assets/uploads/formate.csv'); ?>">Download Format</a>

                            </div>
                                <div class="col-sm-12 text-center">
                                    <input type="submit" name="save" class="btn btn-primary btn_submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>        </div>
           
            <?php //echo form_close(); ?>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="records_section">
            <div class="table_caption mb-4">
                
                    <div class="row no-gutters align-items-center justify-content-between">
                        <h3 class="caption_title">Uploaded File Details</h3>
                       
                    </div>
                <form name="filter" method="get" action="<?php echo base_url("dashboard");?>">
                     <div class="text-right ml-3">
                         <input type="text" name="title" required="" placeholder="please enter Batch Id" value="<?php echo !empty($_GET["title"])?$_GET["title"]:''; ?>" />
                <input type="submit" class="btn btn-primary" name="filter" value="filter"/>
                <?php if(!empty($_GET["title"])): ?>
                <a class="btn btn_common btn-secondary" href="<?php echo base_url('/dashboard'); ?>">reset</a>
                <?php endif; ?>
                </div>
                  
            </div>
            <div class="table_cont">
                <?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'id' => 'listing', 'method' => 'post')); ?>
                <table class="table">
                    <thead class="thead-default">
                        <tr>
                            <th>Date</th>
                            <th>Batch Id</th>
                            <th>File Name</th>
                            <td>No. of Records</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($records): ?>
                            <?php  //echo '<pre>'; print_r($number_of_record); echo "</pre>";
                            foreach ($records as $value) {
                                ?>
                                    <tr>
                                        <td><?php echo date('d M Y', strtotime($value->createdDate)); ?></td>
                                        <td><?php echo $value->batchId; ?></td>
                                        <td><?php echo $value->fileName; ?></td>
                                        <td><a title="click" href="<?php echo base_url("/view?id=".$value->id); ?>"><?php echo !empty($number_of_record[$value->id])?count($number_of_record[$value->id]):'0'; ?></a></td>
                                        <td class="status_<?php echo $value->id; ?>"><?php echo print_status($value->status); ?></td>
                                        <td><a title="click" href="<?php echo base_url("/view?id=".$value->id); ?>">View</a> | <a title="click" href="<?php echo base_url("downloadExcel?id=".$value->id); ?>">Dowland</a></td>
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
                        <?php if ($records): if (!empty($_GET['status']) && $_GET['status'] == '3') { ?>
                               
                            <?php } else { ?> 
                                
                            <?php } endif;
                        if ($records): ?>
                            <div class="col-auto ml-3">
                                <p class="pagination_heading"><?php echo!empty($result_summary) ? $result_summary : ''; ?></p>
                            <?php echo $this->pagination->create_links(); ?>   
                            </div>
<?php endif; ?>
                    </div>
                </div>
<?php echo form_close(); ?>
            </div>
        </div>
    </div>
</main>
</div>	
<?php $this->load->view("footer"); ?>