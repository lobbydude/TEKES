<?php


$insert_data = array(
    'Department_Id' => 1,
    'Test_Name' => 'test11',
    'Enable_Date' => '2016-10-29',
    'Duration_Time' => '01:20:00',
    'Inserted_By' => 56,
    'Inserted_Date' => date('Y-m-d H:i:s'),
    'Status' => 1
);
$q = $this->db->insert('tbl_kpmaster', $insert_data);
