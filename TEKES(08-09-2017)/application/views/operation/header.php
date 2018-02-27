<?php
$this->db->where('id', 1);
$q_empcode = $this->db->get('tbl_emp_code');
foreach ($q_empcode->result() as $row_empcode) {
    $emp_code = $row_empcode->employee_code;
    $start_number = $row_empcode->employee_number;
}

$user_id = $this->session->userdata('username');
$user_role = $this->session->userdata('user_role');

$this->db->where('Employee_Id', $user_id);
$q_user = $this->db->get('tbl_user');
foreach ($q_user->result() as $row_user) {
    $password_updated = $row_user->Password_Updated;
}

//$password_updated = $this->session->userdata('password_updated');

$this->db->where('Emp_Number', $user_id);
$q = $this->db->get('tbl_employee');
foreach ($q->result() as $row) {
    $name = $row->Emp_FirstName;
    $name .= " " . $row->Emp_LastName;
    $name .= " " . $row->Emp_MiddleName;
}

$this->db->where('Reporting_To', $user_id);
$q_career = $this->db->get('tbl_employee_career');
$count_career = $q_career->num_rows();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="<?php echo site_url('images/drn_logo.png') ?>" type="image/png">
        <title><?php echo $title; ?> : Dashboard</title>
        <?php
        $this->load->view('common/head.php');
        ?>
    </head>
    <body class="page-body">
        <div class="page-container horizontal-menu">
            <header class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="navbar-brand">
                        <a href="<?php echo site_url('Operation') ?>">
                            <img alt="" src="<?php echo site_url('images/logo@2x.png') ?>">
                        </a>
                    </div>

                    <!-- main menu -->

                    <ul class="navbar-nav">

                        <?php if ($user_role == 2 || $user_role == 6) { ?>
                            <li class="<?php
                            if ($this->uri->segment(1) == "Company" || $this->uri->segment(1) == "Shift" || $this->uri->segment(1) == "Announcement" || $this->uri->segment(2) == "Type" || $this->uri->segment(1) == "Allowance" || $this->uri->segment(1) == "RecMast") {
                                echo "active";
                            }
                            ?>">
                                <a href="<?php echo site_url('Company'); ?>">
                                    <i class="entypo-layout"></i>
                                    <span class="title">Organization</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="<?php echo site_url('Company'); ?>">
                                            <span class="title">Profile</span>
                                        </a>

                                        <ul>
                                            <li>
                                                <a href="<?php echo site_url('Company'); ?>">
                                                    <span class="title">Company</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Company/Branch'); ?>">
                                                    <span class="title">Branch</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Company/Department'); ?>">
                                                    <span class="title">Department</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Company/SubDepartment'); ?>">
                                                    <span class="title">Client & Sub Process</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Company/Designation'); ?>">
                                                    <span class="title">Designation & Role</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="title">Appraisal</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="<?php echo site_url('appraisal'); ?>">
                                                    <span class="title">Appraisal Form</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('appraisal/permission'); ?>">
                                                    <span class="title">Appraisal Review</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('appraisal/april'); ?>">
                                                    <span class="title">April Cycle</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('appraisal/october'); ?>">
                                                    <span class="title">October Cycle</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!--<li>
                                        <a href="<?php //echo site_url('Company/OrganizationNews');  ?>">
                                            <span class="title">Organization News</span>
                                        </a>
                                    </li>-->
                                    <li>
                                        <a href="<?php echo site_url('Announcement'); ?>">
                                            <span class="title">Announcements</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="title">Shift Details</span>
                                        </a>                                        
                                        <ul>
                                            <li>
                                                <a href="<?php echo site_url('Shift'); ?>">
                                                    <span class="title">Work Shift</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Shiftallocate'); ?>">
                                                    Employee Shift
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('Holidays'); ?>">
                                            <span class="title">Holidays</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?php echo site_url('Allowance?allowance_year=2017'); ?>">
                                            <span class="title">Allowances</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="title">Leaves</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="<?php echo site_url('Leaves/Type'); ?>">
                                                    <span class="title">Leave Type</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Leaves/Carryforward'); ?>">
                                                    <span class="title">Leave Carry Forward</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Leaves/Leavecompoff?compoff_year=2017'); ?>">
                                                    <span class="title">Comp Off</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
									<li>
                                        <a href="<?php echo site_url('Manpower'); ?>">
                                            <span class="title">Recruitment</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="<?php echo site_url('Manpower');  ?>">
                                                    <span class="title">Man Power Requisitions</span>
                                                </a>
                                            </li>                                                                                        
                                        </ul>
                                    </li>
									
                                    <li>
                                        <a href="<?php echo site_url('Report'); ?>">
                                            <span class="title">Reports</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($user_role == 4 || $user_role == 5 || $user_role == 7) { ?>
                            <li class="<?php
                            if ($this->uri->segment(1) == "Employee") {
                                echo "active";
                            }
                            ?>"><a href="<?php echo site_url('Employee'); ?>">
                                    <i class="entypo-users"></i>
                                    <span class="title">Employees</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($user_role == 1) { ?>
                            <li class="<?php
                            if ($this->uri->segment(1) == "Employee" || $this->uri->segment(2) == "Mode" || $this->uri->segment(1) == "Resignation" || $this->uri->segment(1) == "Salary" || $this->uri->segment(1) == "Termination" || $this->uri->segment(1) == "Attendance" || $this->uri->segment(1) == "Meetings" || (($this->uri->segment(1) == "Leaves") && ($this->uri->segment(2) == "Employee")) || (($this->uri->segment(1) == "Leaves") && ($this->uri->segment(2) == "Summary"))) {
                                echo "active";
                            }
                            ?>">
                                <a href="<?php echo site_url('Employee'); ?>">
                                    <i class="entypo-users"></i>
                                    <span class="title">Employees</span>
                                </a>
								
                                <ul>
                                    <li>
                                        <a href="<?php echo site_url('Employee'); ?>">
                                            <span class="title">Employees</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="title">Shift Details</span>
                                        </a>                                        
                                        <ul>
                                            <li>
                                                <a href="<?php echo site_url('Shift'); ?>">
                                                    <span class="title">Work Shifts</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Shiftallocate'); ?>">
                                                    <span class="title">Employee Shifts</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>	
									
									<?php if ($user_role == 1) { ?>
                                    <li>
                                        <a href="<?php echo site_url('Attendance'); ?>">
                                            <span class="title">Attendance</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="<?php echo site_url('Attendance/DailyStatus'); ?>">
                                                    <span class="title">Daily Status</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance'); ?>">
                                                    <span class="title">Daily Movements</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance/MonthAttendance'); ?>">
                                                    <span class="title">Monthly Attendance</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance/MonthTimesheet') ?>">
                                                    Muster Rolls
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
									<?php }?>
									
                                    <li>
                                        <a href="<?php echo site_url('Meetings'); ?>">
                                            <span class="title">Meetings</span>
                                        </a>
                                    </li>
                                    <?php
                                    if ($count_career > 0) {
                                        ?>
                                        <li>
                                            <a href="<?php echo site_url('Leaves/Employee'); ?>">
                                                <span class="title">Leaves</span>
                                            </a>
                                            <ul>
                                                <li>
                                                    <a href="<?php echo site_url('Leaves/CompOff') ?>">
                                                        Comp Off
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('Leaves/Employee') ?>">
                                                        Detailed Leave
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('Leaves/Summary') ?>">
                                                        Leave Summary
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li>
                                        <a href="<?php echo site_url('Resignation/Employee') ?>">
                                            <span class="title">Resignation</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?php echo site_url('Termination') ?>">
                                            <span class="title">Termination</span>
                                        </a>
                                    </li>
                                </ul>								
								
                            </li>
							<li>
                                        <a href="<?php echo site_url('Ipr1'); ?>">
										<i class="entypo-vcard"></i>
                                            <span class="title">IPR</span>
                                        </a>
                                        <ul>
											<li>
                                                <a data-toggle='modal' href='#import_ipr'>
                                                    <span class="title">Import IPR Data</span>
                                                </a>
                                            </li>
											<li>
                                                <a href="<?php echo site_url('Ipr1'); ?>">
                                                    <span class="title">IPR Employee Report</span>
                                                </a>
                                            </li>
											<li>
                                                <a href="<?php echo site_url('Ipr1/Iprdashboard') ?>">
                                                    IPR Dashboard 
                                                </a>
                                            </li>																					
											<li>
                                                <a href="<?php echo site_url('Ipr'); ?>">
                                                    <span class="title">Knowledge Process </span>
                                                </a>
                                            </li>										
											<li>
                                                <a href="<?php echo site_url('Punctuality'); ?>">
                                                    <span class="title">Punctuality</span>
                                                </a>
                                            </li>
											
                                                                                        
                                        </ul>
                                    </li>
									
									<li>
                                        <a href="<?php echo site_url('Manpower'); ?>">
											<i class="entypo-users"></i>
                                            <span class="title">Recruitment</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="<?php echo site_url('Manpower');  ?>">
                                                    <span class="title">Man Power Requisitions</span>
                                                </a>
                                            </li>                                                                                       
                                        </ul>
                                    </li>		
									
							
							
                        <?php } ?>

                        <?php if ($user_role == 2) { ?>
                            <li class="<?php
                            if ($this->uri->segment(1) == "Employee" || $this->uri->segment(2) == "Mode" || $this->uri->segment(1) == "Suggestion" || $this->uri->segment(1) == "Resignation" || $this->uri->segment(1) == "Salary" || $this->uri->segment(1) == "Payslip" || $this->uri->segment(1) == "Termination" || $this->uri->segment(1) == "Attendance" || $this->uri->segment(1) == "Meetings" || (($this->uri->segment(1) == "Leaves") && ($this->uri->segment(2) == "Employee")) || (($this->uri->segment(1) == "Leaves") && ($this->uri->segment(2) == "Summary"))) {
                                echo "active";
                            }
                            ?>">
                                <a href="<?php echo site_url('Employee'); ?>">
                                    <i class="entypo-users"></i>
                                    <span class="title">Employees</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="<?php echo site_url('Employee'); ?>">
                                            <span class="title">Employees</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('Attendance'); ?>">
                                            <span class="title">Attendance</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a data-toggle='modal' href='#import_attendance'>
                                                    Import Attendance
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance/DailyStatus'); ?>">
                                                    <span class="title">Daily Status</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance'); ?>">
                                                    <span class="title">Daily Movements</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance/MonthAttendance'); ?>">
                                                    <span class="title">Monthly Attendance</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance/MonthTimesheet') ?>">
                                                    Muster Rolls
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('import_ipr'); ?>">
                                            <span class="title">IPR</span>
                                        </a>
                                        <ul>
											<li>
                                                <a data-toggle='modal' href='#import_ipr'>
                                                    <span class="title">Import IPR Data</span>
                                                </a>
                                            </li>
											<li>
                                                <a href="<?php echo site_url('Ipr1') ?>">
                                                    IPR Report 
                                                </a>
                                            </li>
											<li>
                                                <a href="<?php echo site_url('Ipr1/Iprdashboard') ?>">
                                                    IPR Dashboard 
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Ipr') ?>">
                                                    Knowledge Process
                                                </a>
                                            </li>									
											<li>
                                                <a href="<?php echo site_url('Punctuality') ?>">
                                                    Punctuality
                                                </a>
                                            </li>
											<!--<li>
                                                <a href="<?php //echo site_url('Ipr/Employee') ?>">
                                                    IPR Design I
                                                </a>
                                            </li>-->
											
											
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('Meetings'); ?>">
                                            <span class="title">Meetings</span>
                                        </a>
                                    </li>
                                    <?php
                                    if ($count_career > 0 || $user_role == 2) {
                                        ?>
                                        <li>
                                            <a href="<?php echo site_url('Leaves/Employee'); ?>">
                                                <span class="title">Leaves</span>
                                            </a>
                                            <ul>
                                                <li>
                                                    <a href="<?php echo site_url('Leaves/CompOff') ?>">
                                                        Comp Off
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('Leaves/Employee') ?>">
                                                        Detailed Leave
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('Leaves/Summary') ?>">
                                                        Leave Summary
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li>
                                        <a href="<?php echo site_url('Resignation/Employee') ?>">
                                            <span class="title">Resignation</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?php echo site_url('Termination') ?>">
                                            <span class="title">Termination</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <span class="title">Payroll</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a data-toggle='modal' href='#import_payroll'>
                                                    <span class="title">Import</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle='modal' href='#export_payroll'>
                                                    <span class="title">Export</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Payslip') ?>">
                                                    <span class="title">Monthly Statement</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Payslip/Arrear') ?>">
                                                    <span class="title">Arrear Statement</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('Suggestion/Employee') ?>">
                                            <span class="title">Suggestion</span>
                                        </a>
                                    </li>
                                    <!--<li>
                                        <a href="<?php //echo site_url('Employee/Letters');  ?>">
                                            <span class="title">Letters</span>
                                        </a>
                                    </li>-->
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($user_role == 6) { ?>
                            <li class="<?php
                            if ($this->uri->segment(1) == "Employee" || $this->uri->segment(2) == "Mode" || $this->uri->segment(1) == "Suggestion" || $this->uri->segment(1) == "Resignation" || $this->uri->segment(1) == "Salary" || $this->uri->segment(1) == "Termination" || $this->uri->segment(1) == "Attendance" || $this->uri->segment(1) == "Meetings" || (($this->uri->segment(1) == "Leaves") && ($this->uri->segment(2) == "Employee")) || (($this->uri->segment(1) == "Leaves") && ($this->uri->segment(2) == "Summary"))) {
                                echo "active";
                            }
                            ?>">
                                <a href="<?php echo site_url('Employee'); ?>">
                                    <i class="entypo-users"></i>
                                    <span class="title">Employees</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="<?php echo site_url('Employee'); ?>">
                                            <span class="title">Employees</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('Attendance'); ?>">
                                            <span class="title">Attendance</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a data-toggle='modal' href='#import_attendance'>
                                                    Import Attendance
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance/DailyStatus'); ?>">
                                                    <span class="title">Daily Status</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance'); ?>">
                                                    <span class="title">Daily Movements</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance/MonthAttendance'); ?>">
                                                    <span class="title">Monthly Attendance</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Attendance/MonthTimesheet') ?>">
                                                    Muster Rolls
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('import_ipr'); ?>">
                                            <span class="title">IPR</span>
                                        </a>
                                        <ul>
											<li>
                                                <a data-toggle='modal' href='#import_ipr'>
                                                    <span class="title">Import IPR Data</span>
                                                </a>
                                            </li>                                           
											<li>
                                                <a href="<?php echo site_url('Punctuality') ?>">
                                                    Punctuality
                                                </a>
                                            </li>
											 <li>
                                                <a href="<?php echo site_url('Ipr') ?>">
                                                    Knowledge Process
                                                </a>
                                            </li>
											<!--<li>
                                                <a href="<?php //echo site_url('Ipr/Question') ?>">
                                                    Question
                                                </a>
                                            </li>-->
                                            
											<!--<li>
                                                <a href="<?php //echo site_url('Ipr/Employee') ?>">
                                                    IPR Design I
                                                </a>
                                            </li>
											<li>
                                                <a href="<?php //echo site_url('Ipr1') ?>">
                                                    IPR Design
                                                </a>
                                            </li>-->
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('Meetings'); ?>">
                                            <span class="title">Meetings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('Leaves/Employee'); ?>">
                                            <span class="title">Leaves</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="<?php echo site_url('Leaves/CompOff') ?>">
                                                    Comp Off
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Leaves/Employee') ?>">
                                                    Detailed Leave - My Teams
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Leaves/AllEmployee') ?>">
                                                    Detailed Leave - All Employees
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Leaves/Summary') ?>">
                                                    Leave Summary
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('Resignation/Employee') ?>">
                                            <span class="title">Resignation</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?php echo site_url('Termination') ?>">
                                            <span class="title">Termination</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <span class="title">Payroll</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a data-toggle='modal' href='#import_payroll'>
                                                    <span class="title">Import</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle='modal' href='#export_payroll'>
                                                    <span class="title">Export</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Payslip') ?>">
                                                    <span class="title">Monthly Statement</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Payslip/Arrear')?>">
                                                    <span class="title">Arrear Statement</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('Suggestion/Employee') ?>">
                                            <span class="title">Suggestion</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ($user_role == 2 || $user_role == 6) { ?>
                            <li class="<?php
                            if ($this->uri->segment(1) == "User") {
                                echo "active";
                            }
                            ?>">
                                <a href="<?php echo site_url('User'); ?>">
                                    <i class="entypo-users"></i>
                                    <span class="title">Users</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="<?php echo site_url('User'); ?>">
                                            <span class="title">Users</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('User/Userrole'); ?>">
                                            <span class="title">User Role</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('User/ResetPwd') ?>">
                                            <span class="title">Reset Password</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" onclick="jQuery('#emp_setup').modal('show', {backdrop: 'static'});">
                                    <i class="entypo-tools"></i>
                                    <span class="title">Employee Code</span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>

                    <!-- notifications and other links -->
                    <ul class="nav navbar-right pull-right">
                        <li>
                            <a href="<?php echo site_url('Profile'); ?> ">
                                Personal Dashboard 
                            </a>
                        </li>
                        <li class="sep"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $name; ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a data-toggle='modal' href='#change_password'>Change Password</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo site_url('Profile/Logout');?>">
                                Log Out <i class="entypo-logout right"></i>
                            </a>
                        </li>

                        <!-- mobile only -->
                        <li class="visible-xs">	
                            <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                            <div class="horizontal-mobile-menu visible-xs">
                                <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                                    <i class="entypo-menu"></i>
                                </a>
                            </div>

                        </li>

                    </ul>

                </div>

            </header>


            <div class="modal fade" id="emp_setup">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header info-bar">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Employee Code Setup</h3>
                        </div>
                        <form role="form" id="empcode_form" name="empcode_form" method="post" class="validate">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="empcode_server_error" class="alert alert-info" style="display:none;"></div>
                                        <div id="empcode_success" class="alert alert-success" style="display:none;">Employee Code updated successfully.</div>
                                        <div id="empcode_error" class="alert alert-danger" style="display:none;">Failed to update employee code.</div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">Employee Code</label>
                                            <input type="text" name="emp_code" id="emp_code" class="form-control" placeholder="Employee Code" data-validate="required" data-message-required="Please enter emp code." value="<?php echo $emp_code; ?>">
                                        </div>	
                                    </div>

                                    <input type="hidden" name="hidden_emp_code" id="hidden_emp_code" class="form-control" value="<?php echo $emp_code; ?>">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-2" class="control-label">Starting Format</label>
                                            <input type="text" name="starting_format" id="starting_format" class="form-control" placeholder="Starting format" data-validate="required" data-message-required="Please enter starting format." data-mask="9999" value="<?php echo $start_number; ?>" disabled="disabled">
                                        </div>	
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    $('#empcode_form').submit(function (e) {
                        e.preventDefault();
                        var formdata = {
                            emp_code: $('#emp_code').val(),
                            hidden_emp_code: $('hidden_emp_code').val(),
                            starting_format: $('#starting_format').val()
                        };
                        $.ajax({
                            url: "<?php echo site_url('Employee/empcode_setup') ?>",
                            type: 'post',
                            data: formdata,
                            success: function (msg) {
                                if (msg == 'fail') {
                                    $('#empcode_error').show();
                                }
                                if (msg == 'success') {
                                    $('#empcode_success').show();
                                    window.location.reload();
                                }
                                else if (msg != 'fail' && msg != 'success') {
                                    $('#empcode_server_error').html(msg);
                                    $('#empcode_server_error').show();
                                }
                            }

                        });
                    });
                });

            </script>

            <div class="modal fade" id="change_password">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header info-bar">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Change Password</h3>
                        </div>
                        <form role="form" id="changepassword_form" name="changepassword_form" method="post" class="validate">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="changepassword_server_error" class="alert alert-info" style="display:none;"></div>
                                        <div id="changepassword_success" class="alert alert-success" style="display:none;">Password changed successfully.</div>
                                        <div id="changepassword_error" class="alert alert-danger" style="display:none;">Failed to change password.</div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-2" class="control-label">Current Password</label>
                                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" data-validate="required" data-message-required="Please enter current password.">
                                        </div>	
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">New Password </label>
                                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" data-validate="required" data-message-required="Please enter new password.">
                                        </div>	
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="password_update" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header info-bar">
                            <h3 class="modal-title">Change Password</h3>
                        </div>
                        <form role="form" id="password_update_form" name="password_update_form" method="post" class="validate">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="changepwd_server_error" class="alert alert-info" style="display:none;"></div>
                                        <div id="changepwd_invalid" class="alert alert-info" style="display:none;">Current Password is wrong.</div>
                                        <div id="changepwd_success" class="alert alert-success" style="display:none;">Password changed successfully.</div>
                                        <div id="changepwd_error" class="alert alert-danger" style="display:none;">Failed to change password.</div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-2" class="control-label">Current Password</label>
                                            <input type="password" name="curr_password" id="curr_password" class="form-control" placeholder="Current Password" data-validate="required" data-message-required="Please enter current password.">
                                        </div>	
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">New Password </label>
                                            <input type="password" name="ne_password" id="ne_password" class="form-control" placeholder="New Password" data-validate="required" data-message-required="Please enter new password.">
                                        </div>	
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    $('#changepassword_form').submit(function (e) {
                        e.preventDefault();
                        var formdata = {
                            current_password: $('#current_password').val(),
                            new_password: $('#new_password').val()
                        };
                        $.ajax({
                            url: "<?php echo site_url('Profile/change_password') ?>",
                            type: 'post',
                            data: formdata,
                            success: function (msg) {
                                if (msg == 'fail') {
                                    $('#changepassword_error').show();
                                }
                                if (msg == 'success') {
                                    $('#changepassword_success').show();
                                    window.location.reload();
                                }
                                if (msg == 'invalid') {
                                    $('#changepassword_invalid').show();
                                }

                            }

                        });
                    });

                    $('#password_update_form').submit(function (e) {
                        e.preventDefault();
                        var formdata = {
                            current_password: $('#curr_password').val(),
                            new_password: $('#ne_password').val()
                        };
                        $.ajax({
                            url: "<?php echo site_url('Profile/change_password') ?>",
                            type: 'post',
                            data: formdata,
                            success: function (msg) {
                                if (msg == 'fail') {
                                    $('#changepwd_error').show();
                                }
                                if (msg == 'success') {
                                    $('#changepwd_success').show();
                                    window.location.reload();
                                }
                                if (msg == 'invalid') {
                                    $('#changepwd_invalid').show();
                                }

                            }

                        });
                    });

                });

            </script>

            <?php
            if ($password_updated == "No") {
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#password_update').modal('show', {backdrop: 'static'});
                    });
                </script>

            <?php } ?>

            <!-- Import Attendance Start Here -->

            <div class="modal fade" id="import_attendance" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content" id="import_div">
                        <div class="modal-header info-bar">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Import Attendance</h3>
                        </div>
                        <form role="form" id="importattendance_form" name="importattendance_form" method="post" class="validate" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="importattendance_server_error" class="alert alert-info" style="display:none;"></div>
                                        <div id="importattendance_success" class="alert alert-success" style="display:none;">Data imported successfully.</div>
                                        <div id="importattendance_error" class="alert alert-danger" style="display:none;">Failed to data import.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">File Upload</label>
                                        </div>	
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="file" name="import_file" id="import_file" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" data-message-required="Please select file.">
                                        </div>	
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="Import">Import</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- Import Attendance End Here -->

            <script type="text/javascript">
                $(document).ready(function (e) {
                    $("#importattendance_form").on('submit', (function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: "<?php echo site_url('Attendance/import_attendance') ?>",
                            type: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data)
                            {
                                if (data == "fail") {
                                    $('#importattendance_error').show();
                                }

                                if (data == "success") {
                                    $('#importattendance_success').show();
                                    window.location.reload();
                                }
                            },
                            error: function ()
                            {

                            }
                        });
                    }));
                });

            </script>

            <!-- Import Payroll Start Here -->

            <div class="modal fade" id="import_payroll" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header info-bar">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Import</h3>
                        </div>
                        <form role="form" id="importpayroll_form" name="importpayroll_form" method="post" class="validate" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="importpayroll_server_error" class="alert alert-info" style="display:none;"></div>
                                        <div id="importpayroll_success" class="alert alert-success" style="display:none;">Data imported successfully.</div>
                                        <div id="importpayroll_error" class="alert alert-danger" style="display:none;">Failed to data import.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="import_payroll_type" id="import_payroll_type" class="round" data-validate="required" data-message-required="Please select type.">
                                                <option value="Monthly_Statement">Monthly Statement</option>
                                                <option value="Arrears_Statement">Arrears Statement</option>
                                                <option value="Salary_Structure">Salary Structure</option>
                                            </select>
                                        </div>	
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="file" name="import_payrollfile" id="import_payrollfile" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" data-message-required="Please select file.">
                                        </div>	
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="Import">Import</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Import Payroll End Here -->

            <script>
                $(document).ready(function (e) {
                    $("#importpayroll_form").on('submit', (function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: "<?php echo site_url('Salary/import_payroll') ?>",
                            type: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data)
                            {
                                if (data.trim() == "fail") {
                                    $('#importpayroll_success').hide();
                                    $('#importpayroll_error').show();
                                }

                                if (data.trim() == "success") {
                                    $('#importpayroll_error').hide();
                                    $('#importpayroll_success').show();
                                    window.location.reload();
                                }
                            },
                            error: function ()
                            {
                            }
                        });
                    }));
                });
            </script>

            <!-- Export Payroll Start Here -->

            <div class="modal fade" id="export_payroll" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header info-bar">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Export</h3>
                        </div>
                        <form role="form" id="exportpayroll_form" name="exportpayroll_form" method="post" class="validate" action="<?php echo site_url('Payslip/export_payroll') ?>">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="exportpayroll_error" class="alert alert-danger" style="display:none;">Failed to data export.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select name="export_payroll_type" id="export_payroll_type" class="round" data-validate="required" data-message-required="Please select type.">
                                                <option value="Monthly_Statement">Monthly Statement</option>
                                                <option value="Arrears_Statement">Arrears Statement</option>
                                            </select>
                                        </div>	
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            define('DOB_YEAR_START1', 2000);
                                            $current_year1 = date('Y');
                                            ?>
                                            <select id="export_payroll_year" name="export_payroll_year" class="round">
                                                <?php
                                                for ($count1 = $current_year1; $count1 >= DOB_YEAR_START1; $count1--) {
                                                    echo "<option value='{$count1}'>{$count1}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="round" id="export_payroll_month" name="export_payroll_month">
                                                <?php
                                                for ($m1 = 1; $m1 <= 12; $m1++) {
                                                    $current_month1 = date('m');
                                                    $month1 = date('F', mktime(0, 0, 0, $m1, 1, date('Y')));
                                                    ?>
                                                    <option value="<?php echo $m1; ?>" <?php
                                                    if ($current_month1 == $m1) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>><?php echo $month1; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Export</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Export Payroll End Here -->
			
		<!-- IPR Import Data Start here -->
        <div class="modal fade" id="import_ipr" data-backdrop="static">
            <div class="modal-dialog" style="width:65%;">
                    <div class="modal-content">
                        <div class="modal-header info-bar">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Import IPR Report</h3>
                        </div>
                        <form role="form" id="importipr_form" name="importipr_form" method="post" class="validate" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="importipr_server_error" class="alert alert-info" style="display:none;"></div>
                                        <div id="importipr_success" class="alert alert-success" style="display:none;">Data imported successfully.</div>
                                        <div id="importipr_error" class="alert alert-danger" style="display:none;">Failed to data import.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Select Year</label>                                       
                                        <select id="add_ipr_import_year" name="add_ipr_import_year" class="round">                                                                                      
                                            <option value="2016">2016</option> 
                                            <option value="2017">2017</option> 
                                            <option value="2018">2018</option> 
                                            <option value="2019">2019</option> 
                                            <option value="2020">2020</option>
                                        </select>
                                    </div>	
                                </div>
                                    <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Select Month</label>
                                        <select class="round" id="add_ipr_import_month" name="add_ipr_import_month">
                                            <?php
                                            for ($m = 1; $m <= 12; $m++) {
                                                $current_month = date('m');
                                                $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                ?>
                                                <option value="<?php echo $m; ?>" <?php if ($current_month == $m) {
                                                echo "selected=selected";
                                            } ?>><?php echo $month; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>	
                                </div>                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">Select File</label>
                                            <select name="import_ipr_type" id="import_ipr_type" class="round" data-validate="required" data-message-required="Please select type.">
                                                <option value="Effeciency_Statement">Effeciency Statement</option>
                                                <option value="Accuracy_Statement">Accuracy Statement</option>
                                                <option value="Process_Knowledge_Statement">Process Knowledge Statement</option>
                                                <option value="Teamwork_Statement">Teamwork Statement</option>
                                            </select>
                                        </div>	
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">File Upload</label>
                                            <input type="file" name="import_iprfile" id="import_iprfile" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" data-message-required="Please select file.">
                                        </div>	
                                    </div>                                    
                                </div>                                
                                <div class="row">                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">Import File Sample Format</label>
                                            <select id="dwl" class="round">
                                                <option value="Select document">Select Import Statement File</option>
                                                <option value="http://192.168.12.151:82/TEKES/ipr_import_file/Effeciency_Import_csv_update.csv">Effeciency Statement</option>
                                                <option value="http://192.168.12.151:82/TEKES/ipr_import_file/Accuracy_Import_csv_update.csv">Accuracy Statement</option>
                                                <option value="http://192.168.12.151:82/TEKES/ipr_import_file/Process_Knowledge_Import_csv_update.csv">Process Knowledge Statement</option>
                                                <option value="http://192.168.12.151:82/TEKES/ipr_import_file/Teamwork_Import_csv_update.csv">Teamwork Statement</option>      
                                            </select>                                            
                                        </div>	
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label" style="display:none;">Import File Dowland</label>
                                            <input type="button" onclick="window.location.href=document.getElementById('dwl').value" value="Download" class="btn btn-primary" style="margin-top:27px;" />
                                        </div>	
                                    </div>
                                </div>
                                
                                
                            </div>                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="Import">Import</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- IPR Import Data End here -->
		
            <script>
                $(document).ready(function (e) {
                    $("#importipr_form").on('submit', (function (e) {
                        e.preventDefault();
                        $.ajax({                            
                            url: "<?php echo site_url('Ipr1/import_ipr') ?>",
                            type: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data)
                            {    
                                alert(data);
                                if (data.trim() == "fail") {
                                    $('#importipr_success').hide();
                                    $('#importipr_error').show();
                                }
                                if (data.trim() == "success") {
                                    $('#importipr_error').hide();
                                    $('#importipr_success').show();
                                    window.location.reload();
                                }
                            },
                            error: function ()
                            {
                            }
                        });
                    }));
                });
            </script>
            <!-- IPR Import Data End here -->
			
			

