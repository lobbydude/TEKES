<?php
$this->db->order_by('User_id', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_user');

$select_company = $this->db->get('tbl_company');
$select_country = $this->db->get('tbl_countries');
?>


<script>
    function edit_User(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('User/Edituser') ?>",
            data: "emp_id=" + id,
            cache: false,
            success: function (html) {
                $("#edituser_form").html(html);
            }
        });
    }

    function delete_User(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('User/Deleteuser') ?>",
            data: "emp_id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteuser_form").html(html);
            }
        });
    }

</script>

<script>
    $(document).ready(function () {
        $('#addbranch_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                company_name: $('#company_name').val(),
                branch_name: $('#branch_name').val(),
                branch_code: $('#branch_code').val(),
                branch_address: $('#branch_address').val(),
                country: $('#country').val(),
                state: $('#state').val(),
                district: $('#district').val(),
                branch_city: $('#branch_city').val(),
                branch_pincode: $('#branch_pincode').val(),
                branch_telno: $('#branch_telno').val(),
                branch_fax: $('#branch_fax').val(),
                branch_email: $('#branch_email').val(),
                branch_website: $('#branch_website').val()
            };
            $.ajax({
                url: "<?php echo site_url('Company/add_branch') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addbranch_error').show();
                    }
                    if (msg == 'success') {
                        $('#addbranch_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#addbranch_server_error').html(msg);
                        $('#addbranch_server_error').show();
                    }
                }

            });
        });
    });

</script>


<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Users</h2>
                        </div>
                    </div>

                    <!-- User Table Format Start Here -->

                    <table class="table table-bordered datatable" id="user_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Id</th>
                                <th>Employee Name</th>
                                <th>Branch Name</th>
                                <th>Role</th>
                                <th>Mobile</th>
                                <th>Email Address</th>
                                <th>Photo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $user_id = $row->User_id;
                                $user_role_id = $row->User_RoleId;

                                $this->db->where('Role_Id', $user_role_id);
                                $q_userrole = $this->db->get('tbl_user_role');
                                foreach ($q_userrole->result() as $row_userrole) {
                                    $role_name = $row_userrole->Role_Name;
                                }

                                $Emp_Photo = $row->User_Photo;
                                $emp_no = $row->Employee_Id;

                                $this->db->where('employee_number', $emp_no);
                                $q_code = $this->db->get('tbl_emp_code');
                                foreach ($q_code->result() as $row_code) {
                                    $emp_code = $row_code->employee_code;
                                }

                                $this->db->where('Emp_Number', $emp_no);
                                $q_employee = $this->db->get('tbl_employee');
                                foreach ($q_employee->result() as $row_employee) {
                                    $Emp_FirstName = $row_employee->Emp_FirstName;
                                    $Emp_Middlename = $row_employee->Emp_MiddleName;
                                    $Emp_LastName = $row_employee->Emp_LastName;
                                    $Emp_Contact = $row_employee->Emp_Contact;
                                }

                                $this->db->where('Employee_Id', $emp_no);
                                $q_career = $this->db->get('tbl_employee_career');
                                foreach ($q_career->Result() as $row_career) {
                                    $branch_id = $row_career->Branch_Id;
                                    $department_id = $row_career->Department_Id;
                                    $designation_id = $row_career->Designation_Id;
                                }

                                $this->db->where('Designation_Id', $designation_id);
                                $q_designation = $this->db->get('tbl_designation');
                                foreach ($q_designation->result() as $row_designation) {
                                    $designation_name = $row_designation->Designation_Name;
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

                                $this->db->where('Employee_Id', $emp_no);
                                $select_personal = $this->db->get('tbl_employee_personal');
                                $count_personal = $select_personal->num_rows();
                                $Emp_PersonalEmail = "";
                                if ($count_personal > 0) {
                                    foreach ($select_personal->result() as $row_personal) {
                                        $Emp_PersonalEmail = $row_personal->Emp_PersonalEmail;
                                    }
                                }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $emp_code . $emp_no; ?></td>
                                    <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                    <td><?php echo $branch_name; ?></td>
                                    <td><?php echo $role_name; ?></td>
                                    <td><?php echo $Emp_Contact; ?></td>
                                    <td><?php echo $Emp_PersonalEmail; ?></td>
                                    <td><img src="<?php echo site_url('user_img/' . $Emp_Photo); ?>" style="width:80px;height:80px"></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_user' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_User('<?php echo $emp_no; ?>')">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_user' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_User('<?php echo $emp_no; ?>')">
                                            <i class="entypo-cancel"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>

                    </table>

                    <!-- User Table Format End Here -->
                </div>
            </div>
        </section>


        <!-- Edit User Start Here -->

        <div class="modal fade custom-width" id="edit_user">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit User</h3>
                    </div>
                    <form role="form" id="edituser_form" name="edituser_form" method="post" class="validate" enctype="multipart/form-data" action="<?php echo site_url('User/edit_user') ?>">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit User End Here -->

        <!-- Delete User Start Here -->

        <div class="modal fade" id="delete_user">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete User</h3>
                    </div>
                    <form role="form" id="deleteuser_form" name="deleteuser_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete User End Here -->

        <!-- Table Script -->
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($)
            {
                tableContainer = $("#user_table");

                tableContainer.dataTable({
                    "sPaginationType": "bootstrap",
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "bStateSave": true,
                    // Responsive Settings
                    bAutoWidth: false,
                    fnPreDrawCallback: function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper) {
                            responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
                        }
                    },
                    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        responsiveHelper.createExpandIcon(nRow);
                    },
                    fnDrawCallback: function (oSettings) {
                        responsiveHelper.respond();
                    }
                });

                $(".dataTables_wrapper select").select2({
                    minimumResultsForSearch: -1
                });
            });
        </script>

