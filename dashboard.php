<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Hostel Mess Management System</title>
    <link rel="stylesheet" type="text/css" href="css/dash.css">
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="dashboardMainContainer">
        <div class="dashboard_sidebar">  
            <h3 class="dashboard_logo">Hostel Mess<br><br>Dashboard</h3>
            <div class="dashboard_sidebar_user">
                <i class="fa fa-user-circle" aria-hidden="true"></i>
                <span><?php echo "User"; ?></span>
            </div>
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li class="menuActive">
                        <a href="javascript:void(0);" onclick="loadPage('student_reg.php')"><i class="fa fa-user-circle" aria-hidden="true"></i> Student Registration</a></li>
                    <li><a href="javascript:void(0);" onclick="loadPage('staff_reg.php')"><i class="fa fa-user-circle" aria-hidden="true"></i> Mess Staff Registration</a></li>
                    <li>
                        <a href="javascript:void(0);" onclick="loadPage('bill.php')"><i class="fa fa-inr" aria-hidden="true"></i> Student's Bills</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" onclick="loadPage('trans_history.php')"><i class="fa fa-history" aria-hidden="true"></i> Transaction History</a>
                    </li>
                    <li><a href="javascript:void(0);" onclick="loadPage('inventory.php')"><i class="fa fa-clipboard" aria-hidden="true"></i> Inventory</a></li>
                    <li><a href="javascript:void(0);" onclick="loadPage('studentFeedback.php')"><i class="fa fa-cutlery" aria-hidden="true"></i>Student Feedback</a></li>
                </ul>
            </div>
        </div>
        <div class="dashboard_content_container">
            <div class="dashboard_topNav">
                <a href=""><i class="fa fa-navicon" aria-hidden="true"></i></a>
                <a href="login.php" id="logoutBtn"><i class="fa fa-power-off" aria-hidden="true"></i> Go to home page</a>
            </div>
            <div class="dashboard_content">
                <div class="dashboard_content_main" id="dashboardContentMain">
                </div>
            </div>
        </div>
    </div>
    <script> 
        function loadPage(pageUrl) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', pageUrl, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('dashboardContentMain').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
