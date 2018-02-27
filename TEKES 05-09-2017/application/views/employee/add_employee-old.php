<?php
$this->db->order_by('id', 'desc');
$this->db->limit(1);
$q_empcode = $this->db->get('tbl_emp_code');
foreach ($q_empcode->result() as $row_empcode) {
    $emp_code = $row_empcode->employee_code;
    $start_number = $row_empcode->employee_number;
    $emp_id = str_pad(($start_number + 1), 4, '0', STR_PAD_LEFT);
}

$this->db->where('Status', 1);
$select_company = $this->db->get('tbl_company');

$this->db->where('Status', 1);
$select_branch = $this->db->get('tbl_branch');

$this->db->where('Status', 1);
$select_report = $this->db->get('tbl_employee');

$data_family = array(
    'Employee_Id' => $emp_id,
    'Status' => 1
);
$this->db->where($data_family);
$select_family = $this->db->get('tbl_employee_family');
$count_family = $select_family->num_rows();

$data_education = array(
    'Employee_ID' => $emp_id,
    'Status' => 1
);
$this->db->where($data_education);
$select_education = $this->db->get('tbl_employee_educationdetails');
$count_education = $select_education->num_rows();

$data_exp = array(
    'Employee_Id' => $emp_id,
    'Status' => 1
);
$this->db->where($data_exp);
$select_exp = $this->db->get('tbl_employee_expdetails');
$count_exp = $select_exp->num_rows();

$this->db->where('Employee_Id', $emp_id);
$select_document = $this->db->get('tbl_employee_documents');
$count_document = $select_document->num_rows();

$data_skills = array(
    'Employee_Id' => $emp_id,
    'Status' => 1
);
$this->db->where($data_skills);
$select_skills = $this->db->get('tbl_employee_skills');
$count_skills = $select_skills->num_rows();

$data_lang = array(
    'Employee_Id' => $emp_id,
    'Status' => 1
);
$this->db->where($data_lang);
$this->db->where('Employee_Id', $emp_id);
$select_lang = $this->db->get('tbl_employee_language');
$count_lang = $select_lang->num_rows();

$data_ref_fresher = array(
    'Employee_Id' => $emp_id,
    'Status' => 1
);
$this->db->where($data_ref_fresher);
$select_fresherref = $this->db->get('tbl_employee_fresherref');
$count_fresherref = $select_fresherref->num_rows();

$data_ref_Exp = array(
    'Employee_Id' => $emp_id,
    'Status' => 1
);
$this->db->where($data_ref_Exp);
$select_ref = $this->db->get('tbl_employee_referencedetails');
$count_ref = $select_ref->num_rows();
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
</script>

<script src="<?php echo site_url('js/jspdfmin.js') ?>"></script>

<script>

    var doc = new jsPDF();
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };


    function download_pdf() {
        doc.fromHTML($('#content').html(), 15, 15, {
            'width': 170,
            'elementHandlers': specialElementHandlers
        });
        doc.save('introduction.pdf');
    }


    function showDepartment(sel) {
        var branch_id = sel.options[sel.selectedIndex].value;
        if (branch_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_department') ?>",
                data: "branch_id=" + branch_id,
                cache: false,
                success: function (html) {
                    $("#add_emp_department").html(html);
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
                    $("#add_emp_client").html(html);
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
                    $("#add_emp_subprocess").html(html);
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
                    $("#add_emp_designation").html(html);
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
                    $("#add_emp_grade").html(html);
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
                    $("#add_emp_departmentrole").html(html);
                }
            });
        }
    }

</script>

<script>

    function show_employee(emp_status) {
        if (emp_status == "Yes") {
            $('#related_emp_name_div').show();
        } else {
            $('#related_emp_name_div').hide();
        }
    }
    function show_bgverify(bg_status) {
        if (bg_status == "Fresher") {
            $('#experience_div').hide();
            $('#fresher_div').show();
        } else {
            $('#fresher_div').hide();
            $('#experience_div').show();
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
        if (document.getElementById('same').checked) {
            document.getElementById('temporary_address').value = permanent;
        } else {
            document.getElementById('temporary_address').value = "";
        }
    }
</script>

<script>
    $(document).ready(function () {

        $('#addemployeebasic_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#employee_id').val();
            var employee_code = $('#employee_code').val();
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

            var company_name = $('#add_emp_company').val();
            var branch_name = $('#add_emp_branch').val();
            var department_name = $('#add_emp_department').val();
            var client_name = $('#add_emp_client').val();
            var add_emp_subprocess = $('#add_emp_subprocess').val();
            var designation_name = $('#add_emp_designation').val();
            var department_role = $('#add_emp_departmentrole').val();
            var grade = $('#add_emp_grade').val();
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
                employee_code: employee_code,
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
                subprocess: add_emp_subprocess,
                designation_name: designation_name,
                department_role: department_role,
                grade: grade,
                reporting_to: reporting_to,
                joining_date: joining_date,
                confirmation_period: confirmation_period,
                confirmation_date: confirmation_date
            };
            $.ajax({
                url: "<?php echo site_url('Employee/basicInfo') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addbasicinfo_error').show();
                    }
                    if (msg == 'success') {
                        $('#addbasicinfo_error').hide();
                        $('#basic_form_button').hide();
                        $('#basic_form_next').show();
                        $('#addbasicinfo_success').show();
                        document.getElementById('lang_employee_id').value = employee_id;
                        document.getElementById('personal_info_employee_id').value = employee_id;
                        document.getElementById('family_employee_id').value = employee_id;
                        document.getElementById('education_employee_id').value = employee_id;
                        document.getElementById('skills_employee_id').value = employee_id;
                        document.getElementById('exp_employee_id').value = employee_id;
                        document.getElementById('info_employee_id').value = employee_id;
                        document.getElementById('attachment_employee_id').value = employee_id;
                        document.getElementById('bgverify_employee_id').value = employee_id;
                        document.getElementById('ref_employee_id').value = employee_id;
                        document.getElementById('fresherref_employee_id').value = employee_id;

                    }

                }

            });
        });

        $('#addemployeepersonal_form').submit(function (e) {
            e.preventDefault();
            var employee_id = $('#personal_info_employee_id').val();
            var nationality = $('#nationality').val();
            var religion = $('#religion').val();
            var caste = $('#caste').val();
            var mother_tongue = $('#mother_tongue').val();
            var marital_status = $('#marital_status').val();

            var personal_blood_group = $('#personal_blood_group').val();
            var personal_birthdate = $('#personal_birthdate').val();
            var personal_actual_birthdate = $('#personal_actual_birthdate').val();

            var mobile_number = $('#emp_mobile_number').val();
            var alternate_number = $('#emp_alternate_number').val();
            var personal_email_address = $('#personal_email_address').val();
            var official_email_address = $('#official_email_address').val();
            var permanent_address = $('#permanent_address').val();
            var temporary_address = $('#temporary_address').val();

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
                url: "<?php echo site_url('Employee/personalInfo') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addpersonalinfo_error').show();
                    }
                    if (msg == 'success') {
                        $('#addpersonalinfo_error').hide();
                        $('#personal_form_button').hide();
                        $('#personal_form_next').show();
                        $('#addpersonalinfo_success').show();

                    }

                }

            });
        });

        $('#addemployeelang_form').submit(function (e) {
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
                        $("div").removeClass("checked");
                        $('#addlang_success').show();
                        // setInterval(function () {
                        $('#lang_table').load(location.href + ' #lang_table tr');
                        // }, 500);
                        //$('#lang_table tr:last').after('<tr><td>' + lang_name + '</td><td>' + lang_read + '</td><td>' + lang_speak + '</td><td>' + lang_write + '</td></tr>');
                    }

                }

            });
        });


        $('#addemployeefamily_form').submit(function (e) {
            e.preventDefault();
            var gender;
            if (document.getElementById("relation_male_gender").checked) {
                gender = document.getElementById("relation_male_gender").value;
            } else {
                gender = document.getElementById("relation_female_gender").value;
            }
            var employee_id = $('#family_employee_id').val();
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
                        //  setInterval(function () {
                        $('#family_table').load(location.href + ' #family_table tr');
                        //   }, 500);
                        // $('#family_table tr:last').after('<tr><td>' + family_member_name + '</td><td>' + family_member_dob + '</td><td>' + family_member_age + '</td><td>' + family_member_relationship + '</td><td>' + gender + '</td><td>' + family_member_occupation + '</td></tr>');
                    }

                }

            });
        });

        $('#addemployeeeducation_form').submit(function (e) {
            e.preventDefault();

            var employee_id = $('#education_employee_id').val();
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
                        // setInterval(function () {
                        $('#education_table').load(location.href + ' #education_table tr');
                        //  }, 500);
                        // $('#education_table tr:last').after('<tr><td>' + qualification + '</td><td>' + university_name + '</td><td>' + college_name + '</td><td>' + major_subject + '</td><td>' + marks + '</td><td>' + year_of_passing + '</td></tr>');
                    }

                }

            });
        });

        $('#addemployeeskills_form').submit(function (e) {
            e.preventDefault();

            var employee_id = $('#skills_employee_id').val();
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
                        // setInterval(function () {
                        $('#skill_table').load(location.href + ' #skill_table tr');
                        //  }, 500);
                        //  $('#skill_table tr:last').after('<tr><td>' + skill_name + '</td><td>' + no_of_month + '</td><td>' + training + '</td><td>' + skill_from + '</td><td>' + skill_to + '</td></tr>');
                    }

                }

            });
        });

        $('#addemployeeexp_form').submit(function (e) {
            e.preventDefault();

            var employee_id = $('#exp_employee_id').val();
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
                    // alert(msg);
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
                        // setInterval(function () {
                        $('#exp_table').load(location.href + ' #exp_table tr');
                        //  }, 500);
                        //  $('#exp_table tr:last').after('<tr><td>' + prev_company_name + '</td><td>' + prev_company_location + '</td><td>' + prev_designation + '</td><td>' + prev_date_joined + '</td><td>' + prev_date_relieved + '</td><td>' + relevant_exp + '</td><td>' + prev_reason_relieving + '</td><td>' + prev_salary + '</td></tr>');
                    }
                }
            });
        });

        $('#addemployeeinfo_form').submit(function (e) {
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
            // var membership = $('#membership').val();
            //  var other = $('#other').val();
            var voter_id = $('#voter_id').val();


            var allergic = $('#allergic').val();
            var blood_pressure = $('#blood_pressure').val();
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
                weight: weight,
                height: height,
                eye_sight: eye_sight,
                illness: illness,
                emergency_contactperson_name: emergency_contactperson_name,
                emergency_contact_no: emergency_contact_no
            };
            $.ajax({
                url: "<?php echo site_url('Employee/info_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addinfo_error').show();
                    }
                    if (msg == 'success') {
                        $('#addinfo_error').hide();
                        $('#info_form_button').hide();
                        $('#info_form_next').show();
                        $('#addinfo_success').show();
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
                url: "<?php echo site_url('Employee/background_verification') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addbgverify_error').show();
                    }
                    else {
                        $('#login_details').html(msg);
                    }

                }

            });
        });

        $('#addemployeereference_form').submit(function (e) {
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
                        //  setInterval(function () {
                        $('#ref_table').load(location.href + ' #ref_table tr');
                        //   }, 500);
                        // $('#ref_table tr:last').after('<tr><td>' + prev_cmpref_fullname + '</td><td>' + prev_cmpref_name + '</td><td>' + prev_cmpref_designation + '</td><td>' + prev_cmpref_email + '</td><td>' + prev_cmpref_mobile + '</td><td>' + prev_cmpref_telephone + '</td></tr>');
                    }
                }
            });
        });

        $('#addemployeefresherreference_form').submit(function (e) {
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
                        // setInterval(function () {
                        $('#fresherref_table').load(location.href + ' #fresherref_table tr');
                        //    }, 500);
                        // $('#ref_table tr:last').after('<tr><td>' + prev_cmpref_fullname + '</td><td>' + prev_cmpref_name + '</td><td>' + prev_cmpref_designation + '</td><td>' + prev_cmpref_email + '</td><td>' + prev_cmpref_mobile + '</td><td>' + prev_cmpref_telephone + '</td></tr>');
                    }
                }
            });
        });

    });


</script>

<script type="text/javascript">
    $(document).ready(function (e) {
        $("#addemployeeattachment_form").on('submit', (function (e) {
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
                        // setInterval(function () {
                        $('#document_table').load(location.href + ' #document_table tr');
                        //  }, 500);
                        //    $('#document_table tr:last').after('<tr><td>' + attach_type + '</td><td><a ' + data + ' target="_blank"><i class="entypo-download"></i></a></td></tr>');
                    }
                },
                error: function ()
                {
                }
            });
        }));
    });
</script>

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

</script>



<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>New Employee</h2>
                        </div>

                    </div>

                    <!--<form id="addemployee_form" method="post" action="" class="form-wizard validate">-->
                    <div class="form-wizard">
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
                                <a href="#tab7" data-toggle="tab"><span>7</span>Attachments</a>
                            </li>
                            <li>
                                <a href="#tab8" data-toggle="tab"><span>8</span>Background Verification</a>
                            </li>
                            <li>
                                <a href="#tab9" data-toggle="tab"><span>9</span>Preview</a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="tab1">
                                <h3>Basic Information</h3>
                                <form id="addemployeebasic_form" method="post" class="validate">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="addbasicinfo_success" class="alert alert-success" style="display:none;">Basic information added successfully.</div>
                                            <div id="addbasicinfo_error" class="alert alert-danger" style="display:none;">Failed to add basic information.</div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $emp_id; ?>">
                                    <input type="hidden" id="employee_code" name="employee_code" value="<?php echo $emp_code; ?>">

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Employee Id</label>
                                                <input class="form-control" name="emp_id" id="emp_id" value="<?php echo $emp_code . $emp_id; ?>" disabled="disabled" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">First Name</label>
                                                <input class="form-control" name="first_name" id="first_name" data-validate="required" placeholder="Your Name" data-message-required="Please enter first name."/>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">Middle Name</label>
                                                <input class="form-control" name="middle_name" id="middle_name" placeholder="Your Middle Name" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">Last Name</label>
                                                <input class="form-control" name="last_name" id="last_name" placeholder="Your Last Name" data-validate="required" data-message-required="Please enter last name."/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">Joining Date</label>
                                                <div class="input-group">
                                                    <input type="text" name="joining_date" id="joining_date" class="form-control datepicker" data-format="dd-mm-yyyy" onchange="showperiod()" data-validate="required" data-message-required="Please select date.">
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
                                                <label class="control-label" for="birthdate">Date of Birth</label>
                                                <div class="input-group">
                                                    <input type="text" name="birthdate" id="birthdate" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please enter date of birth.">
                                                    <div class="input-group-addon">
                                                        <a href="#"><i class="entypo-calendar"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label" for="birthdate">Actual Date of Birth</label>
                                                <div class="input-group">
                                                    <input type="text" name="actual_birthdate" id="actual_birthdate" class="form-control datepicker" data-format="dd-mm-yyyy">
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
                                                        <input type="radio" id="male" name="emp_gender" value="Male" checked>
                                                        <label>Male</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="radio radio-replace">
                                                        <input type="radio" id="female" name="emp_gender" value="Female">
                                                        <label>Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Mobile Number</label>
                                                <input class="form-control" name="mobile_number" id="mobile_number" placeholder="Mobile Number" data-validate="required,number" data-message-required="Please enter mobile number." maxlength="15"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Alternate Number</label>
                                                <input class="form-control" name="alternate_number" id="alternate_number" placeholder="Alternate Number" data-validate="number" data-message-required="Please enter mobile number." maxlength="15"/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class='row'>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Official Email Address</label>
                                                <input class="form-control" name="official_email_address" id="official_email_address" placeholder="Email Address" data-validate="email"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Blood Group</label>
                                                <select name="blood_group" id="blood_group" class="round">
                                                    <option value="">Select Blood group</option>
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

                                        <div id="period" style="display: none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Confirmation Period</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" name="confirmation_period" id="3months" value="3" onclick="showconfirmationdate(this.value, $('#joining_date').val())" checked="checked">
                                                            <label>3 Months</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="radio radio-replace">
                                                            <input type="radio" name="confirmation_period" id="6months" value="6" onclick="showconfirmationdate(this.value, $('#joining_date').val())">
                                                            <label>6 Months</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="full_name">Confirmation Date</label>
                                                    <input class="form-control" name="confirmation_date" id="confirmation_date" disabled="disabled" data-validate="required" data-message-required="Please enter confirmation date."/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h3>Bank Information</h3>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Bank Name</label>
                                                <input class="form-control" name="bank_name" id="bank_name"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">Account Number</label>
                                                <input class="form-control" name="acc_no" id="acc_no" data-validate="number"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">IFSC Code</label>
                                                <input class="form-control" name="ifsc_code" id="ifsc_code"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">PAN Card No</label>
                                                <input class="form-control" name="pan_no" id="pan_no"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">UAN Number</label>
                                                <input class="form-control" name="uan_no" id="uan_no"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">PF Number</label>
                                                <input class="form-control" name="pf_no" id="pf_no"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">ESI</label>
                                                <input class="form-control" name="esi" id="esi"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">Medical Insurance</label>
                                                <input class="form-control" name="medical_insurance" id="medical_insurance"/>
                                            </div>
                                        </div>
                                    </div>

                                    <h3>Designation Information</h3>

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">Branch</label>
                                                <select class="round" name="add_emp_branch" id="add_emp_branch" onChange="showDepartment(this);" data-validate="required" data-message-required="Please select branch.">
                                                    <option value="">Please Select</option>
                                                    <?php foreach ($select_branch->result() as $row_branch) { ?>
                                                        <option value="<?php echo $row_branch->Branch_ID; ?>"><?php echo $row_branch->Branch_Name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">Department</label>
                                                <select name="add_emp_department" id="add_emp_department" class="round" onChange="showClient(this);" data-validate="required" data-message-required="Please select department.">
                                                    <option value="">Please Select</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">Process</label>
                                                <select name="add_emp_client" id="add_emp_client" class="round" onChange="showSubprocess(this);" data-validate="required" data-message-required="Please select client.">
                                                    <option value="">Select Process</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Sub Department</label>
                                                <select name="add_emp_subprocess" id="add_emp_subprocess" class="round" onChange="showDesignation(this);" data-validate="required" data-message-required="Please select sub process.">
                                                    <option value="">Please Select</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="full_name">Designation</label>
                                                <select name="add_emp_designation" id="add_emp_designation" class="round" onChange="showGrade(this);" data-validate="required" data-message-required="Please select designation.">
                                                    <option value="">Select Designation</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Grade</label>
                                                <select name="add_emp_grade" id="add_emp_grade" class="round" onChange="showDepartmentRole(this);" data-validate="required" data-message-required="Please select grade.">
                                                    <option value="">Select Grade</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Role</label>
                                                <select name="add_emp_departmentrole" id="add_emp_departmentrole" class="round" data-validate="required" data-message-required="Please select role.">
                                                    <option value="">Select Role</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Reporting To</label>
                                                <select name="reporting_to" id="reporting_to" class="round" data-validate="required" data-message-required="Please select reporting manager.">
                                                    <option value="">Please Select</option>
                                                    <?php foreach ($select_report->result() as $row_report) { ?>
                                                        <option value="<?php echo $row_report->Emp_Number; ?>"><?php echo $row_report->Emp_FirstName . '- ' . $emp_code . $row_report->Emp_Number; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div id="basic_form_button" style="float: right;margin-bottom: 10px">
                                        <button type="submit" class="btn btn-white">Add Info</button>
                                    </div>

                                    <ul class="pager wizard" id="basic_form_next" style="display:none">
                                        <li class="next">
                                            <a href="#">Next <i class="entypo-right-open"></i></a>
                                        </li>
                                    </ul>
                                </form>
                            </div>

                            <div class="tab-pane" id="tab2">
                                <h3>Personal Information</h3>

                                <form id="addemployeelang_form" method="post" class="validate">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="addlang_server_error" class="alert alert-info" style="display:none;"></div>
                                            <div id="addlang_success" class="alert alert-success" style="display:none;">Language added successfully.</div>
                                            <div id="addlang_error" class="alert alert-danger" style="display:none;">Failed to add language.</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang_employee_id" id="lang_employee_id" value="">
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
                                    <table class="table table-bordered" id="lang_table">
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
                                <form id="addemployeepersonal_form" method="post" class="validate">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="addpersonalinfo_success" class="alert alert-success" style="display:none;">Personal details added successfully.</div>
                                            <div id="addpersonalinfo_error" class="alert alert-danger" style="display:none;">Failed to add personal details.</div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="personal_info_employee_id" name="personal_info_employee_id" value="">

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Nationality</label>
                                                <select name="nationality" id="nationality" class="round" data-validate="required" data-message-required="Please select nationality.">
                                                    <option value="">Select Nationality</option>
                                                    <option value="Indian">Indian</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Religion</label>
                                                <select name="religion" id="religion" class="round" data-validate="required" data-message-required="Please select religion.">
                                                    <option value="">Select Religion</option>
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
                                                <input class="form-control" name="caste" id="caste" placeholder="Caste" data-validate="required" data-message-required="Please enter caste." />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Mother Tongue</label>
                                                <input class="form-control" name="mother_tongue" id="mother_tongue" placeholder="Language" data-validate="required" data-message-required="Please enter mother_tongue." />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Blood Group</label>
                                                <select data-message-required="Please select blood group." data-validate="required" class="round" id="personal_blood_group" name="personal_blood_group" aria-required="true" aria-invalid="false">
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
                                                    <input type="text" name="personal_birthdate" id="personal_birthdate" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please select birth date.">
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
                                                    <input type="text" name="personal_actual_birthdate" id="personal_actual_birthdate" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select birth date.">
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
                                                    <option value="">Select Marital Status</option>
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
                                                <input class="form-control" name="emp_mobile_number" id="emp_mobile_number" placeholder="Mobile Number" data-validate="required,number" data-message-required="Please enter mobile number." maxlength="15"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Alternate Number</label>
                                                <input class="form-control" name="emp_alternate_number" id="emp_alternate_number" placeholder="Alternate Number" data-validate="number" data-message-required="Please enter mobile number." maxlength="15"/>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Personal Email Address</label>
                                                <input class="form-control" name="personal_email_address" id="personal_email_address" placeholder="Email Address" data-validate="required,email" data-message-required="Please enter email address." />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Permanent Address</label>
                                                <textarea class="form-control" name="permanent_address" id="permanent_address" placeholder="Permanent Address"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-top: 30px">
                                                <label class="control-label">Same as Permanent Address</label>
                                                <div class="checkbox_outer">
                                                    <input id="same" type="checkbox" name="same" onclick="showpermanentaddress($('#permanent_address').val())"><span></span>
                                                </div> 
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Temporary Address</label>
                                                <textarea class="form-control" name="temporary_address" id="temporary_address" placeholder="Temporary Address"></textarea>
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

                                <form id="addemployeefamily_form" method="post" class="validate">

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
                                        <input type="hidden" name="family_employee_id" id="family_employee_id" value="">

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
                                    <table class="table table-bordered" id="family_table">
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
                                                    $family_dob = $row_family->DOB;
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
                                <form id="addemployeeeducation_form" method="post" class="validate">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="addeducation_server_error" class="alert alert-info" style="display:none;"></div>
                                            <div id="addeducation_success" class="alert alert-success" style="display:none;">Education details added successfully.</div>
                                            <div id="addeducation_error" class="alert alert-danger" style="display:none;">Failed to add education details.</div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="education_employee_id" id="education_employee_id" value="">

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
                                                <input class="form-control" name="year_of_passing" id="year_of_passing" placeholder="Year" data-validate="required,number" data-mask="9999" data-message-required="Please enter year of passing."/>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="margin-top:20px;">
                                            <button class="btn btn-primary" type="submit" id="education_button" name="education_button">Add</button>
                                            <button class="btn btn-default" type="reset">Clear</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="row">
                                    <table class="table table-bordered" id="education_table">
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
                                                        <td><?php echo $education_marks; ?></td>
                                                        <td><?php echo $education_subject; ?></td>
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
                                <form id="addemployeeskills_form" method="post" class="validate">

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
                                        <input type="hidden" name="skills_employee_id" id="skills_employee_id" value="">
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
                                                    <input type="text" name="skill_to" id="skill_to" class="form-control datepicker" data-validate="required" data-message-required="Please enter ending date." data-mask="dd-mm-yyyy" data-format="dd-mm-yyyy" onchange="getMonths(this.value, $('#skill_from').val())">
                                                    <div class="input-group-addon">
                                                        <a href="#"><i class="entypo-calendar"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">No of Months</label>
                                                <input class="form-control" name="no_of_month" id="no_of_month" placeholder="Months" data-validate="required,number"  data-message-required="Please enter months." maxlength="2" disabled="disabled"/>
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
                                    <table class="table table-bordered" id="skill_table">
                                        <thead>
                                            <tr>
                                                <th>Skill Name</th>
                                                <th>No of Months</th>
                                                <th>Training</th>
                                                <th>From</th>
                                                <th>To</th>
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
                                                        <td><?php echo $skill_month; ?></td>
                                                        <td><?php echo $skill_training; ?></td>
                                                        <td><?php echo $skill_from; ?></td>
                                                        <td><?php echo $skill_to; ?></td>
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
                                <form id="addemployeeexp_form" method="post" class="validate">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="addexp_server_error" class="alert alert-info" style="display:none;"></div>
                                            <div id="addexp_success" class="alert alert-success" style="display:none;">Experience details added successfully.</div>
                                            <div id="addexp_error" class="alert alert-danger" style="display:none;">Failed to add experience details.</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="exp_employee_id" id="exp_employee_id" value="">
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
                                    <table class="table table-bordered" id="exp_table">
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

                                    <li class="next">
                                        <a href="#">Next <i class="entypo-right-open"></i></a>
                                    </li>
                                </ul>

                            </div>

                            <div class="tab-pane" id="tab6">
                                <h3>Additional Information</h3>
                                <form id="addemployeeinfo_form" method="post" class="validate">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="addinfo_server_error" class="alert alert-info" style="display:none;"></div>
                                            <div id="addinfo_success" class="alert alert-success" style="display:none;">Additional details added successfully.</div>
                                            <div id="addinfo_error" class="alert alert-danger" style="display:none;">Failed to add additional details.</div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="info_employee_id" id="info_employee_id" value="">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Pan Card No</label>
                                                <input class="form-control" name="pancard_no" id="pancard_no" placeholder="Pan Card No" data-validate="required" data-message-required="Please enter pan card number."/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Aadhar Card No</label>
                                                <input class="form-control" name="aadhar_no" id="aadhar_no" placeholder="Aadhar Card No" data-validate="number" data-message-required="Please enter valid aadhar card number." maxlength="12"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Passport No</label>
                                                <input class="form-control" name="passport_no" id="passport_no" placeholder="Passport Number" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Name On the Passport</label>
                                                <input class="form-control" name="name_on_passport" id="name_on_passport" placeholder="Name" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Place of Issue</label>
                                                <input class="form-control" name="place_issue" id="place_issue" placeholder="Place"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Date of Issue</label>
                                                <div class="input-group">
                                                    <input type="text" name="issue_date" id="issue_date" class="form-control datepicker" data-format="dd-mm-yyyy">
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
                                                    <input type="text" name="expiry_date" id="expiry_date" class="form-control datepicker" data-format="dd-mm-yyyy">
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
                                                        <input type="radio" id="valid_visa_no" name="valid_visa" value="No" checked="checked">
                                                        <label>No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="radio radio-replace">
                                                        <input type="radio" id="valid_visa_yes" name="valid_visa" value="Yes">
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
                                                <input class="form-control" name="issue_country" id="issue_country" placeholder="Country of Issue" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Hobbies</label>
                                                <input class="form-control" name="hobbies" id="hobbies" placeholder="Hobbies" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Interests</label>
                                                <input class="form-control" name="interest" id="interest" placeholder="Interest" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">	
                                            <div class="form-group">
                                                <div class="col-md-12">	
                                                    <label class="control-label">Are you related to any of our employees?</label>
                                                </div>
                                                <div class="col-md-6">	
                                                    <div class="radio radio-replace">
                                                        <input type="radio" id="related_employee_no" name="other_emp_relation" value="No" onclick="show_employee(this.value);" checked>
                                                        <label>No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">	
                                                    <div class="radio radio-replace">
                                                        <input type="radio" id="related_employee_yes" name="other_emp_relation" value="Yes" onclick="show_employee(this.value);">
                                                        <label>Yes</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-3" id="related_emp_name_div" style="display:none">
                                            <div class="form-group">
                                                <label class="control-label">Employee Name</label>
                                                <select name="related_employee_name" id="related_employee_name" class="round" data-validate="required" data-message-required="Please select employee name.">
                                                    <option value="">Please Select</option>
                                                    <?php foreach ($select_report->result() as $row_report) { ?>
                                                        <option value="<?php echo $row_report->Emp_Number; ?>"><?php echo $row_report->Emp_FirstName . "/" . $emp_code . $row_report->Emp_Number; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>	
                                        </div>
                                        <!--                                        <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">Membership of any Professional Institution/Association</label>
                                                                                        <input class="form-control" name="membership" id="membership" placeholder="Membership" />
                                                                                    </div>	
                                                                                </div>-->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Voter Id</label>
                                                <input class="form-control" name="voter_id" id="voter_id" placeholder="Voter Id" />
                                            </div>
                                        </div>
                                    </div>

                                    <h3>Emergency Details</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Allergic To</label>
                                                <input class="form-control" name="allergic" id="allergic" placeholder="Allergic To" />
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Blood Pressure</label>
                                                <input class="form-control" name="blood_pressure" id="blood_pressure" placeholder="Blood Pressure" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Weight</label>
                                                <input class="form-control" name="weight" id="weight" placeholder="Weight"  data-validate="number"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Height</label>
                                                <input class="form-control" name="height" id="height" placeholder="Height" data-validate="number"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Eye Sight</label>
                                                <input class="form-control" name="eye_sight" id="eye_sight" placeholder="Eye Sight" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Any Major Illness</label>
                                                <input class="form-control" name="illness" id="illness" placeholder="Illness" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Contact Person in case of Emergency</label>
                                                <input class="form-control" name="emergency_contactperson_name" id="emergency_contactperson_name" placeholder="Emergency Contact Person Name" data-validate="required" data-message-required="Please enter contact person name." />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Contact Number</label>
                                                <input class="form-control" name="emergency_contact_no" id="emergency_contact_no" placeholder="Contact Number" maxlength="15" data-validate="required,number" data-message-required="Please enter contact number."/>
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
                                <form id="addemployeeattachment_form" method="post" class="validate">
                                    <input type="hidden" name="attachment_employee_id" id="attachment_employee_id" value="">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Type</label>
                                                <select class="round" name="attach_type" id="attach_type" data-validate="required" data-message-required="Please select type.">
                                                    <option value="Degree mark sheets">Degree mark sheets</option>
                                                    <option value="Proof of Birth">Proof of Birth</option>
                                                    <option value="Experience Certificate">Experience Certificate</option>
                                                    <option value="Relieving letter">Relieving letter</option>
                                                    <option value="Last two months pay slips">Last two months pay slips</option>
                                                    <option value="Photocopy of Passport">Photocopy of Passport</option>
                                                    <option value="PAN Card">PAN Card</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">Files</label>
                                            <input type="file" name="attach_file" id="attach_file" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" data-message-required="Please select file."/>
                                        </div>

                                        <div style="margin-top:20px;" class="col-md-3">
                                            <button type="submit" class="btn btn-primary">Upload</button>
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
                                                    $file_url = "http://192.168.12.151:82/TEKES/upload/";
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $document_type; ?></td>
                                                        <td><a href="<?php echo $file_url . $file_name ?>" target="_blank"><i class="entypo-download"></i></a></td>
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


                                <!--                                <div class="row">
                                                                    <input type="hidden" name="bgverify_employee_id" id="bgverify_employee_id" value="">
                                                                    <div class="col-md-4">	
                                                                        <div class="form-group">
                                
                                                                            <div class="col-md-6">	
                                                                                <div class="radio radio-replace">
                                                                                    <input type="radio" value="Fresher" name="career_type" onclick="show_bgverify(this.value)" checked>
                                                                                    <label>Fresher</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">	
                                                                                <div class="radio radio-replace">
                                                                                    <input type="radio" name="career_type" value="Experience" onclick="show_bgverify(this.value)">
                                                                                    <label>Experience</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>-->


                                <div id="fresher_div">
                                    <h4>REFERENCES (2 PERSONAL NON-RELATIONAL CONTACTS)</h4>
                                    <form id="addemployeefresherreference_form" method="post" class="validate">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="addfresherref_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="addfresherref_success" class="alert alert-success" style="display:none;">Reference details added successfully.</div>
                                                <div id="addfresherref_error" class="alert alert-danger" style="display:none;">Failed to add reference details.</div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="fresherref_employee_id" id="fresherref_employee_id" value="">
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
                                                    <input class="form-control" name="reference_person_email" id="reference_person_email" data-validate="required,email" data-message-required="Please enter email address." />
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
                                    <form id="addemployeereference_form" method="post" class="validate">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div id="addref_server_error" class="alert alert-info" style="display:none;"></div>
                                                <div id="addref_success" class="alert alert-success" style="display:none;">Experience details added successfully.</div>
                                                <div id="addref_error" class="alert alert-danger" style="display:none;">Failed to add experience details.</div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="ref_employee_id" id="ref_employee_id" value="">
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
                                                    <input class="form-control" name="prev_cmpref_email" id="prev_cmpref_email" data-validate="required,email" data-message-required="Please enter email address." />
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
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <form id="addemployeebgverify_form" method="post" class="validate">
                                    <div class="row">
                                        <input type="hidden" name="bgverify_employee_id" id="bgverify_employee_id" value="">
                                        <div class="col-md-4">	
                                            <div class="form-group">
                                                <div class="col-md-12">	
                                                    <label class="control-label">Background Verification</label>
                                                </div>
                                                <div class="col-md-6">	
                                                    <div class="radio radio-replace">
                                                        <input type="radio" id="background_verification_no" name="background_verification" value="No" checked>
                                                        <label>No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">	
                                                    <div class="radio radio-replace">
                                                        <input type="radio" id="background_verification_yes" name="background_verification" value="Yes">
                                                        <label>Yes</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <ul class="pager wizard">

                                        <li class="next">
                                            <a href="#" id="background_button">Next <i class="entypo-right-open"></i></a>
                                        </li>
                                    </ul>
                                </form>

                            </div>

                            <div class="tab-pane" id="tab9">
                                <div id="content">
                                    <h2 style="text-align: center">Welcome to DRN Definite Solutions pvt ltd</h2>
                                    <p>DRN Definite Solutions is a global business process Outsourcing Company. We are primarily engaged in providing Mortgage and Technology services, Enterprise application development, Application software for the Financial Services industry and Business process outsourcing. Leading business companies are looking to Streamline and Simplify their operations.</p>
                                    <p>We provide a wide variety of services including Back Office, Research, Finance and Accounting, Contact Center, IT Outsourcing, Healthcare and Logistics Services. We serve a number of industries, where we have developed deep domain expertise including: Technology, Healthcare, Social Media, Research, Financial Services and Services Industries. </p>
                                    <p>Our solutions enable companies to substantially reduce costs to improve margins and conserve cash. We help businesses become more scalable, ramp more efficiently, and get to market faster.</p>
                                    <h3>Our Mission</h3>
                                    <p>Delivering Excellence 24/7, 365 days a year, round the clock.</p>
                                    <h3>Our Vision</h3>
                                    <p>We value our client’s time and each individual’s effort in the business. We work as a team with Integrity, Accountability, Transparency and seamless Communication to ensure Excellent Performance is delivered.</p>
                                    <h3>Registered Successfully!</h3>

                                    <div class="row">
                                        <div class='col-md-12'>
                                            Your details has been registered successfully. You can use the following login credentials.
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">	
                                            <div class="form-group" id='login_details'>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="editor"></div>

                                <div class="row">
                                    <div class="col-md-3">	
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="button" id="download_pdf" onclick="download_pdf()">Download</button>  
                                        </div>
                                    </div>
                                </div>


                            </div>

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

        <!-- Edit Reference Start Here -->

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

        <!-- Edit Reference End Here -->

        <!-- Delete Reference Start Here -->

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

        <!-- Delete Reference End Here -->