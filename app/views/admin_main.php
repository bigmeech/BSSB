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
                    <span class="glyphicon glyphicon-th-large"></span>&nbsp;Dashboard
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    <span class="glyphicon glyphicon-user"></span>&nbsp;Registered Users
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    <span class="glyphicon glyphicon-check"></span>&nbsp;Applicants
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Under Review
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    <span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;Approved
                </a>
            </li>
            <li><a ui-sref="dashboard">
                    <span class="glyphicon glyphicon-thumbs-down"></span>&nbsp;Declined
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    <span class="glyphicon glyphicon-th-list"></span>&nbsp;Settings
                </a>
            </li>
            <li style="border-top: 1px dashed #999;color: #005580">
                <a ui-sref="dashboard">
                    <span class="glyphicon glyphicon-log-out"></span>&nbsp;Log out
                </a>
            </li>
        </ul>
    </div>
    <div id="content-area">
        <div ui-view>

        </div>
    </div>
</div>
<div class="modal" id="sendNotificationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #eee">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Send out Notifications</h4>
            </div>
            <div class="modal-body">
                <textarea class="form-control" rows="7"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send Now</button>
            </div>
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
        placement:'bottom'
    });
</script>
</body>
</html>