<html ng-app="admin">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/bssb_admin.css"/>
    <link rel="stylesheet" type="text/css" href="../css/admin/css/bootstrap.min.css"/>
</head>
<body>
<div id="main-content">
    <div id="main-nav">
        <ul class="nav-menu">
            <li>
                <a ui-sref="dashboard">
                    Registered Users
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">

                    Applicants
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    Under Review
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">

                    Approved
                </a>
            </li>
            <li><a ui-sref="dashboard">
                    Declined
                </a>


            </li>
            <li>
                <a ui-sref="dashboard">
                    Settings
                </a>

            </li>
        </ul>
    </div>
    <div id="content-area">
        <div ui-view>

        </div>
    </div>
</div>


<script src="/js/ext/jquery.js"></script>
<script src="/js/admin/js/bootstrap.js"></script>
<script src="/js/ext/angular-1-2-0.js"></script>
<script src="/js/ext/angular-cookies.js"></script>
<script src="/js/ext/angular-ui-router.js"></script>
<script src="/js/admin.js"></script>
<script>
    $('.view-control').tooltip({
        placement:'left'
    });
</script>
</body>
</html>