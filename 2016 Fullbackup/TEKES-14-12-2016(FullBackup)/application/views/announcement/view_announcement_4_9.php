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
}
?>

<div class="modal-body">    
    <!-- View Announcement Table Design Start-->
    <div class="row">     
        <div class="body">      
            <div class="col-sm-12">
                <h4 class="modal-title"><b><?php echo $edit_announcement_title; ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php echo $edit_announcement_date; ?></b></h4><br>
                <p class="modal-title"><?php echo $edit_announcement_message; ?></p><br>                
            </div>
        </div>
    </div>       
    <!-- View Announcement Table Design End-->
</div>

<div class="modal-footer">    
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

