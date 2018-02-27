<?php
// Edit form put details query 
$this->db->where('A_Id', $A_Id);
$q = $this->db->get('tbl_announcement');
foreach ($q->result() as $row) {   
    $edit_announcement_title = $row->Title;
    $edit_announcement_date1 = $row->Date;    
    //Date format converted Y-m-D to D-m-Y converted
    $edit_announcement_date = date("d-m-Y", strtotime($edit_announcement_date1));    
    $edit_announcement_message = $row->Message;
    $announcement_edit_file = $row->File;
}
?>

<div class="modal-body">    
    <!-- View Announcement Table Design Start-->
          
    <!-- View Announcement Table Design End-->
    
    <!-- Another code-->
    <div class="row">
        <div class="panel panel-primary">
					
            <table class="table table-bordered">
		<thead>
                    <tr>
                        <th width="30%"><b><?php echo $edit_announcement_title; ?></b></th>
                        <th><b><?php echo $edit_announcement_date; ?></b></th>
                    </tr>
		</thead>
						
                <tbody>
                    <tr>
			<td><p><?php
                    $ext = pathinfo($announcement_edit_file, PATHINFO_EXTENSION);
                    if ($ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'JPG') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" width="235" height="150">                        
                        </a>
                        <?php
                    } elseif ($ext == 'xlsx' || $ext == 'xls' || $ext == 'xlsm' || $ext == 'csv') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('images/excel.png')?>">                        
                        </a>                     
                        <?php
                    } elseif ($ext == 'ppt') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('images/ppt.png')?>">                        
                        </a>
                        <?php
                    } 
                     elseif ($ext == 'pdf') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('images/pdf.png')?>">                        
                        </a>
                        <?php
                    } 
                    elseif ($ext == 'doc' || $ext == 'docx') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('images/word.png')?>">                        
                        </a>                                       
                    <?php } ?></p></td>
			<td>
                            <pre><?php echo $edit_announcement_message; ?></pre>
							<?php //echo $edit_announcement_message; ?>
                            
			</td>
                    </tr>						
                					
		</tbody>
            </table>
        </div>
    </div>
        <!-- Another Code End-->
    
    
    
    
    
</div>

<div class="modal-footer">    
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

