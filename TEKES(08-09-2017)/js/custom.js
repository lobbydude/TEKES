function showState(sel) {
    var country_id = sel.options[sel.selectedIndex].value;
    $(".state_new").html("");
    $(".district_new").html("");
    if (country_id.length > 0) {
        $.ajax({
            type: "POST",
            url: "http://localhost:1234/payroll/Profile/fetch_state",
            data: "country_id=" + country_id,
            cache: false,
            success: function (msg) {
                alert(msg);
                $("#state").html(msg);
            }
        });
    }
}

function showDistrict(sel) {
    var state_id = sel.options[sel.selectedIndex].value;
    if (state_id.length > 0) {
        $.ajax({
            type: "POST",
            url: "http://localhost:1234/payroll/Profile/fetch_district",
            data: "state_id=" + state_id,
            cache: false,
            success: function (html) {
                $("#district").html(html);
            }
        });
    }
}


function showDepartment(sel) {
    var branch_id = sel.options[sel.selectedIndex].value;
    if (branch_id.length > 0) {
        $.ajax({
            type: "POST",
            url: "http://localhost:1234/payroll/Profile/fetch_department",
            data: "branch_id=" + branch_id,
            cache: false,
            success: function (html) {
                $("#department_name").html(html);
            }
        });
    }
}

function showSubdepartment(sel) {
    var dept_id = sel.options[sel.selectedIndex].value;
    if (dept_id.length > 0) {
        $.ajax({
            type: "POST",
            url: "http://localhost:1234/payroll/Profile/fetch_subdepartment",
            data: "dept_id=" + dept_id,
            cache: false,
            success: function (html) {
                $("#subdepartment_name").html(html);
            }
        });
    }
}

function showDesignation(sel) {
    var sub_dept_id = sel.options[sel.selectedIndex].value;
    if (sub_dept_id.length > 0) {
        $.ajax({
            type: "POST",
            url: "http://localhost:1234/payroll/Profile/fetch_designation",
            data: "subdept_id=" + sub_dept_id,
            cache: false,
            success: function (html) {
                $("#designation_name").html(html);
            }
        });
    }
}
