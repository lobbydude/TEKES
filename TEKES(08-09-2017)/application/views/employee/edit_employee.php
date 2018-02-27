<?php
$user_role = $this->session->userdata('user_role');
$current_user = $this->session->userdata('username');


if ($user_role == 3) {
    $emp_no = $this->session->userdata('username');
} if ($user_role == 2 || $user_role == 1 || $user_role == 6 || $user_role==4 || $user_role==5 || $user_role == 7) {
    if ($emp_no = $this->uri->segment(3) != "") {
        $emp_no = $this->uri->segment(3);
    } else {
        $emp_no = $this->session->userdata('username');
    }
}

$Emp_Mode = "";
$Emp_mode_comment = "";

$this->db->where('Emp_Number', $emp_no);
$q = $this->db->get('tbl_employee');
foreach ($q->result() as $row) {

    $this->db->where('employee_number', $emp_no);
    $q_code = $this->db->get('tbl_emp_code');
    foreach ($q_code->result() as $row_code) {
        $emp_code = $row_code->employee_code;
    }

    $first_name = $row->Emp_FirstName;
    $middle_name = $row->Emp_MiddleName;
    $last_name = $row->Emp_LastName;
    $birthdate = $row->Emp_Dob;
    $dob = date("d-m-Y", strtotime($birthdate));
    $actual_birthdate = $row->Emp_ActuallDob;
    $actual_dob = date("d-m-Y", strtotime($actual_birthdate));
    $gender = $row->Emp_Gender;
    $blood_group = $row->Emp_Bldgroup;
    $Emp_Mode = $row->Emp_Mode;
    $Emp_mode_comment = $row->Emp_Mode_Comment;

    $Emp_PANcard = "";
    $this->db->where('Employee_Id', $emp_no);
    $q_bank = $this->db->get('tbl_employee_bankdetails');
    foreach ($q_bank->result() as $row_bank) {
        $Emp_Bankname = $row_bank->Emp_Bankname;
        $Emp_Accno = $row_bank->Emp_Accno;
        $Emp_IFSCcode = $row_bank->Emp_IFSCcode;
        $Emp_PANcard = $row_bank->Emp_PANcard;
        $Emp_UANno = $row_bank->Emp_UANno;
        $Emp_PFno = $row_bank->Emp_PFno;
        $Emp_ESI = $row_bank->Emp_ESI;
        $Emp_Medicalinsurance = $row_bank->Emp_Medicalinsurance;
    }

    $this->db->order_by('Career_Id', 'desc');
    $this->db->where('Employee_Id', $emp_no);
    $this->db->limit(1);
    $q_career = $this->db->get('tbl_employee_career');
    foreach ($q_career->result() as $row_career) {
        $branch_id = $row_career->Branch_Id;
        $department_id = $row_career->Department_Id;
        $client_id = $row_career->Client_Id;
        $designation_id = $row_career->Designation_Id;
        $report_to_id = $row_career->Reporting_To;
    }


    $this->db->where('Designation_Id', $designation_id);
    $q_designation = $this->db->get('tbl_designation');
    foreach ($q_designation->result() as $row_designation) {
        $designation_name = $row_designation->Designation_Name;
        $emp_grade_id = $row_designation->Designation_Id;
        $grade_name = $row_designation->Grade;
        $dept_role_id = $row_designation->Designation_Id;
        $dept_role = $row_designation->Role;
        $subdepartment_id = $row_designation->Client_Id;

        $this->db->where('Subdepartment_Id', $subdepartment_id);
        $q_subdept = $this->db->get('tbl_subdepartment');
        foreach ($q_subdept->result() as $row_subdept) {
            $subdepartment_name = $row_subdept->Subdepartment_Name;
            $client_name = $row_subdept->Client_Name;
        }
    }
    $this->db->where('Department_Id', $department_id);
    $q_dept = $this->db->get('tbl_department');
    foreach ($q_dept->result() as $row_dept) {
        $department_name = $row_dept->Department_Name;
    }

    $this->db->where('Branch_ID', $branch_id);
    $q_branch = $this->db->get('tbl_branch');
    foreach ($q_branch->result() as $row_branch) {
        $branch_name = $row_branch->Branch_Name;
        $company_id = $row_branch->Company_Id;
    }

    $this->db->where('Company_Id', $company_id);
    $q_company = $this->db->get('tbl_company');
    foreach ($q_company->result() as $row_company) {
        $company_name = $row_company->Company_Name;
    }


    $this->db->where('Emp_Number', $report_to_id);
    $q_emp = $this->db->get('tbl_employee');
    foreach ($q_emp->result() as $row_emp) {
        $reporting_name = $row_emp->Emp_FirstName;
        $reporting_name .= " " . $row_emp->Emp_LastName;
        $reporting_name .= " " . $row_emp->Emp_MiddleName;
    }


    $doj = $row->Emp_Doj;
    $Emp_Doj = date("d-m-Y", strtotime($doj));

    $Emp_Confirmationperiod = $row->Emp_Confirmationperiod;
    $doc = $row->Emp_Confirmationdate;
    $Emp_Confirmationdate = date("d-m-Y", strtotime($doc));
    $Emp_Contact = $row->Emp_Contact;
    $Emp_AlternateContact = $row->Emp_AlternateContact;
    $Emp_Officialemail = $row->Emp_Officialemail;
}

$Emp_Nationality = "";
$Emp_Religion = "";
$Emp_Caste = "";
$Emp_Mother_Tongue = "";
$Emp_Marrial = "";
$Emp_PersonalEmail = "";
$Emp_Permanent = "";
$Emp_Temporary = "";


$this->db->where('Employee_Id', $emp_no);
$select_personal = $this->db->get('tbl_employee_personal');
$count_personal = $select_personal->num_rows();

if ($count_personal > 0) {
    foreach ($select_personal->result() as $row_personal) {
        $Emp_Nationality = $row_personal->Emp_Nationality;
        $Emp_Religion = $row_personal->Emp_Religion;
        $Emp_Caste = $row_personal->Emp_Caste;
        $Emp_Mother_Tongue = $row_personal->Emp_Mother_Tongue;
        $Emp_Marrial = $row_personal->Emp_Marrial;
        $Emp_PersonalEmail = $row_personal->Emp_PersonalEmail;
        $Emp_Permanent = $row_personal->Emp_Permanent;
        $Emp_Temporary = $row_personal->Emp_Temporary;
    }
}

$data_branch = array(
    'Branch_ID !=' => $branch_id,
    'Status' => 1
);
$this->db->where($data_branch);
$select_branch_exp = $this->db->get('tbl_branch');

$data_dept = array(
    'Branch_ID' => $branch_id,
    'Department_Id !=' => $department_id,
    'Status' => 1
);
$this->db->where($data_dept);
$select_dept_exp = $this->db->get('tbl_department');

$data_client = array(
    'Department_Id' => $department_id,
    'Subdepartment_Id !=' => $client_id,
    'Status' => 1
);
$this->db->where($data_client);
$select_client_exp = $this->db->get('tbl_subdepartment');

$data_subdept = array(
    'Department_Id' => $department_id,
    'Subdepartment_Id !=' => $subdepartment_id,
    'Status' => 1
);
$this->db->where($data_subdept);
$select_subdept_exp = $this->db->get('tbl_subdepartment');

$data_family = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($data_family);
$select_family = $this->db->get('tbl_employee_family');
$count_family = $select_family->num_rows();

$data_education = array(
    'Employee_ID' => $emp_no,
    'Status' => 1
);
$this->db->where($data_education);
$select_education = $this->db->get('tbl_employee_educationdetails');
$count_education = $select_education->num_rows();

$data_exp = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($data_exp);
$select_exp = $this->db->get('tbl_employee_expdetails');
$count_exp = $select_exp->num_rows();

$data_doc = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($data_doc);
$select_document = $this->db->get('tbl_employee_documents');
$count_document = $select_document->num_rows();

$data_skills = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($data_skills);
$select_skills = $this->db->get('tbl_employee_skills');
$count_skills = $select_skills->num_rows();

$Emp_Aadharcard = "";
$Emp_Passportno = "";
$Emp_Passportname = "";
$Issue_Place = "";
$Issue_Date = "";
$Expiry_Date = "";
$Valid_visa = "";
$Issue_Country = "";
$Hobbies = "";
$Intresets = "";
$related_emp = "";
$related_emp_id = "";
$voter_id = "";
//$Membership = "";
//$Suggesation = "";

$this->db->where('Employee_ID', $emp_no);
$select_info = $this->db->get('tbl_employee_additionalinformation');
$count_info = $select_info->num_rows();
if ($count_info > 0) {
    foreach ($select_info->result() as $row_info) {
        $Emp_Aadharcard = $row_info->Emp_Aadharcard;
        $Emp_Passportno = $row_info->Emp_Passportno;
        $Emp_Passportname = $row_info->Emp_Passportname;
        $Issue_Place = $row_info->Issue_Place;
        $Issue_Date1 = $row_info->Issue_Date;
        if ($Issue_Date1 == "0000-00-00") {
            $Issue_Date = "";
        } else {
            $Issue_Date = date("d-m-Y", strtotime($Issue_Date1));
        }
        $Expiry_Date1 = $row_info->Expiry_Date;
        if ($Expiry_Date1 == "0000-00-00") {
            $Expiry_Date = "";
        } else {
            $Expiry_Date = date("d-m-Y", strtotime($Expiry_Date1));
        }
        $Valid_visa = $row_info->Valid_visa;
        $Issue_Country = $row_info->Issue_Country;
        $Hobbies = $row_info->Hobbies;
        $Intresets = $row_info->Intresets;
        $related_emp = $row_info->Related_Employee;
        $related_emp_id = $row_info->Employee_Name;

        $this->db->where('Emp_Number', $related_emp_id);
        $q_rel_emp = $this->db->get('tbl_employee');
        foreach ($q_rel_emp->result() as $row_rel_emp) {
            $related_emp_name = $row_rel_emp->Emp_FirstName;
        }

        $voter_id = $row_info->Voter_Id;
        //$Membership = $row_info->Membership;
        //$Suggesation = $row_info->Suggesation;
    }
}

$Alergic = "";
$BloodPressure = "";
$Differently_abled = "";
$Weight = "";
$Height = "";
$Eye_Sight = "";
$Major_Illeness = "";
$Contact_Person = "";
$Mobileno = "";


$this->db->where('Employee_Id', $emp_no);
$select_emer = $this->db->get('tbl_employee_emergency_details');
$count_emer = $select_emer->num_rows();
if ($count_emer > 0) {
    foreach ($select_emer->result() as $row_emer) {
        $Alergic = $row_emer->Alergic;
        $BloodPressure = $row_emer->BloodPressure;
        $Differently_abled = $row_emer->Differently_abled;
        $Weight = $row_emer->Weight;
        $Height = $row_emer->Height;
        $Eye_Sight = $row_emer->Eye_Sight;
        $Major_Illeness = $row_emer->Major_Illeness;
        $Contact_Person = $row_emer->Contact_Person;
        $Mobileno = $row_emer->Mobileno;
    }
}

$bg_verify = "";
$this->db->where('Employee_Id', $emp_no);
$select_bg = $this->db->get('tbl_employee_bgverify');
$count_bg = $select_bg->num_rows();
if ($count_bg > 0) {
    foreach ($select_bg->result() as $row_bg) {
        $bg_verify = $row_bg->BG_Verify;
    }
}

$data_related_emp_exp = array(
    'Emp_Number !=' => $related_emp_id,
    'Status' => 1
);
$this->db->where($data_related_emp_exp);
$select_related_emp_exp = $this->db->get('tbl_employee');

$data_report = array(
    'Emp_Number !=' => $report_to_id,
    'Status' => 1
);
$this->db->where($data_report);
$select_report_exp = $this->db->get('tbl_employee');

$data_lang = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($data_lang);
$select_lang = $this->db->get('tbl_employee_language');
$count_lang = $select_lang->num_rows();

$data_ref_Exp = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($data_ref_Exp);
$select_ref = $this->db->get('tbl_employee_referencedetails');
$count_ref = $select_ref->num_rows();

$data_ref_fresher = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($data_ref_fresher);
$select_fresherref = $this->db->get('tbl_employee_fresherref');
$count_fresherref = $select_fresherref->num_rows();

$this->db->where('Status', 1);
$select_rel_emp = $this->db->get('tbl_employee');
?>

<script>

    function delete_lang_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Deletelang') ?>",
            data: "lang_id=" + id,
            cache: false,
            success: function (html) {
                $("#delete_lang_details_form").html(html);
            }
        });
    }

    function edit_family_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Editfamily') ?>",
            data: "family_id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_family_details_form").html(html);
            }
        });
    }

    function delete_family_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Deletefamily') ?>",
            data: "family_id=" + id,
            cache: false,
            success: function (html) {
                $("#delete_family_details_form").html(html);
            }
        });
    }

    function edit_edu_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Editeducation') ?>",
            data: "edu_id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_edu_details_form").html(html);
            }
        });
    }

    function delete_edu_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Deleteeducation') ?>",
            data: "edu_id=" + id,
            cache: false,
            success: function (html) {
                $("#delete_edu_details_form").html(html);
            }
        });
    }

    function edit_skills_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Editskills') ?>",
            data: "skills_id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_skills_details_form").html(html);
            }
        });
    }

    function delete_skills_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Deleteskills') ?>",
            data: "skills_id=" + id,
            cache: false,
            success: function (html) {
                $("#delete_skills_details_form").html(html);
            }
        });
    }

    function edit_exp_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Editexperience') ?>",
            data: "exp_id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_exp_details_form").html(html);
            }
        });
    }

    function delete_exp_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Deleteexperience') ?>",
            data: "exp_id=" + id,
            cache: false,
            success: function (html) {
                $("#delete_exp_details_form").html(html);
            }
        });
    }

    function edit_fresherref_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Editfresherref') ?>",
            data: "resherref_id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_fresherref_details_form").html(html);
            }
        });
    }

    function delete_fresherref_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Deletefresherref') ?>",
            data: "resherref_id=" + id,
            cache: false,
            success: function (html) {
                $("#delete_fresherref_details_form").html(html);
            }
        });
    }

    function edit_ref_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Editreference') ?>",
            data: "ref_id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_ref_details_form").html(html);
            }
        });
    }

    function delete_ref_details(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Deletereference') ?>",
            data: "ref_id=" + id,
            cache: false,
            success: function (html) {
                $("#delete_ref_details_form").html(html);
            }
        });
    }


    function getMonths(end_date, start_date) {
        var from = start_date.split("-").reverse().join("-");
        var to = end_date.split("-").reverse().join("-");
        var usrDate = new Date(from);
        var curDate = new Date(to);
        var usrYear, usrMonth = usrDate.getMonth() + 1;
        var curYear, curMonth = curDate.getMonth() + 1;
        if ((usrYear = usrDate.getFullYear()) < (curYear = curDate.getFullYear())) {
            curMonth += (curYear - usrYear) * 12;
        }
        var diffMonths = curMonth - usrMonth;
        if (usrDate.getDate() > curDate.getDate())
            diffMonths--;
        //alert("There are " + diffMonths + " months between " + usrDate + " and " + curDate);
        $("#no_of_month").val(diffMonths);
    }
</script>

<script>
    $(document).ready(function () {
        $('#aknowledgement_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#employee_id').val();
            var condition_agree;
            if (document.getElementById("condition_agree").checked) {
                $('#acknowledgment_error').hide();
                condition_agree = "Yes";
                var formdata = {
                    condition_agree: condition_agree,
                    employee_id: employee_id
                };
                $.ajax({
                    url: "<?php echo site_url('Employee/aknowledgement_details') ?>",
                    type: 'post',
                    data: formdata,
                    success: function (msg) {
                        if (msg == 'success') {
                            $('#acknowledgment_success').show();
                            window.location.reload();
                        }
                    }
                });
            } else {
                $('#acknowledgment_error').show();
            }


        });
    });</script>
<script>
    function showDepartment(sel) {
        var branch_id = sel.options[sel.selectedIndex].value;
        if (branch_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_department') ?>",
                data: "branch_id=" + branch_id,
                cache: false,
                success: function (html) {
                    $("#edit_emp_department").html(html);
                }
            });
        }
    }

    function showClient(sel) {
        var dept_id = sel.options[sel.selectedIndex].value;
        if (dept_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_client') ?>",
                data: "dept_id=" + dept_id,
                cache: false,
                success: function (html) {
                    $("#edit_emp_client").html(html);
                }
            });
        }
    }

    function showSubprocess(sel) {
        var client_id = sel.options[sel.selectedIndex].value;
        if (client_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_subprocess') ?>",
                data: "client_id=" + client_id,
                cache: false,
                success: function (html) {
                    $("#edit_emp_subprocess").html(html);
                }
            });
        }
    }

    function showDesignation(sel) {
        var dept_id = sel.options[sel.selectedIndex].value;
        if (dept_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_designation') ?>",
                data: "subdept_id=" + dept_id,
                cache: false,
                success: function (html) {
                    $("#edit_emp_designation").html(html);
                }
            });
        }
    }

    function showGrade(sel) {
        var dept_id = sel.options[sel.selectedIndex].value;
        if (dept_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_grade') ?>",
                data: "designation_id=" + dept_id,
                cache: false,
                success: function (html) {
                    $("#edit_emp_grade").html(html);
                }
            });
        }
    }

    function showDepartmentRole(sel) {
        var dept_id = sel.options[sel.selectedIndex].value;
        if (dept_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_departmentrole') ?>",
                data: "grade_id=" + dept_id,
                cache: false,
                success: function (html) {
                    $("#edit_emp_departmentrole").html(html);
                }
            });
        }
    }

</script>

<script>
    function show_employee(emp_status) {
        //alert(emp_status);
        if (emp_status == "Yes") {
            $('#related_emp_name_div').show();
        } else {
            $('#related_emp_name_div').hide();
        }
    }

    function getAge(DOB) {
        var d = new Date();
        var bits = DOB.split('-')
        d.setHours(0, 0, 0, 0); //normalise
        d.setFullYear(bits[2])
        d.setMonth(bits[1] - 1)
        d.setDate(bits[0])
        var now = new Date();
        now.setHours(0, 0, 0, 0); //normalise
        var years = now.getFullYear() - d.getFullYear();
        d.setFullYear(now.getFullYear())
        var diff = now.getTime() - d.getTime()
        if (diff < 0)
            years--;
        document.getElementById('family_member_age').value = years;
    }

 function getEmpAge(DOB) {
        var d = new Date();
        var bits = DOB.split('-')
        d.setHours(0, 0, 0, 0); //normalise
        d.setFullYear(bits[2])
        d.setMonth(bits[1] - 1)
        d.setDate(bits[0])
        var now = new Date();
        now.setHours(0, 0, 0, 0); //normalise
        var years = now.getFullYear() - d.getFullYear();
        d.setFullYear(now.getFullYear())
        var diff = now.getTime() - d.getTime()
        if (diff < 0)
            years--;
        document.getElementById('emp_age').value = years;
    }

    function showperiod() {
        $('#period').show();
        var join_date = $('#joining_date').val();
        var period;
        if (document.getElementById("6months").checked) {
            period = document.getElementById("6months").value;
        } else {
            period = document.getElementById("3months").value;
        }
        var from = join_date.split("-");
        var start_date = new Date(from[2], from[1] - 1, from[0]);
        if (period == 3) {
            var threeMonths = new Date(start_date.getTime() + (91 * 24 * 60 * 60 * 1000));
            var day = threeMonths.getDate();
            var month = threeMonths.getMonth() + 1;
            var year = threeMonths.getFullYear();
            document.getElementById('confirmation_date').value = day + "-" + month + "-" + year;
        } else {
            var sixMonths = new Date(start_date.getTime() + (182 * 24 * 60 * 60 * 1000));
            var day = sixMonths.getDate();
            var month = sixMonths.getMonth() + 1;
            var year = sixMonths.getFullYear();
            document.getElementById('confirmation_date').value = day + "-" + month + "-" + year;
        }
    }
    function showconfirmationdate(period, join_date) {
        var from = join_date.split("-");
        var start_date = new Date(from[2], from[1] - 1, from[0]);
        if (period == 3) {
            var threeMonths = new Date(start_date.getTime() + (91 * 24 * 60 * 60 * 1000));
            var day = threeMonths.getDate();
            var month = threeMonths.getMonth() + 1;
            var year = threeMonths.getFullYear();
            document.getElementById('confirmation_date').value = day + "-" + month + "-" + year;
        } else {
            var sixMonths = new Date(start_date.getTime() + (182 * 24 * 60 * 60 * 1000));
            var day = sixMonths.getDate();
            var month = sixMonths.getMonth() + 1;
            var year = sixMonths.getFullYear();
            document.getElementById('confirmation_date').value = day + "-" + month + "-" + year;
        }
    }

   
	
	function showpermanentaddress(permanent) {
        if (document.getElementById('same_address').checked) {
            document.getElementById('edit_temporary_address').value = permanent;
        } else {
            document.getElementById('edit_temporary_address').value = "";
        }
    }


</script>


<script>
    $(document).ready(function () {

        $('#editemployeebasic_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#employee_id').val();
            var first_name = $('#first_name').val();
            var middle_name = $('#middle_name').val();
            var last_name = $('#last_name').val();
            var gender;
            if (document.getElementById("male").checked) {
                gender = document.getElementById("male").value;
            } else {
                gender = document.getElementById("female").value;
            }
            var birthdate = $('#birthdate').val();
            var actual_birthdate = $('#actual_birthdate').val();
            var blood_group = $('#blood_group').val();
            var mobile_number = $('#mobile_number').val();
            var alternate_number = $('#alternate_number').val();
            var official_email_address = $('#official_email_address').val();
            var bank_name = $('#bank_name').val();
            var acc_no = $('#acc_no').val();
            var ifsc_code = $('#ifsc_code').val();
            var pan_no = $('#pan_no').val();
            var uan_no = $('#uan_no').val();
            var pf_no = $('#pf_no').val();
            var esi = $('#esi').val();
            var medical_insurance = $('#medical_insurance').val();
            var company_name = $('#edit_emp_company').val();
            var branch_name = $('#edit_emp_branch').val();
            var department_name = $('#edit_emp_department').val();
            var client_name = $('#edit_emp_client').val();
            var subprocess = $('#edit_emp_subprocess').val();
            var designation_name = $('#edit_emp_designation').val();
            var department_role = $('#edit_emp_departmentrole').val();
            var grade = $('#edit_emp_grade').val();
            var reporting_to = $('#reporting_to').val();
            var joining_date = $('#joining_date').val();
            var confirmation_period;
            if (document.getElementById("6months").checked) {
                confirmation_period = document.getElementById("6months").value;
            } else {
                confirmation_period = document.getElementById("3months").value;
            }

            var confirmation_date = $('#confirmation_date').val();
            var formdata = {
                employee_id: employee_id,
                first_name: first_name,
                middle_name: middle_name,
                last_name: last_name,
                gender: gender,
                birthdate: birthdate,
                actual_birthdate: actual_birthdate,
                blood_group: blood_group,
                mobile_number: mobile_number,
                alternate_number: alternate_number,
                official_email_address: official_email_address,
                bank_name: bank_name,
                acc_no: acc_no,
                ifsc_code: ifsc_code,
                pan_no: pan_no,
                uan_no: uan_no,
                pf_no: pf_no,
                esi: esi,
                medical_insurance: medical_insurance,
                company_name: company_name,
                branch_name: branch_name,
                department_name: department_name,
                client_name: client_name,
                subprocess: subprocess,
                designation_name: designation_name,
                department_role: department_role,
                grade: grade,
                reporting_to: reporting_to,
                joining_date: joining_date,
                confirmation_period: confirmation_period,
                confirmation_date: confirmation_date
            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_basicInfo') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editbasic_error').show();
                    }
                    if (msg == 'success') {
                        $('#editbasic_error').hide();
                        $('#basic_form_button').hide();
                        $('#basic_form_next').show();
                        $('#editbasic_success').show();
                    }

                }

            });
        });
        $('#editemployeepersonal_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#employee_id').val();
            var nationality = $('#nationality').val();
            var religion = $('#religion').val();
            var caste = $('#edit_caste').val();
            var mother_tongue = $('#mother_tongue').val();
            var marital_status = $('#marital_status').val();
            var personal_blood_group = $('#personal_blood_group').val();
            var personal_birthdate = $('#personal_birthdate').val();
            var personal_actual_birthdate = $('#personal_actual_birthdate').val();
            var mobile_number = $('#emp_mobile_number').val();
            var alternate_number = $('#emp_alternate_number').val();
            var personal_email_address = $('#personal_email_address').val();
            var official_email_address = $('#official_email_address').val();
            var permanent_address = $('#edit_permanent_address').val();
            var temporary_address = $('#edit_temporary_address').val();
            var formdata = {
                employee_id: employee_id,
                nationality: nationality,
                religion: religion,
                caste: caste,
                mother_tongue: mother_tongue,
                personal_blood_group: personal_blood_group,
                personal_birthdate: personal_birthdate,
                personal_actual_birthdate: personal_actual_birthdate,
                marital_status: marital_status,
                mobile_number: mobile_number,
                alternate_number: alternate_number,
                personal_email_address: personal_email_address,
                official_email_address: official_email_address,
                permanent_address: permanent_address,
                temporary_address: temporary_address

            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_personalInfo') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editpersonalinfo_error').show();
                    }
                    if (msg == 'success') {
                        $('#editpersonalinfo_error').hide();
                        $('#personal_form_button').hide();
                        $('#personal_form_next').show();
                        $('#editpersonalinfo_success').show();
						$('#edit_personalinfo_table1').load(location.href + ' #edit_personalinfo_table1 tr');
                    }

                }

            });
        });
        $('#editemployeelang_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#lang_employee_id').val();
            var lang_name = $('#lang_name').val();
            var lang_read;
            if (document.getElementById("lang_read").checked) {
                lang_read = "Yes"
            } else {
                lang_read = "No"
            }

            var lang_speak;
            if (document.getElementById("lang_speak").checked) {
                lang_speak = "Yes"
            } else {
                lang_speak = "No"
            }
            var lang_write;
            if (document.getElementById("lang_write").checked) {
                lang_write = "Yes"
            } else {
                lang_write = "No"
            }

            var formdata = {
                employee_id: employee_id,
                lang_name: lang_name,
                lang_read: lang_read,
                lang_speak: lang_speak,
                lang_write: lang_write
            };
            $.ajax({
                url: "<?php echo site_url('Employee/language_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addlang_error').show();
                    }
                    if (msg == 'success') {
                        $('#lang_name').val("");
                        //   $("div").removeClass("checked");
                        document.getElementById("lang_read").checked = false;
                        document.getElementById("lang_speak").checked = false;
                        document.getElementById("lang_write").checked = false;
                        $('#addlang_success').show();
                        $('#edit_lang_table').load(location.href + ' #edit_lang_table tr');
						$('#edit_lang_table1').load(location.href + ' #edit_lang_table1 tr');
                      
                    }

                }

            });
        });
        $('#editfamily_form').submit(function (e) {
            e.preventDefault();
            var gender;
            if (document.getElementById("relation_male_gender").checked) {
                gender = document.getElementById("relation_male_gender").value;
            } else {
                gender = document.getElementById("relation_female_gender").value;
            }
            var employee_id = $('#employee_id').val();
            var family_member_name = $('#family_member_name').val();
            var family_member_age = $('#family_member_age').val();
            var family_member_dob = $('#family_member_dob').val();
            var family_member_relationship = $('#family_member_relationship').val();
            var family_member_occupation = $('#family_member_occupation').val();
            var formdata = {
                employee_id: employee_id,
                family_member_name: family_member_name,
                family_member_age: family_member_age,
                family_member_dob: family_member_dob,
                family_member_relationship: family_member_relationship,
                family_member_gender: gender,
                family_member_occupation: family_member_occupation

            };
            $.ajax({
                url: "<?php echo site_url('Employee/family_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addfamily_error').show();
                    }
                    if (msg == 'success') {
                        $('#family_member_name').val("");
                        $('#family_member_age').val("");
                        $('#family_member_dob').val("");
                        $('#family_member_relationship').val("");
                        $('#family_member_occupation').val("");
                        $('#addfamily_success').show();
                        $('#edit_family_table').load(location.href + ' #edit_family_table tr');
						$('#edit_family_table1').load(location.href + ' #edit_family_table1 tr');
                       
                    }

                }

            });
        });
        $('#editeducation_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#employee_id').val();
            var qualification = $('#qualification').val();
            var university_name = $('#university_name').val();
            var college_name = $('#college_name').val();
            var major_subject = $('#major_subject').val();
            var marks = $('#marks').val();
            var year_of_passing = $('#year_of_passing').val();
            var formdata = {
                employee_id: employee_id,
                qualification: qualification,
                university_name: university_name,
                college_name: college_name,
                major_subject: major_subject,
                marks: marks,
                year_of_passing: year_of_passing

            };
            $.ajax({
                url: "<?php echo site_url('Employee/education_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addeducation_error').show();
                    }
                    if (msg == 'success') {
                        $('#qualification').val("");
                        $('#university_name').val("");
                        $('#college_name').val("");
                        $('#major_subject').val("");
                        $('#marks').val("");
                        $('#year_of_passing').val("");
                        $('#addeducation_success').show();
                         $('#edit_education_table').load(location.href + ' #edit_education_table tr');
						$('#edit_education_table1').load(location.href + ' #edit_education_table1 tr');
                          }

                }

            });
        });
        $('#editskill_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#employee_id').val();
            var skill_name = $('#skill_name').val();
            var no_of_month = $('#no_of_month').val();
            var training = $('#training').val();
            var skill_from = $('#skill_from').val();
            var skill_to = $('#skill_to').val();
            var formdata = {
                employee_id: employee_id,
                skill_name: skill_name,
                no_of_month: no_of_month,
                training: training,
                skill_from: skill_from,
                skill_to: skill_to

            };
            $.ajax({
                url: "<?php echo site_url('Employee/skill_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addskills_error').show();
                    }
                    if (msg == 'success') {
                        $('#skill_name').val("");
                        $('#no_of_month').val("");
                        $('#training').val("");
                        $('#skill_from').val("");
                        $('#skill_to').val("");
                        $('#addskills_success').show();
                        $('#edit_skill_table').load(location.href + ' #edit_skill_table tr');
						$('#edit_skill_table1').load(location.href + ' #edit_skill_table1 tr');
                     }

                }

            });
        });
        $('#editemployeeexp_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#employee_id').val();
            var prev_company_name = $('#prev_company_name').val();
            var prev_designation = $('#prev_designation').val();
            var prev_company_location = $('#prev_company_location').val();
            var prev_salary = $('#prev_salary').val();
            var prev_date_joined = $('#prev_date_joined').val();
            var prev_date_relieved = $('#prev_date_relieved').val();
            var prev_reason_relieving = $('#prev_reason_relieving').val();
            var relevant_exp;
            if (document.getElementById("relevant_exp").checked) {
                relevant_exp = document.getElementById("relevant_exp").value;
            } else {
                relevant_exp = document.getElementById("non_relevant_exp").value;
            }
            var formdata = {
                employee_id: employee_id,
                prev_company_name: prev_company_name,
                prev_designation: prev_designation,
                prev_company_location: prev_company_location,
                prev_salary: prev_salary,
                prev_date_joined: prev_date_joined,
                prev_date_relieved: prev_date_relieved,
                prev_reason_relieving: prev_reason_relieving,
                relevant_exp: relevant_exp

            };
            $.ajax({
                url: "<?php echo site_url('Employee/experience_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addexp_error').show();
                    }
                    if (msg == 'success') {
                        $('#prev_company_name').val("");
                        $('#prev_designation').val("");
                        $('#prev_company_location').val("");
                        $('#prev_salary').val("");
                        $('#prev_date_joined').val("");
                        $('#prev_date_relieved').val("");
                        $('#prev_reason_relieving').val("");
                        $('#addexp_success').show();
                        $('#edit_exp_table').load(location.href + ' #edit_exp_table tr');
						$('#edit_exp_table1').load(location.href + ' #edit_exp_table1 tr');
                    }

                }

            });
        });
        $('#editemployeeinfo_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#info_employee_id').val();
            var pancard_no = $('#pancard_no').val();
            var aadhar_no = $('#aadhar_no').val();
            var passport_no = $('#passport_no').val();
            var name_on_passport = $('#name_on_passport').val();
            var place_issue = $('#place_issue').val();
            var issue_date = $('#issue_date').val();
            var expiry_date = $('#expiry_date').val();
            var valid_visa;
            if (document.getElementById("valid_visa_no").checked) {
                valid_visa = document.getElementById("valid_visa_no").value;
            } else {
                valid_visa = document.getElementById("valid_visa_yes").value;
            }

            var issue_country = $('#issue_country').val();
            var hobbies = $('#hobbies').val();
            var interest = $('#interest').val();
            var related_employee;
            if (document.getElementById("related_employee_no").checked) {
                related_employee = document.getElementById("related_employee_no").value;
            } else {
                related_employee = document.getElementById("related_employee_yes").value;
            }

            var related_employee_name = $('#related_employee_name').val();
            //    var membership = $('#membership').val();
            //    var other = $('#other').val();
            var voter_id = $('#voter_id').val();
            var allergic = $('#allergic').val();
            var blood_pressure = $('#blood_pressure').val();
            var differently_abled = $('#differently_abled').val();
            var weight = $('#weight').val();
            var height = $('#height').val();
            var eye_sight = $('#eye_sight').val();
            var illness = $('#illness').val();
            var emergency_contactperson_name = $('#emergency_contactperson_name').val();
            var emergency_contact_no = $('#emergency_contact_no').val();
            var formdata = {
                employee_id: employee_id,
                pancard_no: pancard_no,
                aadhar_no: aadhar_no,
                passport_no: passport_no,
                name_on_passport: name_on_passport,
                place_issue: place_issue,
                issue_date: issue_date,
                expiry_date: expiry_date,
                valid_visa: valid_visa,
                issue_country: issue_country,
                hobbies: hobbies,
                interest: interest,
                related_employee: related_employee,
                related_employee_name: related_employee_name,
                //  membership: membership,
                //   other: other,
                voter_id: voter_id,
                allergic: allergic,
                blood_pressure: blood_pressure,
                differently_abled: differently_abled,
                weight: weight,
                height: height,
                eye_sight: eye_sight,
                illness: illness,
                emergency_contactperson_name: emergency_contactperson_name,
                emergency_contact_no: emergency_contact_no
            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_info_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editinfo_error').show();
                    }
                    if (msg == 'success') {
                        $('#editinfo_error').hide();
                        $('#info_form_button').hide();
                        $('#info_form_next').show();
                        $('#editinfo_success').show();
						$('#edit_additional_table1').load(location.href + ' #edit_additional_table1 tr');
						$('#edit_emergency_table1').load(location.href + ' #edit_emergency_table1 tr');
                    }

                }

            });
        });
        $('#background_button').click(function (e) {
            e.preventDefault();
            var employee_id = $('#bgverify_employee_id').val();
            var background_verification;
            if (document.getElementById("background_verification_no").checked) {
                background_verification = document.getElementById("background_verification_no").value;
            } else {
                background_verification = document.getElementById("background_verification_yes").value;
            }


            var formdata = {
                employee_id: employee_id,
                background_verification: background_verification
            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_background_verification') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addbgverify_error').show();
                    }
                    if (msg == 'success') {
                        $('#addbgverify_error').hide();
                        $('#addbgverify_success').show();
                    }

                }

            });
        });
        $('#editemployeefresherreference_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#fresherref_employee_id').val();
            var reference_person_name = $('#reference_person_name').val();
            var reference_person_relation = $('#reference_person_relation').val();
            var reference_person_occupation = $('#reference_person_occupation').val();
            var reference_person_mobile = $('#reference_person_mobile').val();
            var reference_person_email = $('#reference_person_email').val();
            var formdata = {
                employee_id: employee_id,
                reference_person_name: reference_person_name,
                reference_person_relation: reference_person_relation,
                reference_person_occupation: reference_person_occupation,
                reference_person_mobile: reference_person_mobile,
                reference_person_email: reference_person_email

            };
            $.ajax({
                url: "<?php echo site_url('Employee/fresherref_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addfresherref_error').show();
                    }
                    if (msg == 'success') {
                        $('#reference_person_name').val("");
                        $('#reference_person_relation').val("");
                        $('#reference_person_occupation').val("");
                        $('#reference_person_mobile').val("");
                        $('#reference_person_email').val("");
                        $('#addfresherref_success').show();
                      $('#fresherref_table').load(location.href + ' #fresherref_table tr');
						$('#edit_fresher_reference_table1').load(location.href + ' #edit_fresher_reference_table1 tr');
                        }
                }
            });
        });
        $('#editemployeereference_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#ref_employee_id').val();
            var prev_cmpref_fullname = $('#prev_cmpref_fullname').val();
            var prev_cmpref_name = $('#prev_cmpref_name').val();
            var prev_cmpref_designation = $('#prev_cmpref_designation').val();
            var prev_cmpref_email = $('#prev_cmpref_email').val();
            var prev_cmpref_mobile = $('#prev_cmpref_mobile').val();
            var prev_cmpref_telephone = $('#prev_cmpref_telephone').val();
            var formdata = {
                employee_id: employee_id,
                prev_cmpref_fullname: prev_cmpref_fullname,
                prev_cmpref_name: prev_cmpref_name,
                prev_cmpref_designation: prev_cmpref_designation,
                prev_cmpref_email: prev_cmpref_email,
                prev_cmpref_mobile: prev_cmpref_mobile,
                prev_cmpref_telephone: prev_cmpref_telephone

            };
            $.ajax({
                url: "<?php echo site_url('Employee/reference_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addref_error').show();
                    }
                    if (msg == 'success') {
                        $('#prev_cmpref_fullname').val("");
                        $('#prev_cmpref_name').val("");
                        $('#prev_cmpref_designation').val("");
                        $('#prev_cmpref_email').val("");
                        $('#prev_cmpref_mobile').val("");
                        $('#prev_cmpref_telephone').val("");
                        $('#addref_success').show();
                        $('#ref_table').load(location.href + ' #ref_table tr');
						$('#edit_exp_reference_table1').load(location.href + ' #edit_exp_reference_table1 tr');
                        
                    }
                }
            });
        });
    });</script>

<script>
    function Download(fileURL, fileName) {
        // for non-IE
        if (!window.ActiveXObject) {
            var save = document.createElement('a');
            save.href = fileURL;
            save.target = '_blank';
            save.download = fileName || fileURL;
            var evt = document.createEvent('MouseEvents');
            evt.initMouseEvent('click', true, true, window, 1, 0, 0, 0, 0,
                    false, false, false, false, 0, null);
            save.dispatchEvent(evt);
            (window.URL || window.webkitURL).revokeObjectURL(save.href);
        }

        // for IE
        else if (!!window.ActiveXObject && document.execCommand) {
            var _window = window.open(fileURL, "_blank");
            _window.document.close();
            _window.document.execCommand('SaveAs', true, fileName || fileURL)
            _window.close();
        }
    }
    function others(type) {
        if (type == "Others") {
            $('#other_text').show();
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function (e) {
        $("#edit_attachment_form").on('submit', (function (e) {
            e.preventDefault();
            var attach_type = $('#attach_type').val();
            $.ajax({
                url: "<?php echo site_url('Employee/attachment') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#adddocument_error').show();
                    }
                    else {
                        $('#adddocument_success').show();
                        $('#document_table').load(location.href + ' #document_table tr');
                    }
                },
                error: function ()
                {
                }
            });
        }));
    });
    //function emp_markconfirmation(emp_mode,emp_id,mode_comment){

    function emp_markconfirmation(emp_mode, emp_no, mode_comment) {
        var formdata = {
            emp_mode: emp_mode,
            emp_no: emp_no,
            mode_comment: mode_comment
        };
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Empconfirmation') ?>",
            data: formdata,
            cache: false,
            success: function (html) {

            }
        });
    }
</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Basic Information</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick=" history.back();">
                                Back
                                <i class=" entypo-back"></i>
                            </button>
                        </div>
                    </div>

                    <!--<form id="editemployee_form" method="post" action="" class="form-wizard validate">-->
                    <div class="form-wizard">
                        <?php
                        if ($user_role == 1 || $user_role == 4 || $user_role == 5 || $user_role == 7) {
                            if ($this->uri->segment(3) == "") {
                                ?>
                                <div class="steps-progress">
                                    <div class="progress-indicator"></div>
                                </div>

                                <ul>
                                    <li class="active">
                                        <a href="#tab1" data-toggle="tab"><span>1</span>Employee Details</a>
                                    </li>

                                    <li>
                                        <a href="#tab2" data-toggle="tab"><span>2</span>Personal Details</a>
                                    </li>
                                    <li>
                                        <a href="#tab3" data-toggle="tab"><span>3</span>Family Details</a>
                                    </li>
                                    <li>
                                        <a href="#tab4" data-toggle="tab"><span>4</span>Education</a>
                                    </li>
                                    <li>
                                        <a href="#tab5" data-toggle="tab"><span>5</span>Work Experience</a>
                                    </li>
                                    <li>
                                        <a href="#tab6" data-toggle="tab"><span>6</span>Additional Information</a>
                                    </li>
                                    <li>
                                        <a href="#tab8" data-toggle="tab"><span>7</span>Reference</a>
                                    </li>

                                    <li>
                                        <a href="#tab9" data-toggle="tab"><span>8</span>Preview</a>
                                    </li>

                                    <?php
                                }
                            }
                            ?>
                        </ul>

                                        <?php
                                    if ($user_role == 2 || $user_role == 3 || $user_role == 6) {
                                ?>
                                <div class="steps-progress">
                                    <div class="progress-indicator"></div>
                                </div>

                                <ul>
                                    <li class="active">
                                        <a href="#tab1" data-toggle="tab"><span>1</span>Employee Details</a>
                                    </li>

                                    <li>
                                        <a href="#tab2" data-toggle="tab"><span>2</span>Personal Details</a>
                                    </li>
                                    <li>
                                        <a href="#tab3" data-toggle="tab"><span>3</span>Family Details</a>
                                    </li>
                                    <li>
                                        <a href="#tab4" data-toggle="tab"><span>4</span>Education</a>
                                    </li>
                                    <li>
                                        <a href="#tab5" data-toggle="tab"><span>5</span>Work Experience</a>
                                    </li>
                                    <li>
                                        <a href="#tab6" data-toggle="tab"><span>6</span>Additional Information</a>
                                    </li>
                                    <?php if ($user_role == 3) { ?>
                                        <li>
                                            <a href="#tab8" data-toggle="tab"><span>7</span>Reference</a>
                                        </li>

                                        <li>
                                            <a href="#tab9" data-toggle="tab"><span>8</span>Preview</a>
                                        </li>

                                    <?php } ?> 
                                    <?php if ($user_role == 2 || $user_role == 6) { ?>
                                        <li>
                                            <a href="#tab7" data-toggle="tab"><span>7</span>Attachments</a>
                                        </li>

                                        <li>
                                            <a href="#tab8" data-toggle="tab"><span>8</span>Background Verification</a>
                                        </li>
                                        <li>
                                            <a href="#tab9" data-toggle="tab"><span>9</span>Preview</a>
                                        </li>

                                        <?php
                                    }
                                }
                                ?>

                            </ul>

                            <div class="tab-content">
                                <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $emp_no; ?>">
                                <input type="hidden" id="employee_code" name="employee_code" value="<?php echo $emp_code; ?>">

                                <div class="tab-pane active" id="tab1">
                                    <form id="editemployeebasic_form" method="post" action="" class="validate">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="editbasic_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="editbasic_success" class="alert alert-success" style="display:none;">Basic information updated successfully.</div>
                                                <div id="editbasic_error" class="alert alert-danger" style="display:none;">Failed to update basic information.</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Employee Id</label>
                                                    <input class="form-control" name="emp_id" id="emp_id" value="<?php echo $emp_code . $emp_no; ?>" disabled="disabled" />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="full_name">First Name</label>
                                                    <input class="form-control" name="first_name" id="first_name" data-validate="required" placeholder="Your Name" data-message-required="Please enter first name." value="<?php echo $first_name; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label" for="full_name">Middle Name</label>
                                                    <input class="form-control" name="middle_name" id="middle_name" placeholder="Your Middle Name" value="<?php echo $middle_name; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label" for="full_name">Last Name</label>
                                                    <input class="form-control" name="last_name" id="last_name" placeholder="Your Last Name" data-validate="required" data-message-required="Please enter last name." value="<?php echo $last_name; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="full_name">Joining Date</label>
                                                    <div class="input-group">
                                                        <input type="text" name="joining_date" id="joining_date" class="form-control datepicker" data-format="dd-mm-yyyy" onchange="showperiod()" data-validate="required" data-message-required="Please select date." value="<?php echo $Emp_Doj; ?>">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label" for="birthdate">Date of Birth</label>
                                                    <div class="input-group">
                                                        <input type="text" name="birthdate" id="birthdate" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please select birth date." value="<?php echo $dob; ?>" onchange="getEmpAge(this.value)">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php
                                            $emp_bdy=new DateTime($birthdate);
                                            $today = new DateTime('today');
                                            $emp_age = $emp_bdy->diff($today)->y;
                                            ?>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="control-label">Age</label>
                                                    <input class="form-control" name="emp_age" id="emp_age" placeholder="Age" value="<?php echo $emp_age;?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label" for="birthdate">Actual Date of Birth</label>
                                                    <div class="input-group">
                                                        <input type="text" name="actual_birthdate" id="actual_birthdate" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select birth date." value="<?php echo $actual_dob; ?>">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label" for="gender">Gender</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="male" name="emp_gender" value="Male" <?php
                                                            if ($gender == "Male") {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>Male</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="female" name="emp_gender" value="Female" <?php
                                                            if ($gender == "Female") {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>Female</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Mobile Number</label>
                                                    <input class="form-control" name="mobile_number" id="mobile_number" placeholder="Mobile Number" data-validate="required,number" data-message-required="Please enter mobile number." maxlength="15" value="<?php echo $Emp_Contact ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Alternate Number</label>
                                                    <input class="form-control" name="alternate_number" id="alternate_number" placeholder="Alternate Number" data-validate="number" data-message-required="Please enter mobile number." maxlength="15" value="<?php echo $Emp_AlternateContact; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Official Email Address</label>
                                                    <input class="form-control" name="official_email_address" id="official_email_address" placeholder="Email Address" data-validate="email" value="<?php echo $Emp_Officialemail; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Blood Group</label>
                                                    <select name="blood_group" id="blood_group" class="round">
                                                        <option value="<?php echo $blood_group; ?>"><?php echo $blood_group; ?></option>
                                                        <option value="A+">A+</option>
                                                        <option value="A-">A-</option>
                                                        <option value="AB+">AB+</option>
                                                        <option value="AB-">AB-</option>
                                                        <option value="B+">B+</option>
                                                        <option value="B-">B-</option>
                                                        <option value="O+">O+</option>
                                                        <option value="O-">O-</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="period">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label">Confirmation Period</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="radio radio-replace">
                                                                <input type="radio" name="confirmation_period" id="3months" value="3" onclick="showconfirmationdate(this.value, $('#joining_date').val())" <?php
                                                                if ($Emp_Confirmationperiod == 3) {
                                                                    echo "checked";
                                                                }
                                                                ?>>
                                                                <label>3 Months</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="radio radio-replace">
                                                                <input type="radio" name="confirmation_period" id="6months" value="6" onclick="showconfirmationdate(this.value, $('#joining_date').val())" <?php
                                                                if ($Emp_Confirmationperiod == 6) {
                                                                    echo "checked";
                                                                }
                                                                ?>>
                                                                <label>6 Months</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label" for="full_name">Confirmation Date</label>
                                                        <input class="form-control" name="confirmation_date" id="confirmation_date" disabled="disabled" data-validate="required" data-message-required="Please enter confirmation date." value="<?php echo $Emp_Confirmationdate; ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Permanent Address</label>
                                                    <textarea class="form-control" name="permanent_address" id="permanent_address" placeholder="Permanent Address"><?php echo $Emp_Permanent; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Temporary Address</label>
                                                    <textarea class="form-control" name="temporary_address" id="temporary_address" placeholder="Temporary Address"><?php echo $Emp_Temporary; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Employee Mode</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" name="emp_mode" id="Probation" value="Probation"  onclick="emp_markconfirmation(this.value, '<?php echo $emp_no ?>', $('#mode_comment').val())" <?php
                                                            if ($Emp_Mode == 'Probation') {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>Probation</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style='padding-left:0px'>
                                                        <div class="radio radio-replace">
                                                            <input type="radio" name="emp_mode" id="Confirmed" value="Confirmed"  onclick="emp_markconfirmation(this.value, '<?php echo $emp_no ?>', $('#mode_comment').val())" <?php
                                                            if ($Emp_Mode == 'Confirmed') {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>Confirmation</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Comment</label>
                                                    <textarea class="form-control" name="mode_comment" id="mode_comment" placeholder="Comment"><?php echo $Emp_mode_comment; ?></textarea>
                                                </div>
                                            </div>

                                        </div>


                                        <?php if (($user_role == 2) || ($current_user == $emp_no) || $user_role == 6 || $user_role == 4 || $user_role == 7) {
                                            ?>
                                            <h3>Bank Information</h3>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Bank Name</label>
                                                        <input class="form-control" name="bank_name" id="bank_name" value="<?php echo $Emp_Bankname; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label" for="full_name">Account Number</label>
                                                        <input class="form-control" name="acc_no" id="acc_no" value="<?php echo $Emp_Accno; ?>" data-validate="number"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label" for="full_name">IFSC Code</label>
                                                        <input class="form-control" name="ifsc_code" id="ifsc_code" value="<?php echo $Emp_IFSCcode; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label" for="full_name">PAN Card No</label>
                                                        <input class="form-control" name="pan_no" id="pan_no" value="<?php echo $Emp_PANcard; ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">UAN Number</label>
                                                        <input class="form-control" name="uan_no" id="uan_no" value="<?php echo $Emp_UANno; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label" for="full_name">PF Number</label>
                                                        <input class="form-control" name="pf_no" id="pf_no" value="<?php echo $Emp_PFno; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label" for="full_name">ESI</label>
                                                        <input class="form-control" name="esi" id="esi" value="<?php echo $Emp_ESI; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label" for="full_name">Medical Insurance</label>
                                                        <input class="form-control" name="medical_insurance" id="medical_insurance" value="<?php echo $Emp_Medicalinsurance; ?>"/>
                                                    </div>
                                                </div>
                                            </div>


                                        <?php }
                                        ?>

                                        <h3>Designation Information</h3>

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="full_name">Branch</label>
                                                    <select class="round" id="edit_emp_branch" name="edit_emp_branch" onChange="showDepartment(this)
                                                                    ;" data-validate="required" data-message-required="Please select branch.">
                                                        <option value="<?php echo $branch_id; ?>"><?php echo $branch_name; ?></option>
                                                        <?php foreach ($select_branch_exp->result() as $row_branch_exp) { ?>
                                                            <option value="<?php echo $row_branch_exp->Branch_ID; ?>"><?php echo $row_branch_exp->Branch_Name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="full_name">Department</label>
                                                    <select name="edit_emp_department" id="edit_emp_department" class="round" onChange="showClient(this)
                                                                    ;"  data-validate="required" data-message-required="Please select department.">
                                                        <option value="<?php echo $department_id; ?>"><?php echo $department_name; ?></option>
                                                        <?php foreach ($select_dept_exp->result() as $row_dept_exp) { ?>
                                                            <option value="<?php echo $row_dept_exp->Department_Id; ?>"><?php echo $row_dept_exp->Department_Name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="full_name">Process</label>
                                                    <select name="edit_emp_client" id="edit_emp_client" class="round" onChange="showSubprocess(this)
                                                                    ;" data-validate="required" data-message-required="Please select client.">
                                                        <option value="<?php echo $client_id; ?>"><?php echo $client_name . " : " . $subdepartment_name; ?></option>
                                                        <?php foreach ($select_client_exp->result() as $row_client_exp) { ?>
                                                            <option value="<?php echo $row_client_exp->Subdepartment_Id; ?>"><?php echo $row_client_exp->Client_Name . " : " . $row_client_exp->Subdepartment_Name;?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Sub Department</label>
                                                    <select name="edit_emp_subprocess" id="edit_emp_subprocess" class="round" data-validate="required" data-message-required="Please select sub department." onChange="showDesignation(this)
                                                                    ;" >
                                                        <option value="<?php echo $subdepartment_id; ?>"><?php echo $subdepartment_name; ?></option>
                                                        <?php foreach ($select_subdept_exp->result() as $row_subdept_exp) { ?>
                                                            <option value="<?php echo $row_subdept_exp->Subdepartment_Id; ?>"><?php echo $row_subdept_exp->Subdepartment_Name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="full_name">Designation</label>
                                                    <select name="edit_emp_designation" id="edit_emp_designation" class="round" data-validate="required" data-message-required="Please select designation." onChange="showGrade(this);">
                                                        <option value="<?php echo $designation_id; ?>"><?php echo $designation_name; ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Grade</label>
                                                    <select name="edit_emp_grade" id="edit_emp_grade" class="round" data-validate="required" data-message-required="Please select grade." onChange="showDepartmentRole(this)
                                                                    ;">
                                                        <option value="<?php echo $emp_grade_id; ?>"><?php echo $grade_name; ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Role</label>
                                                    <select name="edit_emp_departmentrole" id="edit_emp_departmentrole" class="round" data-validate="required" data-message-required="Please select role.">
                                                        <option value="<?php echo $dept_role_id; ?>"><?php echo $dept_role; ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Reporting To</label>
                                                    <select name="reporting_to" id="reporting_to" class="round" data-validate="required" data-message-required="Please select reporting manager.">
                                                        <option value="<?php echo $report_to_id; ?>"><?php echo $reporting_name . '- ' . $emp_code . $report_to_id; ?></option>
                                                        <?php foreach ($select_report_exp->result() as $row_report_exp) { ?>
                                                            <option value="<?php echo $row_report_exp->Emp_Number; ?>"><?php echo $row_report_exp->Emp_FirstName . ' ' . $row_report_exp->Emp_LastName . ' ' . $row_report_exp->Emp_MiddleName . '- ' . $emp_code . $row_report_exp->Emp_Number; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($user_role == 2 || $user_role == 6) { ?>
                                            <div id="basic_form_button" style="float: right;margin-bottom: 10px">
                                                <button type="submit" class="btn btn-white">Add Info</button>
                                            </div>

                                            <ul class="pager wizard" id="basic_form_next" style="display:none">
                                                <li class="next">
                                                    <a href="#">Next <i class="entypo-right-open"></i></a>
                                                </li>
                                            </ul>
                                            <?php
                                        } if ($user_role == 1) {
                                            if ($this->uri->segment(3) == "") {
                                                ?>
                                                <ul class="pager wizard" id="basic_form_next">
                                                    <li class="next">
                                                        <a href="#">Next <i class="entypo-right-open"></i></a>
                                                    </li>
                                                </ul>   
                                                <?php
                                            }
                                        }
                                        ?>
                                    </form>
                                    <?php if ($user_role == 3) { ?>
                                        <ul class="pager wizard">
                                            <li class="next">
                                                <a href="#">Next <i class="entypo-right-open"></i></a>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </div>

                                <div class="tab-pane" id="tab2">
                                    <h3>Personal Information</h3>
                                    <form id="editemployeelang_form" method="post" class="validate">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="editlang_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="addlang_success" class="alert alert-success" style="display:none;">Language added successfully.</div>
                                                <div id="addlang_error" class="alert alert-danger" style="display:none;">Failed to add language.</div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang_employee_id" id="lang_employee_id" value="<?php echo $emp_no; ?>">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Language</label>
                                                    <input class="form-control" name="lang_name" id="lang_name" placeholder="Language" data-validate="required" data-message-required="Please enter language." />
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group" style="margin-top: 30px">
                                                    <label class="control-label">Read</label>
                                                    <div class="checkbox_outer">
                                                        <input id="lang_read" type="checkbox" name="lang_read"><span></span>
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group" style="margin-top: 30px">
                                                    <label class="control-label">Speak</label>
                                                    <div class="checkbox_outer">
                                                        <input id="lang_speak" type="checkbox" name="lang_speak"><span></span>
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group" style="margin-top: 30px">
                                                    <label class="control-label">Write</label>
                                                    <div class="checkbox_outer">
                                                        <input id="lang_write" type="checkbox" name="lang_write"><span></span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="margin-top:20px;">
                                                <button class="btn btn-primary" type="submit" id="lang_button" name="lang_button">Add</button>
                                                <button class="btn btn-default" type="reset">Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <table class="table table-bordered" id="edit_lang_table">
                                            <thead>
                                                <tr>
                                                    <th>Language</th>
                                                    <th>Read</th>
                                                    <th>Speak</th>
                                                    <th>Write</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_lang > 0) {
                                                    foreach ($select_lang->result() as $row_lang) {
                                                        $lang_id = $row_lang->Lang_Id;
                                                        $lang_name = $row_lang->Lang_Name;
                                                        $lang_read = $row_lang->Lang_Read;
                                                        $lang_speak = $row_lang->Lang_Speak;
                                                        $lang_write = $row_lang->Lang_Write;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $lang_name; ?></td>
                                                            <td><?php echo $lang_read; ?></td>
                                                            <td><?php echo $lang_speak; ?></td>
                                                            <td><?php echo $lang_write; ?></td>
                                                            <td>
                                                                <a data-toggle='modal' href='#delete_lang_details' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_lang_details(<?php echo $lang_id; ?>)">
                                                                    <i class="entypo-cancel"></i>
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <form id="editemployeepersonal_form" method="post" class="validate">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="editpersonalinfo_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="editpersonalinfo_success" class="alert alert-success" style="display:none;">Personal details updated successfully.</div>
                                                <div id="editpersonalinfo_error" class="alert alert-danger" style="display:none;">Failed to update personal details.</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Nationality</label>
                                                    <select name="nationality" id="nationality" class="round" data-validate="required" data-message-required="Please select nationality.">
                                                        <option value="<?php echo $Emp_Nationality; ?>"><?php echo $Emp_Nationality; ?></option>
                                                        <option value="Indian">Indian</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Religion</label>
                                                    <select name="religion" id="religion" class="round" data-validate="required" data-message-required="Please select religion.">
                                                        <option value="<?php echo $Emp_Religion; ?>"><?php echo $Emp_Religion; ?></option>
                                                        <option value="Hinduism">Hinduism</option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Christianity">Christianity</option>
                                                        <option value="Buddhism">Buddhism</option>
                                                        <option value="Sikhism">Sikhism</option>
                                                        <option value="Judaism">Judaism</option>
                                                        <option value="Jainism">Jainism</option>
                                                    </select>                                            
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Caste</label>
                                                    <input class="form-control" name="edit_caste" id="edit_caste" placeholder="Caste" data-validate="required" data-message-required="Please enter caste name." value="<?php echo $Emp_Caste; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Mother Tongue</label>
                                                    <input class="form-control" name="mother_tongue" id="mother_tongue" placeholder="Language" data-validate="required" data-message-required="Please enter mother_tongue." value="<?php echo $Emp_Mother_Tongue; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Blood Group</label>
                                                    <select data-message-required="Please select blood group." data-validate="required" class="round" id="personal_blood_group" name="personal_blood_group" aria-required="true" aria-invalid="false">
                                                        <option value="<?php echo $blood_group; ?>"><?php echo $blood_group; ?></option>
                                                        <option value="A+">A+</option>
                                                        <option value="A-">A-</option>
                                                        <option value="AB+">AB+</option>
                                                        <option value="AB-">AB-</option>
                                                        <option value="B+">B+</option>
                                                        <option value="B-">B-</option>
                                                        <option value="O+">O+</option>
                                                        <option value="O-">O-</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="birthdate">Date of Birth</label>
                                                    <div class="input-group">
                                                        <input type="text" name="personal_birthdate" id="personal_birthdate" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please select birth date." value="<?php echo $dob; ?>">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="birthdate">Actual Date of Birth</label>
                                                    <div class="input-group">
                                                        <input type="text" name="personal_actual_birthdate" id="personal_actual_birthdate" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select birth date." value="<?php echo $actual_dob; ?>">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Marital Status</label>
                                                    <select name="marital_status" id="marital_status" class="round" data-validate="required" data-message-required="Please select religion.">
                                                        <option value="<?php echo $Emp_Marrial; ?>"><?php echo $Emp_Marrial; ?></option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Widower">Widower</option>
                                                        <option value="Divorcee">Divorcee</option>
                                                    </select>                                            
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Mobile Number</label>
                                                    <input class="form-control" name="emp_mobile_number" id="emp_mobile_number" placeholder="Mobile Number" data-validate="required,number" data-message-required="Please enter mobile number."  value="<?php echo $Emp_Contact; ?>" maxlength="10"/>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Alternate Number</label>
                                                    <input class="form-control" name="emp_alternate_number" id="emp_alternate_number" placeholder="Alternate Number" data-validate="number" value="<?php echo $Emp_AlternateContact; ?>" maxlength="10"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Personal Email Address</label>
                                                    <input class="form-control" name="personal_email_address" id="personal_email_address" placeholder="Email Address" data-validate="required,email" data-message-required="Please enter email address."  value="<?php echo $Emp_PersonalEmail; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Permanent Address</label>
                                                    <textarea class="form-control" name="edit_permanent_address" id="edit_permanent_address" placeholder="Permanent Address"><?php echo $Emp_Permanent; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-top: 30px">
                                                    <label class="control-label">Same as Permanent Address</label>
                                                    <div class="checkbox_outer">
                                                        <input id="same_address" type="checkbox" name="same" onclick="showpermanentaddress($('#edit_permanent_address').val())"><span></span>
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Temporary Address</label>
                                                    <textarea class="form-control" name="edit_temporary_address" id="edit_temporary_address" placeholder="Temporary Address"><?php echo $Emp_Temporary; ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="personal_form_button" style="float: right;margin-bottom: 10px">
                                            <button type="submit" class="btn btn-white">Add Info</button>
                                        </div>

                                        <ul class="pager wizard" id="personal_form_next" style="display:none">
                                            <li class="next">
                                                <a href="#">Next <i class="entypo-right-open"></i></a>
                                            </li>
                                        </ul>
                                    </form>
                                </div>

                                <div class="tab-pane" id="tab3">
                                    <h3>Family Information</h3>
                                    <form id="editfamily_form" method="post" class="validate">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="addfamily_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="addfamily_success" class="alert alert-success" style="display:none;">Family details added successfully.</div>
                                                <div id="addfamily_error" class="alert alert-danger" style="display:none;">Failed to add family details.</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input class="form-control" name="family_member_name" id="family_member_name" data-validate="required" data-message-required="Please enter name."  />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Date of Birth</label>
                                                    <div class="input-group">
                                                        <input type="text" name="family_member_dob" id="family_member_dob" class="form-control datepicker" data-format="dd-mm-yyyy" onchange="getAge(this.value)" data-validate="required" data-message-required="Please enter date of birth.">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Age</label>
                                                    <input class="form-control" name="family_member_age" id="family_member_age" data-validate="number" maxlength="2" disabled="disabled"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Relationship</label>
                                                    <input class="form-control" name="family_member_relationship" id="family_member_relationship" data-validate="required" data-message-required="Please enter relation." />
                                                    <?php echo form_error('family_member_relationship'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label" for="gender">Gender</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="relation_male_gender" name="relation_gender" value="male" checked>
                                                            <label>Male</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="relation_female_gender" name="relation_gender" value="female">
                                                            <label>Female</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">Occupation</label>
                                                    <input class="form-control" name="family_member_occupation" id="family_member_occupation" />
                                                </div>
                                            </div>

                                            <div class="col-md-4" style="margin-top:20px;">
                                                <button class="btn btn-primary" type="submit" name="family_button" id="family_button">Add</button>
                                                <button class="btn btn-default" type="reset">Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <table class="table table-bordered" id="edit_family_table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>DOB</th>
                                                    <th>Age</th>
                                                    <th>Relationship</th>
                                                    <th>Gender</th>
                                                    <th>Occupation</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_family > 0) {
                                                    foreach ($select_family->result() as $row_family) {
                                                        $family_id = $row_family->Family_Id;
                                                        $family_name = $row_family->Name;
                                                        $family_age = $row_family->Age;
                                                        $family_dateofbirth = $row_family->DOB;
														if($family_dateofbirth == "0000-00-00"){
															$family_dob = " ";
														}else{
															$family_dob = date("d-m-Y", strtotime($family_dateofbirth));
														}
                                                        $family_relation = $row_family->Relationship;
                                                        $family_gender = $row_family->Gender;
                                                        $family_occupation = $row_family->Occupation;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $family_name; ?></td>
                                                            <td><?php echo $family_dob; ?></td>
                                                            <td><?php echo $family_age; ?></td>
                                                            <td><?php echo $family_relation; ?></td>
                                                            <td><?php echo $family_gender; ?></td>
                                                            <td><?php echo $family_occupation; ?></td>
                                                            <td>
                                                                <a data-toggle='modal' href='#edit_family_details' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_family_details(<?php echo $family_id; ?>)">
                                                                    <i class="entypo-pencil"></i>
                                                                    Edit
                                                                </a>

                                                                <a data-toggle='modal' href='#delete_family_details' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_family_details(<?php echo $family_id; ?>)">
                                                                    <i class="entypo-cancel"></i>
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <ul class="pager wizard">
                                        <li class="next">
                                            <a href="#">Next <i class="entypo-right-open"></i></a>
                                        </li>
                                    </ul>

                                </div>

                                <div class="tab-pane" id="tab4">
                                    <h3>Educational Information</h3>
                                    <form id="editeducation_form" method="post" class="validate">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="addeducation_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="addeducation_success" class="alert alert-success" style="display:none;">Education details added successfully.</div>
                                                <div id="addeducation_error" class="alert alert-danger" style="display:none;">Failed to add education details.</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Qualification</label>
                                                    <input class="form-control" name="qualification" id="qualification" data-validate="required" placeholder="Qualification" data-message-required="Please enter qualification."/>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">University</label>
                                                    <input class="form-control" name="university_name" id="university_name" placeholder="University Name" data-validate="required" data-message-required="Please enter university name."/>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">School/College Name</label>
                                                    <input class="form-control" name="college_name" id="college_name" placeholder="College Name" data-validate="required" data-message-required="Please enter college name."/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Major Subject</label>
                                                    <input class="form-control" name="major_subject" id="major_subject" placeholder="Major Subject" data-validate="required" data-message-required="Please enter major subject."/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">% Marks</label>
                                                    <input class="form-control" name="marks" id="marks" placeholder="% Marks" data-validate="required,number" data-message-required="Please enter marks in %."/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Year of Passing</label>
                                                    <input class="form-control" name="year_of_passing" id="year_of_passing" placeholder="Year" data-validate="required,number" data-message-required="Please enter year of passing." maxlength="4"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="margin-top:20px;">
                                                <button class="btn btn-primary" type="submit" id="education_button" name="education_button">Add</button>
                                                <button class="btn btn-default" type="reset">Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <table class="table table-bordered" id="edit_education_table">
                                            <thead>
                                                <tr>
                                                    <th>Qualification</th>
                                                    <th>University</th>
                                                    <th>College Name</th>
                                                    <th>Major Subject</th>
                                                    <th>% Marks</th>
                                                    <th>Year</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_education > 0) {
                                                    foreach ($select_education->result() as $row_education) {
                                                        $education_id = $row_education->Emp_QualificationId;
                                                        $education_coursename = $row_education->Course_Name;
                                                        $education_university = $row_education->University;
                                                        $education_collegename = $row_education->College_Name;
                                                        $education_marks = $row_education->Marks;
                                                        $education_subject = $row_education->Major_Subject;
                                                        $year = $row_education->Year;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $education_coursename; ?></td>
                                                            <td><?php echo $education_university; ?></td>
                                                            <td><?php echo $education_collegename; ?></td>
                                                            <td><?php echo $education_subject; ?></td>
                                                            <td><?php echo $education_marks; ?></td>
                                                            <td><?php echo $year; ?></td>
                                                            <td>
                                                                <a data-toggle='modal' href='#edit_edu_details' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_edu_details(<?php echo $education_id; ?>)">
                                                                    <i class="entypo-pencil"></i>
                                                                    Edit
                                                                </a>

                                                                <a data-toggle='modal' href='#delete_edu_details' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_edu_details(<?php echo $education_id; ?>)">
                                                                    <i class="entypo-cancel"></i>
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h3>Skills Information</h3>
                                    <form id="editskill_form" method="post" class="validate">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="addskills_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="addskills_success" class="alert alert-success" style="display:none;">Skills details added successfully.</div>
                                                <div id="addskills_error" class="alert alert-danger" style="display:none;">Failed to add skills details.</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Skills</label>
                                                    <input class="form-control" name="skill_name" id="skill_name" data-validate="required" placeholder="Skills" data-message-required="Please enter skill name."/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">From</label>
                                                    <div class="input-group">
                                                        <input type="text" name="skill_from" id="skill_from" class="form-control datepicker" data-validate="required" data-message-required="Please enter starting date." data-mask="dd-mm-yyyy" data-format="dd-mm-yyyy" onchange="getMonths($('#skill_to').val(), this.value)">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">To</label>
                                                    <div class="input-group">
                                                        <input type="text" name="skill_to" id="skill_to" class="form-control datepicker" data-validate="required" data-mask="dd-mm-yyyy" data-message-required="Please enter ending date." data-format="dd-mm-yyyy" onchange="getMonths(this.value, $('#skill_from').val())">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">No of Months</label>
                                                    <input class="form-control" name="no_of_month" id="no_of_month" placeholder="Months" data-validate="required,number" data-message-required="Please enter months." disabled="disabled"/>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Training</label>
                                                    <input class="form-control" name="training" id="training" placeholder="Training" data-validate="required" data-message-required="Please enter training."/>
                                                </div>
                                            </div>

                                            <div class="col-md-4" style="margin-top:20px;">
                                                <button class="btn btn-primary" type="submit" id="skills_button" name="skills_button">Add</button>
                                                <button class="btn btn-default" type="reset">Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <table class="table table-bordered" id="edit_skill_table">
                                            <thead>
                                                <tr>
                                                    <th>Skill Name</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>No of Months</th>
                                                    <th>Training</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_skills > 0) {
                                                    foreach ($select_skills->result() as $row_skills) {
                                                        $skills_id = $row_skills->Skill_Id;
                                                        $skill_name = $row_skills->Skill_Name;
                                                        $skill_month = $row_skills->Months;
                                                        $skill_training = $row_skills->Training;
                                                        $from = $row_skills->Skill_From;
                                                        $skill_from = date("d-m-Y", strtotime($from));
                                                        $to = $row_skills->Skill_To;
                                                        $skill_to = date("d-m-Y", strtotime($to));
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $skill_name; ?></td>
                                                            <td><?php echo $skill_from; ?></td>
                                                            <td><?php echo $skill_to; ?></td>
                                                            <td><?php echo $skill_month; ?></td>
                                                            <td><?php echo $skill_training; ?></td>

                                                            <td>
                                                                <a data-toggle='modal' href='#edit_skills_details' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_skills_details(<?php echo $skills_id; ?>)">
                                                                    <i class="entypo-pencil"></i>
                                                                    Edit
                                                                </a>

                                                                <a data-toggle='modal' href='#delete_skills_details' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_skills_details(<?php echo $skills_id; ?>)">
                                                                    <i class="entypo-cancel"></i>
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <ul class="pager wizard">
                                        <li class="next">
                                            <a href="#">Next <i class="entypo-right-open"></i></a>
                                        </li>
                                    </ul>

                                </div>

                                <div class="tab-pane" id="tab5">
                                    <h3>Work Experience Details</h3>
                                    <form id="editemployeeexp_form" class="validate" method="post">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="addexp_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="addexp_success" class="alert alert-success" style="display:none;">Experience details added successfully.</div>
                                                <div id="addexp_error" class="alert alert-danger" style="display:none;">Failed to add experience details.</div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Company Name</label>
                                                    <input class="form-control" name="prev_company_name" id="prev_company_name" placeholder="Company Name" data-validate="required" data-message-required="Please enter company name." />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Location</label>
                                                    <input class="form-control" name="prev_company_location" id="prev_company_location" data-validate="required" data-message-required="Please enter location." />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Designation</label>
                                                    <input class="form-control" name="prev_designation" id="prev_designation" data-validate="required" data-message-required="Please enter designation." />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Date of Joined</label>
                                                    <div class="input-group">
                                                        <input type="text" name="prev_date_joined" id="prev_date_joined" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please enter date of joined.">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Date of Relieved</label>
                                                    <div class="input-group">
                                                        <input type="text" name="prev_date_relieved" id="prev_date_relieved" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please enter date of relieved." >
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Type</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="relevant_exp" name="relevant" value="relevant" checked>
                                                            <label>Relevant Experience</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="non_relevant_exp" name="relevant" value="non-relevant">
                                                            <label>Non-Relevant Experience</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Reason for Relieving</label>
                                                    <input type="text" class="form-control" name="prev_reason_relieving" id="prev_reason_relieving" data-validate="required" data-message-required="Please enter reason for relieving." >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Salary</label>
                                                    <input class="form-control" name="prev_salary" id="prev_salary" data-validate="required" data-message-required="Please enter salary." />
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="margin-top:20px;">
                                                <button class="btn btn-primary" type="submit" id="exp_button" name="exp_button">Add</button>
                                                <button class="btn btn-default" type="reset">Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <table class="table table-bordered" id="edit_exp_table">
                                            <thead>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Location</th>
                                                    <th>Designation</th>
                                                    <th>Date of Joined</th>
                                                    <th>Date of Relieved</th>
                                                    <th>Experience Type</th>
                                                    <th>Reason for Relieving</th>
                                                    <th>Salary</th>
                                                    <th>Experience</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $relevant_days = 0;
                                                $non_relevant_days = 0;
                                                $no_days = 0;
                                                if ($count_exp > 0) {
                                                    foreach ($select_exp->result() as $row_exp) {
                                                        $exp_id = $row_exp->Privious_Comp_ExpId;
                                                        $exp_companyname = $row_exp->Previouscompany;
                                                        $exp_companylocation = $row_exp->Privious_Comp_Location;
                                                        $exp_designation = $row_exp->Privious_Comp_Designation;
                                                        $exp_companysalary = $row_exp->Privious_Comp_Gross_Salray;
                                                        $ori_exp_companyjoined = $row_exp->Privious_Comp_Joineddate;
                                                        $exp_companyjoined = date("d-m-Y", strtotime($ori_exp_companyjoined));
                                                        $ori_exp_reliveddate = $row_exp->Privious_Comp_LeavedDate;
                                                        $exp_reliveddate = date("d-m-Y", strtotime($ori_exp_reliveddate));
                                                        $Privious_Comp_ExpType = $row_exp->Privious_Comp_ExpType;
                                                        $exp_companyreason = $row_exp->Privious_Comp_ReasonforLeaving;
                                                        $interval = date_diff(date_create($ori_exp_reliveddate), date_create($ori_exp_companyjoined));
                                                        $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                                                        $no_days = $no_days + $interval->format("%a");
                                                        if ($Privious_Comp_ExpType == 'relevant') {
                                                            $relevant_days = $relevant_days + $interval->format("%a");
                                                        }
                                                        if ($Privious_Comp_ExpType == 'non-relevant') {
                                                            $non_relevant_days = $non_relevant_days + $interval->format("%a");
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $exp_companyname; ?></td>
                                                            <td><?php echo $exp_companylocation; ?></td>
                                                            <td><?php echo $exp_designation; ?></td>
                                                            <td><?php echo $exp_companyjoined; ?></td>
                                                            <td><?php echo $exp_reliveddate; ?></td>
                                                            <td><?php echo $Privious_Comp_ExpType; ?></td>
                                                            <td><?php echo $exp_companyreason; ?></td>
                                                            <td><?php echo $exp_companysalary; ?></td>
                                                            <td><?php echo $subtotal_experience; ?></td>

                                                            <td>
                                                                <a data-toggle='modal' href='#edit_exp_details' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_exp_details(<?php echo $exp_id; ?>)">
                                                                    <i class="entypo-pencil"></i>
                                                                    Edit
                                                                </a>

                                                                <a data-toggle='modal' href='#delete_exp_details' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_exp_details(<?php echo $exp_id; ?>)">
                                                                    <i class="entypo-cancel"></i>
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        <?php
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="9" align="right">Relevant Experience </td>
                                                        <td>
                                                            <?php
                                                            $relevant_days_Y = floor($relevant_days / 365);
                                                            $relevant_days_M = floor(($relevant_days - (floor($relevant_days / 365) * 365)) / 30);
                                                            $relevant_days_D = $relevant_days - (($relevant_days_Y * 365) + ($relevant_days_M * 30));
                                                            echo $relevant_days_Y . " Years, " . $relevant_days_M . " Months";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9" align="right">Non-Relevant Experience </td>
                                                        <td>
                                                            <?php
                                                            $non_relevant_Y = floor($non_relevant_days / 365);
                                                            $non_relevant_M = floor(($non_relevant_days - (floor($non_relevant_days / 365) * 365)) / 30);
                                                            $non_relevant_D = $non_relevant_days - (($non_relevant_Y * 365) + ($non_relevant_M * 30));
                                                            echo $non_relevant_Y . " Years, " . $non_relevant_M . " Months";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9" align="right">Total Experience </td>
                                                        <td>
                                                            <?php
                                                            $Y = floor($no_days / 365);
                                                            $M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                                                            $D = $no_days - (($Y * 365) + ($M * 30));
                                                            echo $Y . " Years, " . $M . " Months";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                    <ul class="pager wizard">
                                        <li class="previous">
                                            <a href="#"><i class="entypo-left-open"></i> Previous</a>
                                        </li>

                                        <li class="next">
                                            <a href="#">Next <i class="entypo-right-open"></i></a>
                                        </li>
                                    </ul>

                                </div>

                                <div class="tab-pane" id="tab6">
                                    <h3>Additional Information</h3>
                                    <form id="editemployeeinfo_form" method="post" class="validate">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="editinfo_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="editinfo_success" class="alert alert-success" style="display:none;">Additional information updated successfully.</div>
                                                <div id="editinfo_error" class="alert alert-danger" style="display:none;">Failed to update additional details.</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Pan Card No</label>
                                                    <input class="form-control" name="pancard_no" id="pancard_no" placeholder="Pan Card No" data-validate="required" data-message-required="Please enter pan card number." value="<?php echo $Emp_PANcard; ?>"/>
                                                </div>
                                            </div>
                                            <input type="hidden" name="info_employee_id" id="info_employee_id" value="<?php echo $emp_no; ?>">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Aadhar Card No</label>
                                                    <input class="form-control" name="aadhar_no" id="aadhar_no" placeholder="Aadhar Card No"  value="<?php echo $Emp_Aadharcard; ?>" data-validate="number" data-message-required="Please enter valid aadhar card number." maxlength="12"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Passport No</label>
                                                    <input class="form-control" name="passport_no" id="passport_no" placeholder="Passport Number" value="<?php echo $Emp_Passportno; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Name On the Passport</label>
                                                    <input class="form-control" name="name_on_passport" id="name_on_passport" placeholder="Name" value="<?php echo $Emp_Passportname; ?>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Place of Issue</label>
                                                    <input class="form-control" name="place_issue" id="place_issue" placeholder="Place" value="<?php echo $Issue_Place; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Date of Issue</label>
                                                    <div class="input-group">
                                                        <input type="text" name="issue_date" id="issue_date" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $Issue_Date; ?>">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Date of Expiry</label>
                                                    <div class="input-group">
                                                        <input type="text" name="expiry_date" id="expiry_date" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $Expiry_Date; ?>">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="entypo-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Do you possess any valid visa?</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="valid_visa_no" name="valid_visa" value="No" <?php
                                                            if ($Valid_visa == "No") {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>No</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="valid_visa_yes" name="valid_visa" value="Yes" <?php
                                                            if ($Valid_visa == "Yes") {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Country of Issue</label>
                                                    <input class="form-control" name="issue_country" id="issue_country" placeholder="Country of Issue" value="<?php echo $Issue_Country; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Hobbies</label>
                                                    <input class="form-control" name="hobbies" id="hobbies" placeholder="Hobbies" value="<?php echo $Hobbies; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Interests</label>
                                                    <input class="form-control" name="interest" id="interest" placeholder="Interest" value="<?php echo $Intresets; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">	
                                                <div class="form-group">
                                                    <div class="col-md-12">	
                                                        <label class="control-label">Are you related to any of our employees?</label>
                                                    </div>
                                                    <div class="col-md-6">	
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="related_employee_no" onclick="show_employee(this.value)
                                                                            ;" name="other_emp_relation" value="No" <?php
                                                                   if ($related_emp == "No") {
                                                                       echo "checked";
                                                                   }
                                                                   ?>>
                                                            <label>No</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">	
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="related_employee_yes" onclick="show_employee(this.value)
                                                                            ;" name="other_emp_relation" value="Yes" <?php
                                                                   if ($related_emp == "Yes") {
                                                                       echo "checked";
                                                                   }
                                                                   ?>>
                                                            <label>Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <?php if ($related_emp == "Yes") { ?>
                                                <div class="col-md-3" id="related_emp_name_div">
                                                    <div class="form-group">
                                                        <label class="control-label">Employee Name</label>
                                                        <select name="related_employee_name" id="related_employee_name" class="round" data-validate="required" data-message-required="Please select employee name.">
                                                            <option value="<?php echo $related_emp_id; ?>"><?php echo $related_emp_name . "/" . $emp_code . $related_emp_id; ?></option>
                                                            <?php foreach ($select_related_emp_exp->result() as $row_related_emp_exp) { ?>
                                                                <option value="<?php echo $row_related_emp_exp->Emp_Number; ?>"><?php echo $row_related_emp_exp->Emp_FirstName . '- ' . $emp_code . $row_related_emp_exp->Emp_Number; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col-md-3" id="related_emp_name_div" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">Employee Name</label>
                                                        <select name="related_employee_name" id="related_employee_name" class="round" data-validate="required" data-message-required="Please select employee name.">
                                                            <option value="">Please Select</option>
                                                            <?php foreach ($select_rel_emp->result() as $row_rel_emp) { ?>
                                                                <option value="<?php echo $row_rel_emp->Emp_Number; ?>"><?php echo $row_rel_emp->Emp_FirstName . "/ " . $emp_code . $row_rel_emp->Emp_Number; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>


                                            <!--                                        <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Membership of any Professional Institution/Association</label>
                                                                                            <input class="form-control" name="membership" id="membership" placeholder="Membership" value="<?php echo $Membership; ?>"/>
                                                                                        </div>	
                                                                                    </div>-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Voter ID</label>
                                                    <input class="form-control" name="voter_id" id="voter_id" placeholder="Voter Id" value="<?php echo $voter_id; ?>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <h3>Emergency Details</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Allergic To</label>
                                                    <input class="form-control" name="allergic" id="allergic" placeholder="Allergic To" value="<?php echo $Alergic; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Blood Pressure</label>
                                                    <input class="form-control" name="blood_pressure" id="blood_pressure" placeholder="Blood Pressure" value="<?php echo $BloodPressure; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Disability</label>
                                                    <input class="form-control" name="differently_abled" id="differently_abled" placeholder="Disability" value="<?php echo $Differently_abled; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="control-label">Weight</label>
                                                    <input class="form-control" name="weight" id="weight" placeholder="Weight" value="<?php echo $Weight; ?>" data-validate="number"/>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="control-label">Height</label>
                                                    <input class="form-control" name="height" id="height" placeholder="Height" value="<?php echo $Height; ?>" data-validate="number"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Eye Sight</label>
                                                    <input class="form-control" name="eye_sight" id="eye_sight" placeholder="Eye Sight" value="<?php echo $Eye_Sight; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Any Major Illness</label>
                                                    <input class="form-control" name="illness" id="illness" placeholder="Illness" value="<?php echo $Major_Illeness; ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Contact Person in case of Emergency</label>
                                                    <input class="form-control" name="emergency_contactperson_name" id="emergency_contactperson_name" placeholder="Emergency Contact Person Name" value="<?php echo $Contact_Person; ?>" data-validate="required" data-message-required="Please enter contact person name."/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Contact Number</label>
                                                    <input class="form-control" name="emergency_contact_no" id="emergency_contact_no" placeholder="Contact Number" maxlength="15" data-validate="required,number" value="<?php echo $Mobileno; ?>" data-validate="required" data-message-required="Please enter contact person number."/>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="info_form_button" style="float: right;margin-bottom: 10px">
                                            <button type="submit" class="btn btn-white">Add Info</button>
                                        </div>

                                        <ul class="pager wizard" id="info_form_next" style="display:none">
                                            <li class="next">
                                                <a href="#">Next <i class="entypo-right-open"></i></a>
                                            </li>
                                        </ul>
                                    </form>
                                </div>

                                <div class="tab-pane" id="tab7">
                                    <h3>Attachment Information</h3>
                                    <form id="edit_attachment_form" class="validate" method="post">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="adddocument_server_error" style="display:none;color:red"></div>
                                                <div id="adddocument_success" class="alert alert-success" style="display:none;">File uploaded successfully.</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Document Type</label>
                                                    <select class="round" name="attach_type" id="attach_type" data-validate="required" data-message-required="Please select type." onchange="others(this.value)">
                                                        <option value="Resume">Resume</option>
														<option value="Mark Sheets">Mark Sheets</option>
														<option value="Offer Letter">Offer Letter</option>
														<option value="Confirmation Letter">Confirmation Letter</option>
														<option value="Appraisal Letter">Appraisal Letter</option>
														<option value="Experience Certificate">Experience Certificate</option>
														<option value="Relieving Letter">Relieving Letter</option>
														<option value="Full settlement letter">Full settlement letter</option>                                                        
														<option value="Last two months pay slips">Last two months pay slips</option>
														<option value="Bank Statement">Bank Statement</option>
														<option value="Photocopy of Passport">Photocopy of Passport</option>
														<option value="PAN Card">PAN Card</option>
														<option value="Aadhaar Card">Aadhaar Card</option>
														<option value="Ration Card">Ration Card</option>
														<option value="Voter id">Voter id</option>
														<option value="Driving License">Driving License</option>
														<option value="Blood Group">Blood Group</option>
														<option value="Proof of Birth">Proof of Birth</option>
														<option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $emp_no; ?>">
                                            <div class="col-md-3">
                                                <label class="control-label">Files</label>
                                                <input type="file" name="attach_file" id="attach_file" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse"/>
                                            </div>

                                            <div style="margin-top:20px;" class="col-md-3">
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </div>
                                        </div>
                                        <div class="row" id="other_text" style="display: none;margin-bottom: 20px">
                                            <div class="col-md-4">
                                                <label class="control-label">Type</label>
                                                <input type="text" name="other_type" id="other_type" class="form-control" data-validate="required" data-message-required="Please select type."/>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="row">
                                        <table class="table table-bordered" id="document_table">
                                            <thead>
                                                <tr>
                                                    <th>Document Type</th>
                                                    <th>Download</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_document > 0) {
                                                    foreach ($select_document->result() as $row_document) {
                                                        $document_id = $row_document->Document_Id;
                                                        $document_type = $row_document->Document_Name;
                                                        $file_name = $row_document->Files;
                                                        $file_url = "http://1.23.211.173/TEKES/upload/";
                                                        ?>
                                                        <!--<tr>
                                                            <td><?php //echo $document_type; ?></td>
                                                            <td><a id="test" href="<?php //echo $file_url . $file_name ?>" target="_blank"><i class="entypo-download"></i></a></td>
                                                        </tr>-->
														<tr>
                                                            <td><?php echo $document_type; ?></td>
                                                            <td><a href="<?php echo site_url('upload/' . $file_name) ?>" target="_blank">
                                                                <i class="entypo-download"></i></a>                    
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <ul class="pager wizard">
                                        <li class="next">
                                            <a href="#">Next <i class="entypo-right-open"></i></a>
                                        </li>
                                    </ul>

                                </div>


                                <div class="tab-pane" id="tab8">
                                    <div id="fresher_div">
                                        <h4>REFERENCES (2 PERSONAL NON-RELATIONAL CONTACTS)</h4>
                                        <form id="editemployeefresherreference_form" method="post" class="validate">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div id="addfresherref_server_error" class="alert alert-info" style="display:none;"></div>
                                                    <div id="addfresherref_success" class="alert alert-success" style="display:none;">Reference details added successfully.</div>
                                                    <div id="addfresherref_error" class="alert alert-danger" style="display:none;">Failed to add reference details.</div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="fresherref_employee_id" id="fresherref_employee_id" value="<?php echo $emp_no ?>">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Reference Person Name</label>
                                                        <input class="form-control" name="reference_person_name" id="reference_person_name" data-validate="required" data-message-required="Please enter name." />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Relationship</label>
                                                        <input class="form-control" name="reference_person_relation" id="reference_person_relation" data-validate="required" data-message-required="Please enter relationship." />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Occupation</label>
                                                        <input class="form-control" name="reference_person_occupation" id="reference_person_occupation" data-validate="required" data-message-required="Please enter occupation." />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Mobile Number</label>
                                                        <input class="form-control" name="reference_person_mobile" id="reference_person_mobile" data-validate="required,number" data-message-required="Please enter mobile number." maxlength="15"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Email Id</label>
                                                        <input class="form-control" name="reference_person_email" id="reference_person_email" data-validate="email" data-message-required="Please enter email address." />
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="margin-top:20px;">
                                                    <button class="btn btn-primary" type="submit" id="exp_button" name="exp_button">Add</button>
                                                    <button class="btn btn-default" type="reset">Clear</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <table class="table table-bordered" id="fresherref_table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Relationship</th>
                                                        <th>Occupation</th>
                                                        <th>Mobile Number</th>
                                                        <th>Email Id</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($count_fresherref > 0) {
                                                        foreach ($select_fresherref->result() as $row_fresherref) {
                                                            $fresherref_id = $row_fresherref->Fresher_RefId;
                                                            $fresherref_name = $row_fresherref->Name;
                                                            $fresherref_relationship = $row_fresherref->Relationship;
                                                            $fresherref_occupation = $row_fresherref->Occupation;
                                                            $fresherref_mobile = $row_fresherref->Mobile_Number;
                                                            $fresherref_email = $row_fresherref->Email_Id;
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $fresherref_name; ?></td>
                                                                <td><?php echo $fresherref_relationship; ?></td>
                                                                <td><?php echo $fresherref_occupation; ?></td>
                                                                <td><?php echo $fresherref_mobile; ?></td>
                                                                <td><?php echo $fresherref_email; ?></td>
                                                                <td>
                                                                    <a data-toggle='modal' href='#edit_fresherref_details' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_fresherref_details(<?php echo $fresherref_id; ?>)">
                                                                        <i class="entypo-pencil"></i>
                                                                        Edit
                                                                    </a>

                                                                    <a data-toggle='modal' href='#delete_fresherref_details' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_fresherref_details(<?php echo $fresherref_id; ?>)">
                                                                        <i class="entypo-cancel"></i>
                                                                        Delete
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div id="experience_div">
                                        <h4>PLEASE LIST 3 PROFESSIONAL REFERENCES (2 PROFESSIONAL AND PREVIOUS EMPLOYER/HR)</h4>
                                        <form id="editemployeereference_form" method="post" class="validate">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div id="addref_server_error" class="alert alert-info" style="display:none;"></div>
                                                    <div id="addref_success" class="alert alert-success" style="display:none;">Experience details added successfully.</div>
                                                    <div id="addref_error" class="alert alert-danger" style="display:none;">Failed to add experience details.</div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="ref_employee_id" id="ref_employee_id" value="<?php echo $emp_no ?>">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Reporting Manager Name</label>
                                                        <input class="form-control" name="prev_cmpref_fullname" id="prev_cmpref_fullname" data-validate="required" data-message-required="Please enter name." />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Company Name</label>
                                                        <input class="form-control" name="prev_cmpref_name" id="prev_cmpref_name" placeholder="Company Name" data-validate="required" data-message-required="Please enter company name." />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Designation</label>
                                                        <input class="form-control" name="prev_cmpref_designation" id="prev_cmpref_designation" data-validate="required" data-message-required="Please enter designation." />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Professional Email Id</label>
                                                        <input class="form-control" name="prev_cmpref_email" id="prev_cmpref_email" data-validate="email" data-message-required="Please enter email address." />
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Mobile Number</label>
                                                        <input class="form-control" name="prev_cmpref_mobile" id="prev_cmpref_mobile" data-validate="required,number" data-message-required="Please enter mobile number." maxlength="15"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Telephone Number</label>
                                                        <input class="form-control" name="prev_cmpref_telephone" id="prev_cmpref_telephone" data-validate="number" data-message-required="Please enter telephone number." maxlength="15"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="margin-top:20px;">
                                                    <button class="btn btn-primary" type="submit" id="exp_button" name="exp_button">Add</button>
                                                    <button class="btn btn-default" type="reset">Clear</button>
                                                </div>
                                               
                                            </div>

                                        </form>

                                    </div>
                                    <div class="row">
                                        <table class="table table-bordered" id="ref_table">
                                            <thead>
                                                <tr>
                                                    <th>Reporting Manager Name</th>
                                                    <th>Company Name</th>
                                                    <th>Designation</th>
                                                    <th>Professional Email Id</th>
                                                    <th>Mobile Number</th>
                                                    <th>Telephone Number</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_ref > 0) {
                                                    foreach ($select_ref->result() as $row_ref) {
                                                        $ref_id = $row_ref->Ref_Id;
                                                        $ref_fullname = $row_ref->Privious_Comp_FullName;
                                                        $ref_companyname = $row_ref->Privious_Comp_Name;
                                                        $ref_designation = $row_ref->Privious_Comp_Designation;
                                                        $ref_email = $row_ref->Privious_Comp_Email;
                                                        $ref_mobile = $row_ref->Privious_Comp_Mobile;
                                                        $ref_telephone = $row_ref->Privious_Comp_Telephone;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $ref_fullname; ?></td>
                                                            <td><?php echo $ref_companyname; ?></td>
                                                            <td><?php echo $ref_designation; ?></td>
                                                            <td><?php echo $ref_email; ?></td>
                                                            <td><?php echo $ref_mobile; ?></td>
                                                            <td><?php echo $ref_telephone; ?></td>
                                                            <td>
                                                                <a data-toggle='modal' href='#edit_ref_details' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_ref_details(<?php echo $ref_id; ?>)">
                                                                    <i class="entypo-pencil"></i>
                                                                    Edit
                                                                </a>

                                                                <a data-toggle='modal' href='#delete_ref_details' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_ref_details(<?php echo $ref_id; ?>)">
                                                                    <i class="entypo-cancel"></i>
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
										 <ul class="pager wizard">
                                    <li class="next">
                                        <a href="#">Next <i class="entypo-right-open"></i></a>
                                    </li>
                                </ul>
                                    </div>
                                    <?php if ($user_role != 3) { ?>
                                        <div class="row">
                                            <div class="col-md-4">	
                                                <div class="form-group">
                                                    <div class="col-md-12">	
                                                        <label class="control-label">Background Verification</label>
                                                    </div>
                                                    <input type="hidden" name="bgverify_employee_id" id="bgverify_employee_id" value="<?php echo $emp_no ?>">
                                                    <div class="col-md-6">	
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="background_verification_no" name="background_verification" value="No" <?php
                                                            if ($bg_verify == "No") {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>No</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">	
                                                        <div class="radio radio-replace">
                                                            <input type="radio" id="background_verification_yes" name="background_verification" value="Yes" <?php
                                                            if ($bg_verify == "Yes") {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <ul class="pager wizard">
                                            <li class="next">
                                                <a href="#" id="background_button">Finish</a>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </div>

                                <div class="tab-pane" id="tab9">
                                    <h3>Personal Details</h3>
                                    <div class="row">
                                        <table class="table table-bordered" id="edit_lang_table1">
                                            <thead>
                                                <tr>
                                                    <th>Language</th>
                                                    <th>Read</th>
                                                    <th>Speak</th>
                                                    <th>Write</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_lang > 0) {
                                                    foreach ($select_lang->result() as $row_lang) {
                                                        $lang_id = $row_lang->Lang_Id;
                                                        $lang_name = $row_lang->Lang_Name;
                                                        $lang_read = $row_lang->Lang_Read;
                                                        $lang_speak = $row_lang->Lang_Speak;
                                                        $lang_write = $row_lang->Lang_Write;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $lang_name; ?></td>
                                                            <td><?php echo $lang_read; ?></td>
                                                            <td><?php echo $lang_speak; ?></td>
                                                            <td><?php echo $lang_write; ?></td>
                                                        </tr>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <table class="table table-bordered" id="edit_personalinfo_table1">
                                            <tbody>
                                                <tr>
                                                    <td><b>Nationality :</b></td>
                                                    <td><?php echo $Emp_Nationality; ?></td>
                                                    <td><b>Religion :</b> </td>
                                                    <td><?php echo $Emp_Religion; ?></td>
                                                    <td><b>Caste : </b></td>
                                                    <td><?php echo $Emp_Caste; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Mother Tongue :</b></td>
                                                    <td><?php echo $Emp_Mother_Tongue; ?></td>
                                                    <td><b>Blood Group :</b> </td>
                                                    <td><?php echo $blood_group; ?></td>
                                                    <td><b>Date of Birth : </b></td>
                                                    <td><?php echo $dob; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Actual Date of Birth :</b></td>
                                                    <td><?php echo $actual_dob; ?></td>
                                                    <td><b>Marital Status :</b> </td>
                                                    <td><?php echo $Emp_Marrial; ?></td>
                                                    <td><b>Mobile Number  : </b></td>
                                                    <td><?php echo $Emp_Contact; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Alternate Number :</b></td>
                                                    <td colspan="2"><?php echo $Emp_AlternateContact; ?></td>
                                                    <td><b>Personal Email Address :</b> </td>
                                                    <td colspan="2"><?php echo $Emp_PersonalEmail; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Permanent Address  : </b></td>
                                                    <td colspan="2"><?php echo $Emp_Permanent; ?></td>
                                                    <td><b>Temporary Address :</b></td>
                                                    <td colspan="2"><?php echo $Emp_Temporary; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h3>Family Details</h3>

                                    <div class="row">
                                        <table class="table table-bordered" id="edit_family_table1">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>DOB</th>
                                                    <th>Age</th>
                                                    <th>Relationship</th>
                                                    <th>Gender</th>
                                                    <th>Occupation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_family > 0) {
                                                    foreach ($select_family->result() as $row_family) {
                                                        $family_id = $row_family->Family_Id;
                                                        $family_name = $row_family->Name;
                                                        $family_age = $row_family->Age;
                                                        $family_dateofbirth = $row_family->DOB;
                                                        $family_dob = date("d-m-Y", strtotime($family_dateofbirth));
                                                        $family_relation = $row_family->Relationship;
                                                        $family_gender = $row_family->Gender;
                                                        $family_occupation = $row_family->Occupation;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $family_name; ?></td>
                                                            <td><?php echo $family_dob; ?></td>
                                                            <td><?php echo $family_age; ?></td>
                                                            <td><?php echo $family_relation; ?></td>
                                                            <td><?php echo $family_gender; ?></td>
                                                            <td><?php echo $family_occupation; ?></td>

                                                        </tr>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h3>Educational Details</h3>

                                    <div class="row">
                                        <table class="table table-bordered" id="edit_education_table1">
                                            <thead>
                                                <tr>
                                                    <th>Qualification</th>
                                                    <th>University</th>
                                                    <th>College Name</th>
                                                    <th>Major Subject</th>
                                                    <th>% Marks</th>
                                                    <th>Year</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_education > 0) {
                                                    foreach ($select_education->result() as $row_education) {
                                                        $education_id = $row_education->Emp_QualificationId;
                                                        $education_coursename = $row_education->Course_Name;
                                                        $education_university = $row_education->University;
                                                        $education_collegename = $row_education->College_Name;
                                                        $education_marks = $row_education->Marks;
                                                        $education_subject = $row_education->Major_Subject;
                                                        $year = $row_education->Year;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $education_coursename; ?></td>
                                                            <td><?php echo $education_university; ?></td>
                                                            <td><?php echo $education_collegename; ?></td>
                                                            <td><?php echo $education_subject; ?></td>
                                                            <td><?php echo $education_marks; ?></td>
                                                            <td><?php echo $year; ?></td>

                                                        </tr>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h3>Skills Information</h3>

                                    <div class="row">
                                        <table class="table table-bordered" id="edit_skill_table1">
                                            <thead>
                                                <tr>
                                                    <th>Skill Name</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>No of Months</th>
                                                    <th>Training</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_skills > 0) {
                                                    foreach ($select_skills->result() as $row_skills) {
                                                        $skills_id = $row_skills->Skill_Id;
                                                        $skill_name = $row_skills->Skill_Name;
                                                        $skill_month = $row_skills->Months;
                                                        $skill_training = $row_skills->Training;
                                                        $from = $row_skills->Skill_From;
                                                        $skill_from = date("d-m-Y", strtotime($from));
                                                        $to = $row_skills->Skill_To;
                                                        $skill_to = date("d-m-Y", strtotime($to));
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $skill_name; ?></td>
                                                            <td><?php echo $skill_from; ?></td>
                                                            <td><?php echo $skill_to; ?></td>
                                                            <td><?php echo $skill_month; ?></td>
                                                            <td><?php echo $skill_training; ?></td>

                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h3>Work Experience Details</h3>

                                    <div class="row">
                                        <table class="table table-bordered" id="edit_exp_table1">
                                            <thead>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Location</th>
                                                    <th>Designation</th>
                                                    <th>Date of Joined</th>
                                                    <th>Date of Relieved</th>
                                                    <th>Experience Type</th>
                                                    <th>Reason for Relieving</th>
                                                    <th>Salary</th>
                                                    <th>Experience</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $relevant_days = 0;
                                                $non_relevant_days = 0;
                                                $no_days = 0;
                                                if ($count_exp > 0) {
                                                    foreach ($select_exp->result() as $row_exp) {
                                                        $exp_id = $row_exp->Privious_Comp_ExpId;
                                                        $exp_companyname = $row_exp->Previouscompany;
                                                        $exp_companylocation = $row_exp->Privious_Comp_Location;
                                                        $exp_designation = $row_exp->Privious_Comp_Designation;
                                                        $exp_companysalary = $row_exp->Privious_Comp_Gross_Salray;
                                                        $ori_exp_companyjoined = $row_exp->Privious_Comp_Joineddate;
                                                        $exp_companyjoined = date("d-m-Y", strtotime($ori_exp_companyjoined));
                                                        $ori_exp_reliveddate = $row_exp->Privious_Comp_LeavedDate;
                                                        $exp_reliveddate = date("d-m-Y", strtotime($ori_exp_reliveddate));
                                                        $Privious_Comp_ExpType = $row_exp->Privious_Comp_ExpType;
                                                        $exp_companyreason = $row_exp->Privious_Comp_ReasonforLeaving;
                                                        $interval = date_diff(date_create($ori_exp_reliveddate), date_create($ori_exp_companyjoined));
                                                        $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                                                        $no_days = $no_days + $interval->format("%a");
                                                        if ($Privious_Comp_ExpType == 'relevant') {
                                                            $relevant_days = $relevant_days + $interval->format("%a");
                                                        }
                                                        if ($Privious_Comp_ExpType == 'non-relevant') {
                                                            $non_relevant_days = $non_relevant_days + $interval->format("%a");
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $exp_companyname; ?></td>
                                                            <td><?php echo $exp_companylocation; ?></td>
                                                            <td><?php echo $exp_designation; ?></td>
                                                            <td><?php echo $exp_companyjoined; ?></td>
                                                            <td><?php echo $exp_reliveddate; ?></td>
                                                            <td><?php echo $Privious_Comp_ExpType; ?></td>
                                                            <td><?php echo $exp_companyreason; ?></td>
                                                            <td><?php echo $exp_companysalary; ?></td>
                                                            <td><?php echo $subtotal_experience; ?></td>
                                                        </tr>

                                                        <?php
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="8" align="right">Relevant Experience </td>
                                                        <td>
                                                            <?php
                                                            $relevant_days_Y = floor($relevant_days / 365);
                                                            $relevant_days_M = floor(($relevant_days - (floor($relevant_days / 365) * 365)) / 30);
                                                            $relevant_days_D = $relevant_days - (($relevant_days_Y * 365) + ($relevant_days_M * 30));
                                                            echo $relevant_days_Y . " Years, " . $relevant_days_M . " Months";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" align="right">Non-Relevant Experience </td>
                                                        <td>
                                                            <?php
                                                            $non_relevant_Y = floor($non_relevant_days / 365);
                                                            $non_relevant_M = floor(($non_relevant_days - (floor($non_relevant_days / 365) * 365)) / 30);
                                                            $non_relevant_D = $non_relevant_days - (($non_relevant_Y * 365) + ($non_relevant_M * 30));
                                                            echo $non_relevant_Y . " Years, " . $non_relevant_M . " Months";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" align="right">Total Experience </td>
                                                        <td>
                                                            <?php
                                                            $Y = floor($no_days / 365);
                                                            $M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                                                            $D = $no_days - (($Y * 365) + ($M * 30));
                                                            echo $Y . " Years, " . $M . " Months";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                    <h3>Additional Information</h3>

                                    <div class="row">
                                        <table class="table table-bordered" id="edit_additional_table1">
                                            <tbody>
                                                <tr>
                                                    <td><b>Pan Card No : </b></td>
                                                    <td><?php echo $Emp_PANcard; ?></td>
                                                    <td><b>Aadhar Card No : </b></td>
                                                    <td><?php echo $Emp_Aadharcard; ?></td>
                                                    <td><b>Passport No : </b></td>
                                                    <td><?php echo $Emp_Passportno; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Name On the Passport : </b></td>
                                                    <td><?php echo $Emp_Passportname; ?></td>
                                                    <td><b>Place of Issue : </b></td>
                                                    <td><?php echo $Issue_Place; ?></td>
                                                    <td><b>Date of Issue : </b></td>
                                                    <td><?php echo $Issue_Date; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Date of Expiry : </b></td>
                                                    <td><?php echo $Expiry_Date; ?></td>
                                                    <td><b>Do you possess any valid visa? </b></td>
                                                    <td><?php
                                                if ($Valid_visa == "No") {
                                                    echo "No";
                                                } else {
                                                    echo "Yes";
                                                }
                                                ?></td>
                                                    <td><b>Country of Issue : </b></td>
                                                    <td><?php echo $Issue_Country; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Hobbies : </b></td>
                                                    <td><?php echo $Hobbies; ?></td>
                                                    <td><b>Interests : </b></td>
                                                    <td><?php echo $Intresets; ?></td>
                                                     <td><b>Are you related to any of our employees? </b></td>
                                                   <td><?php
                                                if ($related_emp == "Yes") {
                                                    //echo $row_related_emp_exp->Emp_FirstName . '- ' . $emp_code . $row_related_emp_exp->Emp_Number;
                                                     echo $related_emp_name . "- " . $emp_code . $related_emp_id; 
                                                } else {
                                                    echo "No";
                                                }
                                                ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Voter ID : </b></td>
                                                    <td><?php echo $voter_id; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h3>Emergency Details</h3>
                                    <div class="row">
                                          <table class="table table-bordered" id="edit_emergency_table1">
                                            <tbody>
                                                <tr>
                                                    <td><b>Allergic To : </b></td>
                                                    <td><?php echo $Alergic; ?></td>
                                                    <td><b>Blood Pressure : </b></td>
                                                    <td><?php echo $BloodPressure; ?></td>
                                                    <td><b>Differently Abled : </b></td>
                                                    <td><?php echo $Differently_abled; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Weight : </b></td>
                                                    <td><?php echo $Weight; ?></td>
                                                    <td><b>Height : </b></td>
                                                    <td><?php echo $Height; ?></td>
                                                    <td><b>Eye Sight : </b></td>
                                                    <td><?php echo $Eye_Sight; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Any Major Illness : </b></td>
                                                    <td><?php echo $Major_Illeness; ?></td>
                                                    <td><b>Contact Person in case of Emergency : </b></td>
                                                    <td><?php echo $Contact_Person; ?></td>
                                                    <td><b>Contact Number : </b></td>
                                                    <td><?php echo $Mobileno; ?></td>
                                                </tr>
                                            </tbody>
                                          </table>
                                    </div>

                                    <h3>References (2 Personal Non-Relational Contacts)</h3>

                                    <div class="row">
                                        <table class="table table-bordered" id="edit_fresher_reference_table1">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Relationship</th>
                                                    <th>Occupation</th>
                                                    <th>Mobile Number</th>
                                                    <th>Email Id</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_fresherref > 0) {
                                                    foreach ($select_fresherref->result() as $row_fresherref) {
                                                        $fresherref_id = $row_fresherref->Fresher_RefId;
                                                        $fresherref_name = $row_fresherref->Name;
                                                        $fresherref_relationship = $row_fresherref->Relationship;
                                                        $fresherref_occupation = $row_fresherref->Occupation;
                                                        $fresherref_mobile = $row_fresherref->Mobile_Number;
                                                        $fresherref_email = $row_fresherref->Email_Id;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $fresherref_name; ?></td>
                                                            <td><?php echo $fresherref_relationship; ?></td>
                                                            <td><?php echo $fresherref_occupation; ?></td>
                                                            <td><?php echo $fresherref_mobile; ?></td>
                                                            <td><?php echo $fresherref_email; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h3>Professional References (2 Professional And Previous Employer/HR)</h3>

                                    <div class="row">
                                        <table class="table table-bordered" id="edit_exp_reference_table1">
                                            <thead>
                                                <tr>
                                                    <th>Reporting Manager Name</th>
                                                    <th>Company Name</th>
                                                    <th>Designation</th>
                                                    <th>Professional Email Id</th>
                                                    <th>Mobile Number</th>
                                                    <th>Telephone Number</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count_ref > 0) {
                                                    foreach ($select_ref->result() as $row_ref) {
                                                        $ref_id = $row_ref->Ref_Id;
                                                        $ref_fullname = $row_ref->Privious_Comp_FullName;
                                                        $ref_companyname = $row_ref->Privious_Comp_Name;
                                                        $ref_designation = $row_ref->Privious_Comp_Designation;
                                                        $ref_email = $row_ref->Privious_Comp_Email;
                                                        $ref_mobile = $row_ref->Privious_Comp_Mobile;
                                                        $ref_telephone = $row_ref->Privious_Comp_Telephone;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $ref_fullname; ?></td>
                                                            <td><?php echo $ref_companyname; ?></td>
                                                            <td><?php echo $ref_designation; ?></td>
                                                            <td><?php echo $ref_email; ?></td>
                                                            <td><?php echo $ref_mobile; ?></td>
                                                            <td><?php echo $ref_telephone; ?></td>

                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php
// $current_user = $this->session->userdata('username');
                                    if ($current_user == $emp_no) {
                                        ?>
                                        <form class="validate" id="aknowledgement_form">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div id="acknowledgment_success" class="alert alert-success" style="display:none;">All information updated successfully.</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="checkbox_outer">
                                                    <input id="condition_agree" type="checkbox" name="condition_agree"><span></span>
                                                </div> 
                                                <div class="col-md-12">
                                                    I hereby acknowledge that the above mentioned details are true, complete and correct to my knowledge. I agree
                                                    in case the company or its Background check service provider/s finds at any time, the information given by me in
                                                    this application form is not correct, true or complete, the company will have the right to withdraw the letter of
                                                    appointment before I join services or terminate my appointment at any time without notice or compensat ion after
                                                </div>
                                                <div class="col-md-12">
                                                    <p id="acknowledgment_error" style="display:none;color:red">Please check acknowledgment</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div style="float: right;margin-bottom: 10px;">
                                                    <button class="btn btn-primary" type="submit">Finish</button>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } ?>

                                </div>

                            </div>

                    </div>
                </div>
        </section>

        <!-- Delete Language Start Here -->

        <div class="modal fade" id="delete_lang_details">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Language</h3>
                    </div>
                    <form role="form" id="delete_lang_details_form" name="delete_lang_details_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Language End Here -->

        <!-- Edit Family Start Here -->

        <div class="modal fade custom-width" id="edit_family_details">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Family Details</h3>
                    </div>
                    <form role="form" id="edit_family_details_form" name="edit_family_details_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Family End Here -->

        <!-- Delete Family Start Here -->

        <div class="modal fade" id="delete_family_details">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Family Details</h3>
                    </div>
                    <form role="form" id="delete_family_details_form" name="delete_family_details_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Family End Here -->

        <!-- Edit Education Start Here -->

        <div class="modal fade custom-width" id="edit_edu_details">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Education Details</h3>
                    </div>
                    <form role="form" id="edit_edu_details_form" name="edit_edu_details_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Education End Here -->

        <!-- Delete Education Start Here -->

        <div class="modal fade" id="delete_edu_details">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Education Details</h3>
                    </div>
                    <form role="form" id="delete_edu_details_form" name="delete_edu_details_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Education End Here -->


        <!-- Edit Skills Start Here -->

        <div class="modal fade custom-width" id="edit_skills_details">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Skills Details</h3>
                    </div>
                    <form role="form" id="edit_skills_details_form" name="edit_skills_details_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Skills End Here -->

        <!-- Delete Skills Start Here -->

        <div class="modal fade" id="delete_skills_details">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Skills Details</h3>
                    </div>
                    <form role="form" id="delete_skills_details_form" name="delete_skills_details_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Skills End Here -->

        <!-- Edit Experience Start Here -->

        <div class="modal fade custom-width" id="edit_exp_details">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Experience Details</h3>
                    </div>
                    <form role="form" id="edit_exp_details_form" name="edit_exp_details_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Experience End Here -->

        <!-- Delete Experience Start Here -->

        <div class="modal fade" id="delete_exp_details">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Experience Details</h3>
                    </div>
                    <form role="form" id="delete_exp_details_form" name="delete_exp_details_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Skills End Here -->


        <!-- Edit Fresher Reference Start Here -->

        <div class="modal fade custom-width" id="edit_fresherref_details">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Reference Details</h3>
                    </div>
                    <form role="form" id="edit_fresherref_details_form" name="edit_fresherref_details_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Fresher Reference End Here -->

        <!-- Delete Fresher Reference Start Here -->

        <div class="modal fade" id="delete_fresherref_details">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Reference Details</h3>
                    </div>
                    <form role="form" id="delete_fresherref_details_form" name="delete_fresherref_details_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Fresher Reference End Here -->

        <!-- Edit Reference Start Here -->

        <div class="modal fade custom-width" id="edit_ref_details">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Reference Details</h3>
                    </div>
                    <form role="form" id="edit_ref_details_form" name="edit_ref_details_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Reference End Here -->

        <!-- Delete Reference Start Here -->

        <div class="modal fade" id="delete_ref_details">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Reference Details</h3>
                    </div>
                    <form role="form" id="delete_ref_details_form" name="delete_ref_details_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Reference End Here -->

