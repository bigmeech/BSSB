<html ng-app="admin">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/bssb_admin.css"/>
</head>
<body>
<div id="main-nav">
    <ul class="nav-menu">
        <li>
            <a ui-sref="dashboard">
                <span class="pictogram users">
                    &#128101;
                </span>
                Registered Users
            </a>
        </li>
        <li>
            <span class="pictogram applicants">
                &#127891;
            </span>
            Applicants
        </li>
        <li>
            <span class="pictogram under-review">
                &#59146;
            </span>
            Under Review
        </li>
        <li>
            <span class="pictogram approved">
                &#128077;
            </span>
            Approved
        </li>
        <li>
            <span class="pictogram declined">
                &#128078;
            </span>
            Declined
        </li>
        <li>
            <span class="pictogram settings">
                &#9874;
            </span>
            Settings
        </li>
    </ul>
</div>
<div id="content-area">
    <div ui-view>

    </div>
</div>
<script src="/js/ext/jquery.js"></script>
<script src="/js/ext/angular-1-2-0.js"></script>
<script src="/js/ext/angular-cookies.js"></script>
<script src="/js/ext/angular-ui-router.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>